<?php

use Illuminate\Support\Facades\Route;

/**
 * =======================
 *          Redirect
 * =======================
 */
use App\Http\Controllers\Auth\AuthController;

/**
 * =======================
 *          Redirect / Auth
 * =======================
 */
/**
 * =======================
 *          Frontend
 * =======================
 */
use App\Http\Controllers\FrontendController;

Route::get('/', [FrontendController::class, 'index'])->name('front.index');
Route::get('/about', [FrontendController::class, 'about'])->name('front.about');
Route::get('/service', [FrontendController::class, 'service'])->name('front.service');
Route::get('/contact', [FrontendController::class, 'contact'])->name('front.contact');
Route::get('/price', [FrontendController::class, 'price'])->name('front.price');
Route::get('/feature', [FrontendController::class, 'feature'])->name('front.feature');
Route::get('/team', [FrontendController::class, 'team'])->name('front.team');
Route::get('/testimonial', [FrontendController::class, 'testimonial'])->name('front.testimonial');
Route::get('/quote', [FrontendController::class, 'quote'])->name('front.quote');
Route::get('/blog', [FrontendController::class, 'blog'])->name('front.blog');
Route::get('/blog/detail', [FrontendController::class, 'detail'])->name('front.detail');

/**
 * =======================
 *          Redirect / Auth
 * =======================
 */
Route::get('/login', [AuthController::class , 'showSignIn'])->name('login');
Route::post('/login', [AuthController::class , 'login']);
Route::post('/logout', [AuthController::class , 'logout'])->name('logout');

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminManageController;
use App\Http\Controllers\Admin\HrManageController;
use App\Http\Controllers\Admin\EmployeeManageController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\AppraisalController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ShiftController;
use App\Http\Controllers\MailController;

