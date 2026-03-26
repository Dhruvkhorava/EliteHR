<?php
require 'D:/wamp64/www/EliteHR/vendor/autoload.php';

$client = new Google_Client();
$client->setAuthConfig('D:/wamp64/www/EliteHR/storage/app/google-credentials.json.json');
$client->setScopes([Google_Service_Calendar::CALENDAR]);
$httpClient = new GuzzleHttp\Client(['verify' => 'D:/wamp64/www/EliteHR/storage/app/cacert.pem']);
$client->setHttpClient($httpClient);
$service = new Google_Service_Calendar($client);

// List all calendars the service account has access to
echo "=== Calendars accessible by service account ===\n";
$list = $service->calendarList->listCalendarList();
foreach($list->getItems() as $c) {
    echo $c->getSummary() . ' | ' . $c->getId() . ' | ' . $c->getAccessRole() . "\n";
}

// Also try creating test event on primary
echo "\n=== Creating TEST event on primary ===\n";
try {
    $event = new Google_Service_Calendar_Event([
        'summary' => 'TEST LEAVE - Delete Me',
        'start' => ['date' => '2026-03-26'],
        'end' => ['date' => '2026-03-27'],
    ]);
    $created = $service->events->insert('primary', $event);
    echo "Created event ID: " . $created->getId() . "\n";
    echo "Event link: " . $created->getHtmlLink() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
