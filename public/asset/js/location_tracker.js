(function() {
    'use strict';

    const indicator = document.getElementById('sync-indicator');
    const statusText = document.getElementById('sync-status-text');
    const statusBox = indicator ? indicator.querySelector('.sync-status-box') : null;

    function sendLocation() {
        if (!navigator.geolocation) {
            console.warn('Geolocation is not supported by your browser.');
            return;
        }

        if (indicator) indicator.style.display = 'block';

        navigator.geolocation.getCurrentPosition(function(position) {
            const data = {
                latitude: position.coords.latitude,
                longitude: position.coords.longitude,
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            };

            fetch(window.appData.recordLocationUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': data._token
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.status === 'success') {
                    if (statusText) statusText.innerText = 'Sync Successful';
                    if (statusBox) statusBox.classList.add('success');
                    
                    // Hide indicator after 4 seconds of success
                    setTimeout(() => {
                        if (indicator) indicator.style.opacity = '0';
                        setTimeout(() => { if (indicator) indicator.style.display = 'none'; }, 500);
                    }, 4000);
                }
            })
            .catch(error => {
                console.error('Error sending location:', error);
                if (statusText) statusText.innerText = 'Sync failed. Retrying...';
            });
        }, function(error) {
            console.error('Geolocation error:', error.message);
            if (statusText) statusText.innerText = 'GPS access denied or unavailable.';
        }, {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        });
    }

    // Initial send
    sendLocation();

    // Repeat every 2 minutes (120000 ms) to balance battery and accuracy
    setInterval(sendLocation, 120000);
})();
