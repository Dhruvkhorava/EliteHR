@extends('layouts.app')

@section('content')
<div class="layout-px-spacing map-full-mode">
    <div class="middle-content container-xxl p-0">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-spacing">
                <div class="widget map-main-widget">
                    
                    <div class="widget-content position-relative">
                        <!-- Right-side Overlay Panel -->
                        <div class="map-overlay-panel shadow-lg">
                            <!-- Summary Stats -->
                            <div class="panel-header d-flex justify-content-around p-3 border-bottom">
                                <div class="stat-item text-center">
                                    <div class="d-flex align-items-center">
                                        <span class="dot dot-success mr-2"></span>
                                        <h6 class="mb-0 fw-700" id="online-count">0</h6>
                                        <i class="far fa-user ml-1 small text-muted"></i>
                                    </div>
                                </div>
                                <div class="stat-item text-center border-left pl-3">
                                    <div class="d-flex align-items-center">
                                        <span class="dot dot-grey mr-2"></span>
                                        <h6 class="mb-0 fw-700" id="total-count">0</h6>
                                        <i class="far fa-user ml-1 small text-muted"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Search -->
                            <div class="search-container p-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-transparent border-right-0"><i class="fas fa-search text-muted"></i></span>
                                    </div>
                                    <input type="text" id="staff-search" class="form-control border-left-0 pl-0" placeholder="Search employee...">
                                </div>
                            </div>

                            <!-- Employee List -->
                            <div class="staff-scroll-list" id="staff-list">
                                <!-- Items injected here -->
                                <div class="text-center p-5">
                                    <div class="spinner-border text-primary" role="status"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Map Controls (Floating) -->
                        <div class="map-action-controls">
                            <button id="refreshBtn" class="btn btn-white shadow-sm rounded-circle p-2">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>

                        <!-- Map Container -->
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    .map-full-mode .middle-content { max-width: 100% !important; }
    
    .map-main-widget {
        border-radius: 24px;
        overflow: hidden;
        border: none;
        background: #fff;
    }

    #map {
        height: 750px;
        width: 100%;
        background: #f8f9fa;
        z-index: 1;
    }

    /* Right Overlay Panel */
    .map-overlay-panel {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 340px;
        background: #ffffff;
        border-radius: 20px;
        z-index: 1000;
        max-height: calc(100% - 40px);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .dot { height: 10px; width: 10px; border-radius: 50%; display: inline-block; }
    .dot-success { background-color: #4cd964; }
    .dot-grey { background-color: #8e8e93; }

    .staff-scroll-list {
        overflow-y: auto;
        flex-grow: 1;
        padding: 0 10px 20px;
    }

    /* Staff Item Styling */
    .staff-item {
        display: flex;
        align-items: center;
        padding: 15px 12px;
        border-radius: 16px;
        cursor: pointer;
        transition: 0.2s;
        margin-bottom: 5px;
    }
    .staff-item:hover { background: #f8f9fa; }

    .staff-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 12px;
    }

    .staff-info { flex-grow: 1; min-width: 0; }
    .staff-info h6 { 
        font-size: 0.9rem; 
        font-weight: 600; 
        margin-bottom: 4px; 
        white-space: nowrap; 
        overflow: hidden; 
        text-overflow: ellipsis;
        color: #1b2e4b;
    }
    
    /* Progress Bar */
    .staff-progress {
        height: 6px;
        width: 80px;
        background: #f1f2f3;
        border-radius: 10px;
        margin-bottom: 2px;
    }
    .progress-fill {
        height: 100%;
        border-radius: 10px;
    }

    .staff-time {
        text-align: right;
        font-size: 0.7rem;
        color: #888ea8;
        min-width: 60px;
    }

    /* Custom Photo Markers with Tails */
    .custom-photo-marker {
        position: relative;
        width: 40px;
        height: 40px;
        filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
    }
    .avatar-wrapper {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 3px solid #4cd964; /* Green border for online */
        background: #fff;
        overflow: hidden;
        position: relative;
        z-index: 2;
    }
    .avatar-wrapper.offline { border-color: #8e8e93; }
    
    .marker-avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .marker-tail {
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-left: 8px solid transparent;
        border-right: 8px solid transparent;
        border-top: 10px solid #4cd964;
        z-index: 1;
    }
    .avatar-wrapper.offline + .marker-tail { border-top-color: #8e8e93; }

    .map-action-controls {
        position: absolute;
        bottom: 30px;
        right: 380px;
        z-index: 1000;
    }

    /* Leaflet Overrides */
    .leaflet-bar { border: none !important; box-shadow: 0 4px 12px rgba(0,0,0,0.08) !important; }
    .leaflet-bar a { border-radius: 10px !important; margin-bottom: 5px; }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const colors = ['#ff2d55', '#ff9500', '#4cd964', '#5ac8fa', '#007aff'];
        
        // Initialize Map
        const map = L.map('map', {
            zoomControl: true,
            attributionControl: false
        }).setView([20.5937, 78.9629], 5);

        // Minimalist Map Style
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}{r}.png', {
            subdomains: 'abcd',
            maxZoom: 20
        }).addTo(map);

        let markers = {};
        const staffList = document.getElementById('staff-list');
        const onlineCount = document.getElementById('online-count');
        const totalCount = document.getElementById('total-count');

        function updateUI() {
            fetch("{{ route('attendance.live.data') }}")
                .then(response => response.json())
                .then(data => {
                    const users = data.users;
                    onlineCount.innerText = data.stats.online;
                    totalCount.innerText = data.stats.total;
                    
                    staffList.innerHTML = '';

                    users.forEach((user, index) => {
                        const lat = parseFloat(user.latitude);
                        const lng = parseFloat(user.longitude);
                        const color = colors[index % colors.length];

                        // 1. Update Map Markers (Only if online/has coordinates)
                        if (lat && lng) {
                            const markerHtml = `
                                <div class="custom-photo-marker">
                                    <div class="avatar-wrapper ${user.is_online ? '' : 'offline'}">
                                        <img src="${user.image}" class="marker-avatar">
                                    </div>
                                    <div class="marker-tail"></div>
                                </div>
                            `;

                            const icon = L.divIcon({
                                className: '',
                                html: markerHtml,
                                iconSize: [40, 48],
                                iconAnchor: [20, 48]
                            });

                            if (markers[user.id]) {
                                markers[user.id].setLatLng([lat, lng]);
                                markers[user.id].setIcon(icon);
                                markers[user.id].getPopup().setContent(`<strong>${user.name}</strong><br>${user.designation}`);
                            } else {
                                const marker = L.marker([lat, lng], { icon: icon }).addTo(map);
                                marker.bindPopup(`<strong>${user.name}</strong><br>${user.designation}`);
                                markers[user.id] = marker;
                            }
                        }

                        // 2. Add to Sidebar List
                        const item = document.createElement('div');
                        item.className = 'staff-item';
                        item.setAttribute('data-name', user.name.toLowerCase());
                        item.innerHTML = `
                            <img src="${user.image}" class="staff-avatar ${user.is_online ? '' : 'grayscale'}">
                            <div class="staff-info">
                                <h6>${user.name}</h6>
                                <div class="staff-progress">
                                    <div class="progress-fill" style="width: ${user.progress}%; background: ${color};"></div>
                                </div>
                                <small class="text-muted" style="font-size: 10px">${user.designation}</small>
                            </div>
                            <div class="staff-time">
                                <b>12:00 pm</b><br>
                                <span style="font-size: 10px">${user.last_updated}</span>
                            </div>
                        `;
                        
                        if (lat && lng) {
                            item.onclick = () => {
                                map.setView([lat, lng], 18, { animate: true });
                                if (markers[user.id]) markers[user.id].openPopup();
                            };
                        }
                        
                        staffList.appendChild(item);
                    });

                    // Initial focus
                    const onlineMarkers = Object.values(markers);
                    if (onlineMarkers.length > 0 && !map._initBounds) {
                        const group = new L.featureGroup(onlineMarkers);
                        map.fitBounds(group.getBounds().pad(0.3));
                        map._initBounds = true;
                    }
                });
        }

        // Search logic
        document.getElementById('staff-search').addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            const items = document.querySelectorAll('.staff-item');
            items.forEach(item => {
                const name = item.getAttribute('data-name');
                item.style.display = name.includes(term) ? 'flex' : 'none';
            });
        });

        updateUI();
        setInterval(updateUI, 30000);

        document.getElementById('refreshBtn').onclick = updateUI;
    });
</script>
@endpush
