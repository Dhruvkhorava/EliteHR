<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interview;
use App\Models\Leave;
use App\Models\CalendarEvent;
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
            $description = "<strong>Candidate:</strong> " . ($interview->application?->candidate?->name ?? 'Unknown') . "<br>" .
                           "<strong>Job:</strong> " . ($interview->application?->job?->title ?? 'N/A') . "<br>" .
                           "<strong>Interviewer:</strong> " . ($interview->interviewer?->name ?? 'N/A') . "<br>" .
                           "<strong>Level:</strong> " . $interview->level;

            $events[] = [
                'id' => 'interview_' . $interview->id,
                'title' => 'Interview: ' . ($interview->application?->candidate?->name ?? 'Unknown'),
                'start' => $interview->date . 'T' . $interview->time,
                'className' => 'fc-bg-info',
                'description' => $description,
                'type' => 'interview'
            ];
        }

        // 2. Fetch All Leaves
        $leaves = Leave::with(['user', 'leaveType'])->get();
        foreach ($leaves as $leave) {
            $colorClass = 'fc-bg-warning'; // Pending
            if ($leave->status === 'Approved') $colorClass = 'fc-bg-success';
            if ($leave->status === 'Rejected') $colorClass = 'fc-bg-danger';

            $description = "<strong>Employee:</strong> " . ($leave->user->name ?? 'Unknown') . "<br>" .
                           "<strong>Type:</strong> " . ($leave->leaveType->name ?? 'N/A') . "<br>" .
                           "<strong>Status:</strong> " . $leave->status . "<br>" .
                           "<strong>Duration:</strong> " . $leave->total_days . " days<br>" .
                           "<strong>Reason:</strong> " . $leave->reason;

            $events[] = [
                'id' => 'leave_' . $leave->id,
                'title' => 'Leave: ' . ($leave->user->name ?? 'Unknown'),
                'start' => $leave->from_date,
                'end' => Carbon::parse($leave->to_date)->addDay()->format('Y-m-d'), // End date is exclusive in FullCalendar
                'className' => $colorClass,
                'description' => $description,
                'type' => 'leave'
            ];
        }

        // 3. Fetch Custom Calendar Events
        $customEvents = CalendarEvent::where('user_id', auth()->id())->get();
        foreach ($customEvents as $customEvent) {
             // Map category to color class
             $colorClass = 'fc-bg-primary'; // default Work
             if ($customEvent->category === 'Personal') $colorClass = 'fc-bg-success';
             if ($customEvent->category === 'Important') $colorClass = 'fc-bg-danger';
             if ($customEvent->category === 'Travel') $colorClass = 'fc-bg-warning';

            $events[] = [
                'id' => $customEvent->id, 
                'title' => $customEvent->title,
                'start' => Carbon::parse($customEvent->start_date)->toIso8601String(),
                'end' => $customEvent->end_date ? Carbon::parse($customEvent->end_date)->toIso8601String() : null,
                'className' => $colorClass,
                'category' => $customEvent->category, // for the radio buttons
                'type' => 'custom',
                'description' => $customEvent->description
            ];
        }

        // 4. Fetch Indian Public Holidays from Google Calendar API
        try {
            $gclient = new \Google_Client();
            $gclient->setAuthConfig(storage_path('app/google-credentials.json.json'));
            $gclient->setScopes([\Google_Service_Calendar::CALENDAR_READONLY]);

            // Fix SSL on WAMP/Windows
            $caCertPath = storage_path('app/cacert.pem');
            if (file_exists($caCertPath)) {
                $httpClient = new \GuzzleHttp\Client(['verify' => $caCertPath]);
                $gclient->setHttpClient($httpClient);
            }

            $gservice = new \Google_Service_Calendar($gclient);

            $year = Carbon::now()->year;
            $optParams = [
                'maxResults' => 100,
                'orderBy' => 'startTime',
                'singleEvents' => true,
                'timeMin' => date('c', mktime(0, 0, 0, 1, 1, $year)),   // Jan 1 of current year
                'timeMax' => date('c', mktime(23, 59, 59, 12, 31, $year)), // Dec 31 of current year
            ];

            // India public holidays - public Google Calendar ID
            $holidayCalendarId = 'en.indian#holiday@group.v.calendar.google.com';
            $holidayEvents = $gservice->events->listEvents($holidayCalendarId, $optParams);

            foreach ($holidayEvents->getItems() as $holiday) {
                $start = $holiday->start->dateTime ?: $holiday->start->date;
                $description = "<strong>🎉 " . $holiday->getSummary() . "</strong><br>" .
                               "<strong>Date:</strong> " . Carbon::parse($start)->format('d M Y') . "<br>" .
                               "<strong>Type:</strong> Indian Public Holiday";

                $events[] = [
                    'id' => 'gcal_holiday_' . md5($holiday->getId()),
                    'title' => '🎉 ' . $holiday->getSummary(),
                    'start' => $start,
                    'className' => 'fc-bg-secondary',
                    'description' => $description,
                    'type' => 'holiday'
                ];
            }
        } catch (\Exception $e) {
            // Silently fail — calendar still loads without holidays
            \Log::warning('Google Calendar holiday fetch failed: ' . $e->getMessage());
        }

        return response()->json($events);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'category' => 'nullable|string|in:Work,Personal,Important,Travel',
            'description' => 'nullable|string',
        ]);

        $event = CalendarEvent::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'start_date' => Carbon::parse($request->start_date)->format('Y-m-d H:i:s'),
            'end_date' => $request->end_date ? Carbon::parse($request->end_date)->format('Y-m-d H:i:s') : null,
            'category' => $request->category ?? 'Work',
            'description' => $request->description,
        ]);

        return response()->json(['success' => true, 'event' => $event]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'category' => 'nullable|string|in:Work,Personal,Important,Travel',
            'description' => 'nullable|string',
        ]);

        $event = CalendarEvent::where('user_id', auth()->id())->findOrFail($id);

        $event->update([
            'title' => $request->title,
            'start_date' => Carbon::parse($request->start_date)->format('Y-m-d H:i:s'),
            'end_date' => $request->end_date ? Carbon::parse($request->end_date)->format('Y-m-d H:i:s') : null,
            'category' => $request->category ?? 'Work',
            'description' => $request->description,
        ]);

        return response()->json(['success' => true, 'event' => $event]);
    }

    public function destroy($id)
    {
        $event = CalendarEvent::where('user_id', auth()->id())->findOrFail($id);
        $event->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Google Calendar Integration:
     * 1st API to get all calendars
     * 2nd string owner calendar record
     * 3rd get calendar events by id
     */
    public function getGoogleCalendarEvents()
    {
        // Require Google API Client
        $client = new \Google_Client();
        $client->setApplicationName('EliteHR Google Calendar Sync');
        $client->setScopes([\Google_Service_Calendar::CALENDAR]);
        
        // Ensure you have credentials saved in this path:
        $credentialsPath = storage_path('app/google-credentials.json.json');
        if (!file_exists($credentialsPath)) {
            return response()->json(['error' => 'Google credentials file not found. Expected at: storage/app/google-credentials.json.json'], 404);
        }
        $client->setAuthConfig($credentialsPath);
        
        // Fix SSL certificate issue on WAMP/Windows local dev
        $caCertPath = storage_path('app/cacert.pem');
        if (file_exists($caCertPath)) {
            $httpClient = new \GuzzleHttp\Client(['verify' => $caCertPath]);
            $client->setHttpClient($httpClient);
        }

        $service = new \Google_Service_Calendar($client);

        try {
            // 1st API: Get all calendars accessible by the service account
            $calendarList = $service->calendarList->listCalendarList();
            
            $ownerCalendarId = null;

            // 2nd API: By using owner calendar 1 record get calendar id
            foreach ($calendarList->getItems() as $calendarListEntry) {
                if ($calendarListEntry->getAccessRole() === 'owner') {
                    $ownerCalendarId = $calendarListEntry->getId();
                    break; // Get the first owner calendar
                }
            }

            if (!$ownerCalendarId) {
                return response()->json(['error' => 'No owner calendar found.'], 404);
            }

            // 3rd API: Get calendar events by id
            $optParams = array(
                'maxResults' => 100, // Number of events to fetch
                'orderBy' => 'startTime',
                'singleEvents' => true,
                'timeMin' => date('c', strtotime('-1 month')), // Fetch events from 1 month ago
            );
            $events = $service->events->listEvents($ownerCalendarId, $optParams);
            
            $eventsFormatted = [];
            foreach ($events->getItems() as $event) {
                $start = $event->start->dateTime;
                if (empty($start)) {
                    $start = $event->start->date;
                }
                
                $eventsFormatted[] = [
                    'id' => $event->getId(),
                    'title' => $event->getSummary(),
                    'start' => $start,
                    'description' => $event->getDescription(),
                    'status' => $event->getStatus()
                ];
            }

            return response()->json([
                'success' => true,
                'calendar_id' => $ownerCalendarId,
                'events' => $eventsFormatted
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Google API Error: ' . $e->getMessage()], 500);
        }
    }
}
