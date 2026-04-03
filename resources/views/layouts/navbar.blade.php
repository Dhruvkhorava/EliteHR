<div class="header-container">
    <header class="header navbar navbar-expand-sm expand-header">


        <ul class="navbar-item theme-brand flex-row text-center">
            <li class="nav-item theme-logo">
                <a href="{{ getRouterValue() }}dashboard/analytics">
                    <img src="{{ asset('asset/images/logo1.png') }}" class="logo-light navbar-logo-g" alt="logo">
                    <img src="{{ asset('asset/images/logo1.png') }}" class="logo-dark navbar-logo-g" alt="logo">
                </a>
            </li>
        </ul>

        <ul class="navbar-item flex-row ms-lg-auto ms-0 action-area">
            <li class="nav-item theme-toggle-item">
                <a href="javascript:void(0);" class="nav-link search-trigger" id="globalSearchTrigger">

                    <span class=" ms-2 d-none d-sm-inline-block" style="font-size: 0.65rem; padding: 2px 5px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-search">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </span>
                </a>
            </li>
            <li class="nav-item theme-toggle-item">
                <a href="javascript:void(0);" class="nav-link theme-toggle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-moon dark-mode">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-sun light-mode">
                        <circle cx="12" cy="12" r="5"></circle>
                        <line x1="12" y1="1" x2="12" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="23"></line>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                        <line x1="1" y1="12" x2="3" y2="12"></line>
                        <line x1="21" y1="12" x2="23" y2="12"></line>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                    </svg>
                </a>
            </li>

            <li class="nav-item dropdown notification-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-bell">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    @if (($unreadMailsCount ?? 0) + ($unreadNotificationsCount ?? 0) + ($todayBirthdays->count() ?? 0) > 0)
                        <span
                            class="badge badge-success">{{ ($unreadMailsCount ?? 0) + ($unreadNotificationsCount ?? 0) + ($todayBirthdays->count() ?? 0) }}</span>
                    @endif
                </a>

                <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
                    @if (isset($todayBirthdays) && $todayBirthdays->count() > 0)
                        <div class="drodpown-title birthday-alert"
                            style="background: linear-gradient(45deg, #ff9a9e 0%, #fad0c4 99%, #fad0c4 100%);">
                            <h6 class="mb-0 text-white">🎂 Today's Birthdays!</h6>
                        </div>
                        <div class="birthday-scroll">
                            @foreach ($todayBirthdays as $birthdayUser)
                                <div class="dropdown-item">
                                    <div class="media">
                                        <div class="avatar avatar-sm me-2">
                                            <img alt="avatar"
                                                src="{{ $birthdayUser->image ? asset('storage/' . $birthdayUser->image) : asset('asset/images/placeholder.png') }}"
                                                class="rounded-circle">
                                        </div>
                                        <div class="media-body">
                                            <div class="data-info">
                                                <h6 class="mb-0 text-dark">Today is {{ $birthdayUser->name }}'s
                                                    birthday!</h6>
                                                <p class="mb-0 text-primary small">Wish them a great day! 🎉</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="drodpown-title message">
                        <h6 class="d-flex justify-content-between">
                            <a href="{{ route('mail.index') }}"
                                class="text-decoration-none d-flex justify-content-between w-100">
                                <span class="align-self-center text-dark">Messages</span>
                                <span class="badge badge-primary">{{ $unreadMailsCount ?? 0 }} Unread</span>
                            </a>
                        </h6>
                    </div>
                    <div class="notification-scroll">
                        @forelse($unreadMails ?? [] as $mail)
                            <div class="dropdown-item">
                                <a href="{{ route('mail.show', $mail->id) }}" class="text-decoration-none">
                                    <div class="media">
                                        <img src="{{ $mail->sender && $mail->sender->image ? asset('storage/' . $mail->sender->image) : asset('asset/images/placeholder.png') }}"
                                            class="img-fluid me-2" alt="avatar">
                                        <div class="media-body">
                                            <div class="data-info">
                                                <h6 class="mb-0 text-dark">{{ $mail->sender->name ?? 'Unknown' }}</h6>
                                                <p class="mb-0 text-muted small">{{ $mail->subject }}</p>
                                                <p class="mb-0 text-primary small">
                                                    {{ $mail->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="dropdown-item text-center py-3">
                                <p class="mb-0 text-muted">No unread messages</p>
                            </div>
                        @endforelse

                        <div class="drodpown-title notification mt-2">
                            <h6 class="d-flex justify-content-between"><span
                                    class="align-self-center">Notifications</span> <span
                                    class="badge badge-secondary">{{ $unreadNotificationsCount ?? 0 }} New</span></h6>
                        </div>

                        @forelse($unreadNotifications ?? [] as $notification)
                            <div class="dropdown-item">
                                <div class="media">
                                    <div class="media-body">
                                        <div class="data-info">
                                            <h6 class="mb-0 text-dark">
                                                {{ is_array($notification->data) ? $notification->data['message'] ?? 'New event' : 'New event' }}
                                            </h6>
                                            <p class="mb-0 text-primary small">
                                                {{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="dropdown-item text-center py-3">
                                <p class="mb-0 text-muted">No new notifications</p>
                            </div>
                        @endforelse

                        <div class="dropdown-item text-center py-3 border-top">
                            <a href="{{ route('mail.index') }}" class="text-primary font-weight-bold">View All
                                Messages</a>
                        </div>
                    </div>
                </div>

            </li>

            <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar-container">
                        <div class="avatar avatar-sm avatar-indicators avatar-online">
                            <img alt="avatar"
                                src="{{ Auth::check() && Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('asset/images/placeholder.png') }}"
                                class="rounded-circle">
                        </div>
                    </div>
                </a>

                <div class="dropdown-menu position-absolute aurora-dropdown" aria-labelledby="userProfileDropdown">
                    <div class="aurora-avatar-container">
                        <div class="floating-avatar-wrapper">
                            <img alt="avatar"
                                src="{{ Auth::check() && Auth::user()->image ? asset('storage/' . Auth::user()->image) : asset('asset/images/placeholder.png') }}"
                                class="rounded-circle">
                            <span class="aurora-status"></span>
                        </div>
                    </div>
                    <div class="aurora-header">
                        <div class="aurora-mesh-gradient"></div>
                        <div class="aurora-user-info text-center">
                            <h5 class="aurora-name">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</h5>
                            <span class="aurora-badge">{{ Auth::check() ? Auth::user()->getRoleNames()->first() : 'Visitor' }}</span>
                        </div>
                    </div>
                    
                    <div class="aurora-items-list">
                        <div class="aurora-item" style="--delay: 0.1s">
                            <a href="{{ route('profile.index') }}" class="aurora-link">
                                <div class="aurora-icon-bg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                </div>
                                <span class="aurora-text">Profile</span>
                                <div class="aurora-arrow"><i class="bi bi-chevron-right"></i></div>
                            </a>
                        </div>
                        <div class="aurora-item" style="--delay: 0.2s">
                            <a href="{{ route('mail.index') }}" class="aurora-link">
                                <div class="aurora-icon-bg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox">
                                        <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline>
                                        <path
                                            d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z">
                                        </path>
                                    </svg>
                                </div>
                                <span class="aurora-text">Inbox</span>
                                @if(($unreadMailsCount ?? 0) > 0)
                                    <span class="aurora-count">{{ $unreadMailsCount }}</span>
                                @endif
                                <div class="aurora-arrow"><i class="bi bi-chevron-right"></i></div>
                            </a>
                        </div>
                        
                        <div class="aurora-divider" style="--delay: 0.3s"></div>
                        
                        <div class="aurora-item" style="--delay: 0.4s">
                            <a href="javascript:void(0);"
                                class="aurora-link logout-trigger"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <div class="aurora-icon-bg danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg>
                                </div>
                                <span class="aurora-text">Sign Out</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>

            </li>
        </ul>
    </header>
</div>
