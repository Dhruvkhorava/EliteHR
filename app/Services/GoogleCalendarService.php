<?php

namespace App\Services;

use Carbon\Carbon;

class GoogleCalendarService
{
    protected $service;
    protected $calendarId;

    public function __construct()
    {
        $client = new \Google_Client();
        $client->setAuthConfig(storage_path('app/google-credentials.json.json'));
        $client->setScopes([\Google_Service_Calendar::CALENDAR]);

        // Fix SSL on WAMP/Windows
        $caCertPath = storage_path('app/cacert.pem');
        if (file_exists($caCertPath)) {
            $httpClient = new \GuzzleHttp\Client(['verify' => $caCertPath]);
            $client->setHttpClient($httpClient);
        }

        $this->service = new \Google_Service_Calendar($client);

        // The Google Calendar ID where leave events will be added.
        // This is the calendar shared with the service account.
        // Defaults to the service account's own primary calendar.
        $this->calendarId = config('services.google_calendar.calendar_id', 'primary');
    }

    /**
     * Create a Google Calendar event for a leave application.
     */
    public function createLeaveEvent(string $employeeName, string $leaveType, string $fromDate, string $toDate, string $reason, string $status = 'Pending'): ?string
    {
        try {
            $event = new \Google_Service_Calendar_Event([
                'summary' => "Leave: {$employeeName} ({$leaveType})",
                'description' => "Employee: {$employeeName}\nLeave Type: {$leaveType}\nStatus: {$status}\nReason: {$reason}",
                'start' => [
                    'date' => Carbon::parse($fromDate)->format('Y-m-d'), // All-day event
                ],
                'end' => [
                    'date' => Carbon::parse($toDate)->addDay()->format('Y-m-d'), // Exclusive end date
                ],
                'colorId' => '5', // Yellow = pending
            ]);

            $createdEvent = $this->service->events->insert($this->calendarId, $event);
            return $createdEvent->getId(); // Return Google event ID for potential future updates
        } catch (\Exception $e) {
            \Log::warning('Google Calendar leave event creation failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Update an existing Google Calendar event (e.g., when leave is approved/rejected).
     */
    public function updateLeaveEvent(string $googleEventId, string $status): void
    {
        try {
            $event = $this->service->events->get($this->calendarId, $googleEventId);

            // Update color based on status
            $colorId = '5'; // yellow = pending
            if ($status === 'Approved') $colorId = '10'; // green
            if ($status === 'Rejected') $colorId = '11'; // red

            $description = $event->getDescription();
            $description = preg_replace('/Status: .+/', "Status: {$status}", $description);

            $event->setDescription($description);
            $event->setColorId($colorId);

            $this->service->events->update($this->calendarId, $googleEventId, $event);
        } catch (\Exception $e) {
            \Log::warning('Google Calendar leave event update failed: ' . $e->getMessage());
        }
    }

    /**
     * Delete a Google Calendar event.
     */
    public function deleteLeaveEvent(string $googleEventId): void
    {
        try {
            $this->service->events->delete($this->calendarId, $googleEventId);
        } catch (\Exception $e) {
            \Log::warning('Google Calendar leave event deletion failed: ' . $e->getMessage());
        }
    }
}