/**
 * =======================
 *          Dashboard
 * =======================
 */
Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {

    // General Dashboard (Accessible by all authenticated users)
    Route::get('/analytics', [\App\Http\Controllers\DashboardController::class, 'analytics'])->name('analytics');
        // Calendar
        Route::get('/calendar', [\App\Http\Controllers\CalendarController::class, 'index'])->name('calendar.index');
        Route::get('/calendar/events', [\App\Http\Controllers\CalendarController::class, 'events'])->name('calendar.events');
        Route::post('/calendar/events', [\App\Http\Controllers\CalendarController::class, 'store'])->name('calendar.events.store');
        Route::put('/calendar/events/{id}', [\App\Http\Controllers\CalendarController::class, 'update'])->name('calendar.events.update');
        Route::delete('/calendar/events/{id}', [\App\Http\Controllers\CalendarController::class, 'destroy'])->name('calendar.events.destroy');
        Route::get('/calendar/google-events', [\App\Http\Controllers\CalendarController::class, 'getGoogleCalendarEvents'])->name('calendar.google-events');

        // Attendance - My Attendance (Accessible by all authenticated users)
        Route::get('/attendance', [AttendanceController::class , 'index'])->name('attendance.index');
        Route::post('/attendance/check-in', [AttendanceController::class , 'checkIn'])->name('attendance.check-in');
        Route::post('/attendance/check-out', [AttendanceController::class , 'checkOut'])->name('attendance.check-out');
        Route::post('/attendance/start-break', [AttendanceController::class , 'startBreak'])->name('attendance.start-break');
        Route::post('/attendance/stop-break', [AttendanceController::class , 'stopBreak'])->name('attendance.stop-break');

        // Leave - My Leaves (Accessible by all authenticated users)
        Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves.index');
        Route::get('/api/unified-search', [\App\Http\Controllers\SearchController::class, 'unifiedSearch'])->name('api.unified-search');
        Route::get('/leaves/apply', [LeaveController::class, 'create'])->name('leaves.create');
        Route::post('/leaves', [LeaveController::class, 'store'])->name('leaves.store');

        // Performance (Accessible by all authenticated users)
        Route::get('/performance', [PerformanceController::class, 'index'])->name('performance.index');
        Route::post('/performance', [PerformanceController::class, 'store'])->name('performance.store');
        Route::get('/goals', [GoalController::class, 'index'])->name('performance.goals');
        Route::post('/goals', [GoalController::class, 'store'])->name('performance.goals.store');
        Route::put('/goals/{goal}', [GoalController::class, 'update'])->name('performance.goals.update');
        Route::delete('/goals/{goal}', [GoalController::class, 'destroy'])->name('performance.goals.destroy');
        Route::get('/appraisals', [AppraisalController::class, 'index'])->name('performance.appraisals');
        Route::post('/appraisals', [AppraisalController::class, 'store'])->name('performance.appraisals.store');
        Route::post('/appraisals/{appraisal}/approve', [AppraisalController::class, 'approve'])->name('performance.appraisals.approve');

        // Management Area (HR & Admin)
        Route::group(['middleware' => ['role_or_permission:admin|hr|user.view|attendance.manage|leave.view_all']], function () {
            
            // User Management
            Route::middleware(['permission:user.view'])->group(function() {
                Route::resource('users', UserController::class);
                Route::resource('employees', EmployeeManageController::class);
                Route::post('/users/{user}/toggle-status', [UserController::class , 'toggleStatus'])->name('users.toggle-status');
            });

            // Admin Attendance Views
            Route::middleware(['permission:attendance.manage'])->group(function() {
                Route::get('/attendance/daily', [AttendanceController::class , 'daily'])->name('attendance.daily');
                Route::get('/attendance/summary', [AttendanceController::class , 'summary'])->name('attendance.summary');
                Route::post('/attendance/assign-shift', [AttendanceController::class , 'assignShift'])->name('attendance.assign-shift');
                Route::resource('shifts', ShiftController::class);
            });

            // Leave Management (View History)
            Route::get('/leaves/history', [\App\Http\Controllers\Admin\LeaveApprovalController::class, 'history'])->name('admin.leaves.history')->middleware('permission:leave.view_all');

            // STRICT ADMIN ACTIONS (Leave Approval & Leave Types)
            Route::middleware(['permission:leave.approve'])->group(function() {
                Route::get('/leaves/pending', [\App\Http\Controllers\Admin\LeaveApprovalController::class, 'index'])->name('admin.leaves.pending');
                Route::post('/leaves/{leave}/action', [\App\Http\Controllers\Admin\LeaveApprovalController::class, 'action'])->name('admin.leaves.action');
            });

            Route::middleware(['permission:leave_type.manage'])->group(function() {
                Route::resource('leave-types', \App\Http\Controllers\Admin\LeaveTypeController::class);
            });

            // Payroll Management
            Route::group(['prefix' => 'payroll'], function() {
                Route::get('/', [\App\Http\Controllers\PayrollController::class, 'index'])->name('payroll.index');
                Route::get('/setup', [\App\Http\Controllers\PayrollController::class, 'setup'])->name('payroll.setup');
                Route::post('/setup', [\App\Http\Controllers\PayrollController::class, 'storeSetup'])->name('payroll.store-setup');
                Route::get('/generate', [\App\Http\Controllers\PayrollController::class, 'generate'])->name('payroll.generate');
                Route::post('/generate', [\App\Http\Controllers\PayrollController::class, 'storeGenerate'])->name('payroll.store-generate');
                Route::get('/{id}', [\App\Http\Controllers\PayrollController::class, 'show'])->name('payroll.show');
                Route::get('/{id}/pdf', [\App\Http\Controllers\PayrollController::class, 'downloadPdf'])->name('payroll.pdf');
            });

            // Recruitment Management
            Route::group(['middleware' => ['permission:view recruitment'], 'prefix' => 'recruitment', 'as' => 'recruitment.'], function() {
                Route::resource('jobs', \App\Http\Controllers\RecruitmentJobController::class);
                Route::resource('candidates', \App\Http\Controllers\CandidateController::class);
                Route::resource('applications', \App\Http\Controllers\ApplicationController::class);
                Route::post('/applications/{application}/update-status', [\App\Http\Controllers\ApplicationController::class, 'updateStatus'])->name('applications.update-status');
                Route::post('/applications/{application}/convert', [\App\Http\Controllers\ApplicationController::class, 'convertToEmployee'])->name('applications.convert');
                Route::resource('interviews', \App\Http\Controllers\InterviewController::class);
            });

        // Advanced User Management (Strictly Admin/HR via permissions)
            Route::middleware(['permission:admin.view'])->group(function() {
                Route::resource('admins', AdminManageController::class);
            });
            Route::middleware(['permission:hr.view'])->group(function() {
                Route::resource('hrs', HrManageController::class);
            });

            // User Profile
            Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
            Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
            Route::post('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');

            // Roles & Permissions
            Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);

            // General Settings
            Route::get('/settings', [SettingController::class, 'index'])->name('settings');
            Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

            // Documents
            Route::get('/documents', [App\Http\Controllers\DocumentController::class, 'index'])->name('documents.index');
            Route::get('/documents/category/{category}', [App\Http\Controllers\DocumentController::class, 'category'])->name('documents.category');
            Route::post('/documents', [App\Http\Controllers\DocumentController::class, 'store'])->name('documents.store');
            Route::delete('/documents/{id}', [App\Http\Controllers\DocumentController::class, 'destroy'])->name('documents.destroy');
            Route::get('/documents/{id}/download', [App\Http\Controllers\DocumentController::class, 'download'])->name('documents.download');

            // Mail
            Route::group(['prefix' => 'mail', 'as' => 'mail.'], function () {
                Route::get('/', [MailController::class, 'index'])->name('index');
                Route::get('/sent', [MailController::class, 'sent'])->name('sent');
                Route::get('/drafts', [MailController::class, 'drafts'])->name('drafts');
                Route::get('/trash', [MailController::class, 'trash'])->name('trash');
                Route::get('/compose/{id?}', [MailController::class, 'compose'])->name('compose');
                Route::post('/send', [MailController::class, 'send'])->name('send');
                Route::get('/{mail}', [MailController::class, 'show'])->name('show');
                Route::delete('/{mail}', [MailController::class, 'destroy'])->name('destroy');
            });
        });
    });
