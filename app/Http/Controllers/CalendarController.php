<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interview;
use App\Models\Leave;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar.index', [
            'catName' => 'calendar',
            'title' => 'Company Calendar',
            'breadcrumbs' => ['Dashboard', 'Calendar'],
            'scrollspy' => 0,
            'simplePage' => 0
        ]);
    }

    public function events()
    {
        $events = [];

        // 1. Fetch Interviews
        $interviews = Interview::with(['application.candidate', 'application.job'])->get();
        foreach ($interviews as $interview) {
            $events[] = [
                'id' => 'interview_' . $interview->id,
                'title' => 'Interview: ' . ($interview->application?->candidate?->name ?? 'Unknown'),
                'start' => $interview->date . 'T' . $interview->time,
                'className' => 'bg-primary',
                'description' => ($interview->application?->job?->title ?? 'N/A') . ' with ' . $interview->interviewer?->name,
                'type' => 'interview'
            ];
        }

        // 2. Fetch Approved Leaves
        $leaves = Leave::with('user')->where('status', 'Approved')->get();
        foreach ($leaves as $leave) {
            $events[] = [
                'id' => 'leave_' . $leave->id,
                'title' => 'Leave: ' . $leave->user->name,
                'start' => $leave->from_date,
                'end' => Carbon::parse($leave->to_date)->addDay()->format('Y-m-d'), // End date is exclusive in FullCalendar
                'className' => 'bg-success',
                'description' => $leave->reason,
                'type' => 'leave'
            ];
        }

        return response()->json($events);
    }
}
