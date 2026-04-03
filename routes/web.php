<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\AppraisalController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SalaryComponentController;
use App\Http\Controllers\SalaryTemplateController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\RecruitmentJobController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminManageController;
use App\Http\Controllers\Admin\HrManageController;
use App\Http\Controllers\Admin\EmployeeManageController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\ManagerManageController;
use App\Http\Controllers\Admin\ShiftController;
use App\Http\Controllers\Admin\LeaveApprovalController;
use App\Http\Controllers\Admin\LeaveTypeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\BlogController;


/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::controller(FrontendController::class)->name('front.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/about', 'about')->name('about');
    Route::get('/service', 'service')->name('service');
    Route::get('/product/{slug?}', 'product')->name('product');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/price', 'price')->name('price');
    Route::get('/feature', 'feature')->name('feature');
    Route::get('/team', 'team')->name('team');
    Route::get('/testimonial', 'testimonial')->name('testimonial');
    Route::get('/quote', 'quote')->name('quote');
    Route::get('/blog', 'blog')->name('blog');
    Route::get('/blog/{slug}', 'detail')->name('detail');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showSignIn')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');

    Route::prefix('auth')->group(function () {
        Route::get('/sign-up', 'showSignUp')->name('register');
    });
});

/*
|--------------------------------------------------------------------------
| Dashboard & Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('dashboard')->group(function () {

    // General Dashboard Sections
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/analytics', 'analytics')->name('analytics');
        Route::get('/sales', 'sales')->name('sales');
    });

    // Calendar & Events
    Route::controller(CalendarController::class)->prefix('calendar')->as('calendar.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/events', 'events')->name('events');
        Route::post('/events', 'store')->name('events.store');
        Route::put('/events/{id}', 'update')->name('events.update');
        Route::delete('/events/{id}', 'destroy')->name('events.destroy');
        Route::get('/google-events', 'getGoogleCalendarEvents')->name('google-events');
    });

    // Attendance Management
    Route::controller(AttendanceController::class)->prefix('attendance')->as('attendance.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/check-in', 'checkIn')->name('check-in');
        Route::post('/check-out', 'checkOut')->name('check-out');
        Route::post('/start-break', 'startBreak')->name('start-break');
        Route::post('/stop-break', 'stopBreak')->name('stop-break');

        // Admin Attendance Views (Conditional via permissions)
        Route::middleware(['permission:attendance.manage'])->group(function () {
            Route::get('/daily', 'daily')->name('daily');
            Route::get('/summary', 'summary')->name('summary');
            Route::post('/assign-shift', 'assignShift')->name('assign-shift');
            Route::post('/record-location', 'recordLocation')->name('record-location');
            Route::get('/live', 'liveTracking')->name('live');
            Route::get('/live-data', 'liveTrackingData')->name('live.data');
        });
    });

    // Leave Management
    Route::controller(LeaveController::class)->prefix('leaves')->as('leaves.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/apply', 'create')->name('create');
        Route::post('/', 'store')->name('store');
    });

    // Search API
    Route::get('/api/unified-search', [SearchController::class, 'unifiedSearch'])->name('api.unified-search');

    // Performance & Appraisal
    Route::prefix('performance')->as('performance.')->group(function () {
        Route::controller(PerformanceController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
        });

        Route::controller(GoalController::class)->prefix('goals')->group(function () {
            Route::get('/', 'index')->name('goals');
            Route::post('/', 'store')->name('goals.store');
            Route::put('/{goal}', 'update')->name('goals.update');
            Route::delete('/{goal}', 'destroy')->name('goals.destroy');
        });

        Route::controller(AppraisalController::class)->prefix('appraisals')->group(function () {
            Route::get('/', 'index')->name('appraisals');
            Route::post('/', 'store')->name('appraisals.store');
            Route::post('/{appraisal}/approve', 'approve')->name('appraisals.approve');
        });
    });

    // Profile & Security
    Route::controller(ProfileController::class)->prefix('profile')->as('profile.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'update')->name('update');
        Route::post('/password', 'updatePassword')->name('password.update');
    });

    // Documents
    Route::middleware(['permission:document.view'])->controller(DocumentController::class)->prefix('documents')->as('documents.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/category/{category}', 'category')->name('category');
        Route::post('/', 'store')->name('store');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/{id}/download', 'download')->name('download');
        Route::get('/{id}/view', 'view')->name('view');
    });

    // Mail System
    Route::middleware(['permission:mail.view'])->controller(MailController::class)->prefix('mail')->as('mail.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/sent', 'sent')->name('sent');
        Route::get('/drafts', 'drafts')->name('drafts');
        Route::get('/trash', 'trash')->name('trash');
        Route::get('/compose/{id?}', 'compose')->name('compose');
        Route::post('/send', 'send')->name('send');
        Route::get('/{mail}', 'show')->name('show');
        Route::delete('/{mail}', 'destroy')->name('destroy');
    });

    // Notifications
    Route::controller(NotificationController::class)->prefix('notifications')->as('notifications.')->group(function () {
        Route::post('/{id}/mark-as-read', 'markAsRead')->name('markAsRead');
        Route::post('/mark-all-as-read', 'markAllAsRead')->name('markAllAsRead');
    });

    /*
    |--------------------------------------------------------------------------
    | Management Area (HR & Admin)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role_or_permission:admin|hr|employee|user.view|attendance.manage|leave.view_all'])->group(function () {

        // Employee & User Administration
        Route::middleware(['permission:user.view'])->group(function () {
            Route::resource('users', UserController::class);
            Route::resource('employees', EmployeeManageController::class);
            Route::resource('designations', DesignationController::class);
            Route::resource('managers', ManagerManageController::class);
            Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        });

        // Leave & Attendance Administration
        Route::controller(LeaveApprovalController::class)->prefix('leaves')->as('admin.leaves.')->group(function () {
            Route::get('/history', 'history')->name('history')->middleware('permission:leave.view_all');

            Route::middleware(['permission:leave.approve'])->group(function () {
                Route::get('/pending', 'index')->name('pending');
                Route::post('/{leave}/action', 'action')->name('action');
            });
        });

        Route::middleware(['permission:attendance.manage'])->resource('shifts', ShiftController::class);
        Route::middleware(['permission:leave_type.manage'])->resource('leave-types', LeaveTypeController::class);

        // Payroll & Compensation
        Route::prefix('payroll')->group(function () {
            Route::controller(PayrollController::class)->group(function () {
                Route::get('/', 'index')->name('payroll.index');
                Route::get('/setup', 'setup')->name('payroll.setup');
                Route::post('/setup', 'storeSetup')->name('payroll.store-setup');
                Route::get('/generate', 'generate')->name('payroll.generate');
                Route::post('/generate', 'storeGenerate')->name('payroll.store-generate');
                Route::get('/statement', 'statement')->name('payroll.statement');
                Route::get('/bank-transfer', 'bankTransfer')->name('payroll.bank-transfer');
                Route::post('/bank-transfer', 'storeBankTransfer')->name('payroll.store-bank-transfer');
                Route::get('/reports', 'reports')->name('payroll.reports');
                Route::post('/reports/export', 'exportReport')->name('payroll.reports.export');
                Route::get('/statement/export', 'exportStatement')->name('payroll.statement.export');
                Route::get('/my-salary', 'mySalary')->name('my-salary')->middleware('permission:payroll.view_own');
                Route::get('/my-salary/export', 'exportMySalary')->name('my-salary.export')->middleware('permission:payroll.view_own');
            });

            Route::resource('salary-components', SalaryComponentController::class);
            Route::resource('salary-templates', SalaryTemplateController::class);
            Route::resource('loans', LoanController::class);

            // Details & Exports (Wildcard routes at the bottom)
            Route::controller(PayrollController::class)->group(function () {
                Route::get('/{id}', 'show')->name('payroll.show');
                Route::get('/{id}/pdf', 'downloadPdf')->name('payroll.pdf');
            });
        });

        // Recruitment & Talent
        Route::middleware(['permission:view recruitment'])->prefix('recruitment')->as('recruitment.')->group(function () {
            Route::resource('jobs', RecruitmentJobController::class);
            Route::resource('candidates', CandidateController::class);
            Route::resource('applications', ApplicationController::class);
            Route::resource('interviews', InterviewController::class);

            Route::controller(ApplicationController::class)->prefix('applications')->group(function () {
                Route::post('/{application}/update-status', 'updateStatus')->name('applications.update-status');
                Route::post('/{application}/convert', 'convertToEmployee')->name('applications.convert');
            });
        });

        // System Administration
        Route::middleware(['permission:admin.view'])->resource('admins', AdminManageController::class);
        Route::middleware(['permission:hr.view'])->resource('hrs', HrManageController::class);
        Route::middleware(['role:super_admin'])->resource('roles', RoleController::class);
        Route::resource('blogs', BlogController::class);


        // Core Settings
        Route::controller(SettingController::class)->prefix('settings')->group(function () {
            Route::get('/', 'index')->name('settings');
            Route::post('/', 'update')->name('settings.update');
            Route::get('/pricing', 'pricing')->name('settings.pricing');
            Route::post('/pricing', 'updatePricing')->name('settings.pricing.update');
        });
    });
});