/**
 * =======================
 *          Auth (Refactored)
 * =======================
 */
Route::prefix('auth')->group(function () {
    Route::get('/sign-up', function () {
            return view('auth.sign-up',
            [
            'catName' => 'auth',
            'title' => 'Sign Up',
            "breadcrumbs" => ["Authentication", "Sign Up"],
            'scrollspy' => 0,
            'simplePage' => 1
            ]
            );
        }
        )->name('register');

        Route::get('/lockscreen', function () {
            return view('auth.unlock',
            [
            'catName' => 'auth',
            'title' => 'LockScreen',
            "breadcrumbs" => ["Authentication", "LockScreen"],
            'scrollspy' => 0,
            'simplePage' => 1
            ]
            );
        }
        )->name('unlock');

        Route::get('/password-reset', function () {
            return view('auth.reset',
            [
            'catName' => 'auth',
            'title' => 'Password Reset',
            "breadcrumbs" => ["Authentication", "Password Reset"],
            'scrollspy' => 0,
            'simplePage' => 1
            ]
            );
        }
        )->name('password.reset');

        Route::get('/2-step-verification', function () {
            return view('auth.2-step',
            [
            'catName' => 'auth',
            'title' => '2 Step Verification',
            "breadcrumbs" => ["Authentication", "2 Step Verification"],
            'scrollspy' => 0,
            'simplePage' => 1
            ]
            );
        }
        )->name('2sv');
    });