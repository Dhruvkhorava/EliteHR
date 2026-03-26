<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Candidate;
use App\Models\RecruitmentJob;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function unifiedSearch(Request $request)
    {
        $query = strtolower($request->get('query'));
        
        if (!$query) {
            return response()->json([]);
        }

        // Fuzzy search helper
        $isFuzzyMatch = function($text) use ($query) {
            $text = strtolower($text);
            if (strpos($text, $query) !== false) return true;
            $len = strlen($query);
            if ($len < 3) return false;
            // Handle typos using Levenshtein (threshold of 2-3 depending on length)
            $threshold = $len > 6 ? 3 : 2;
            foreach (explode(' ', $text) as $word) {
                if (levenshtein($word, $query) <= $threshold) return true;
            }
            return false;
        };

        $employees = User::all()->filter(function($user) use ($isFuzzyMatch) {
            return $isFuzzyMatch($user->name) || $isFuzzyMatch($user->email);
        })->take(5)->map(function($user) {
            return [
                'type' => 'Employee',
                'title' => $user->name,
                'subtitle' => $user->email,
                'url' => route('employees.show', $user->id),
                'icon' => 'user'
            ];
        });

        $candidates = Candidate::all()->filter(function($candidate) use ($isFuzzyMatch) {
            return $isFuzzyMatch($candidate->name) || $isFuzzyMatch($candidate->email);
        })->take(5)->map(function($candidate) {
            return [
                'type' => 'Candidate',
                'title' => $candidate->name,
                'subtitle' => $candidate->email,
                'url' => route('recruitment.candidates.show', $candidate->id),
                'icon' => 'users'
            ];
        });

        $jobs = RecruitmentJob::all()->filter(function($job) use ($isFuzzyMatch) {
            return $isFuzzyMatch($job->title) || $isFuzzyMatch($job->department);
        })->take(5)->map(function($job) {
            return [
                'type' => 'Job',
                'title' => $job->title,
                'subtitle' => $job->department,
                'url' => route('recruitment.jobs.show', $job->id),
                'icon' => 'briefcase'
            ];
        });

        return response()->json([
            'results' => $employees->concat($candidates)->concat($jobs)->values()
        ]);
    }
}
