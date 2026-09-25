<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\StatController;
use App\Http\Controllers\Admin\NewsNoticeController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\PrincipalDeskController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AdmissionEnquiryController;
use App\Http\Controllers\Admin\DisclosureCategoryController;
use App\Http\Controllers\Admin\MandatoryDisclosureController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\HomeController;
use App\Http\Controllers\web\DepartmentController as WebDepartmentController;
use App\Http\Controllers\web\ContactController;
use App\Http\Controllers\web\EventController as WebEventController;
use App\Http\Controllers\Web\AdmissionController;
use App\Http\Controllers\Web\PrincipalMessageController;
use App\Http\Controllers\Web\WebFacilityController;
use App\Http\Controllers\Web\WebGalleryController;
use App\Http\Controllers\Web\WebNewsNoticeController;
use App\Http\Controllers\Web\WebMandatoryDisclosureController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about-us', [HomeController::class, 'about'])->name('about');

// Public departments page
Route::get('/departments', [WebDepartmentController::class, 'index'])->name('departments.index');
Route::get('/departments/{department}', [WebDepartmentController::class, 'show'])->name('departments.show');

// Contact page
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact-us', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')   // max 5 messages per minute per visitor
    ->name('contact.store');

// Public events
Route::get('/events', [WebEventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [WebEventController::class, 'show'])->name('events.show');

Route::get('/admission', [AdmissionController::class, 'create'])->name('admission');
Route::post('/admission', [AdmissionController::class, 'store'])
    ->middleware('throttle:5,1')          // max 5 submissions per minute per IP
    ->name('admission.store');
Route::get('/about-us/principal-message', PrincipalMessageController::class)->name('principal-message');

Route::get('/facilities', [WebFacilityController::class, 'index'])->name('facilities.index');
Route::get('/facilities/{facility:slug}', [WebFacilityController::class, 'show'])->name('facilities.show');
Route::get('/gallery', [WebGalleryController::class, 'index'])->name('gallery.index');

Route::get('/news-notices', [WebNewsNoticeController::class, 'index'])->name('news-notices.index');
Route::get('/news-notices/{newsNotice}/{slug?}', [WebNewsNoticeController::class, 'show'])
    ->whereNumber('newsNotice')->name('news-notices.show');
Route::get('/mandatory-disclosure', [WebMandatoryDisclosureController::class, 'index'])->name('mandatory-disclosure');



Route::prefix('admin')->name('admin.')->group(function () {

    // Guest routes (login)
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');

    Route::middleware('auth')->group(function () {

        // Open to any logged-in user (admin or staff) — no module gate.
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('home', [DashboardController::class, 'home'])->name('home');

        // ---- Admin-only sections (never offered as a staff permission) ----
        Route::middleware('admin.only')->group(function () {
            Route::get('home/banner', [BannerController::class, 'index'])->name('home.banner');
            Route::post('home/banner', [BannerController::class, 'store'])->name('home.banner.store');

            Route::get('home/stats', [StatController::class, 'index'])->name('home.stats');
            Route::post('home/stats', [StatController::class, 'store'])->name('home.stats.store');

            Route::get('staff', [StaffController::class, 'index'])->name('staff');
            Route::get('staff/create', [StaffController::class, 'create'])->name('staff.create');
            Route::post('staff', [StaffController::class, 'store'])->name('staff.store');
            Route::get('staff/{staffMember}/edit', [StaffController::class, 'edit'])->name('staff.edit');
            Route::put('staff/{staffMember}', [StaffController::class, 'update'])->name('staff.update');
            Route::delete('staff/{staffMember}', [StaffController::class, 'destroy'])->name('staff.destroy');


            Route::get('about', [AboutController::class, 'index'])->name('about');
            Route::post('about', [AboutController::class, 'store'])->name('about.store');

            Route::get('principal-desk/create', [PrincipalDeskController::class, 'create'])->name('principal-desk.create');
            Route::post('principal-desk', [PrincipalDeskController::class, 'store'])->name('principal-desk.store');
            Route::get('principal-desk/{principal_desk}/edit', [PrincipalDeskController::class, 'edit'])->name('principal-desk.edit');
            Route::put('principal-desk/{principal_desk}', [PrincipalDeskController::class, 'update'])->name('principal-desk.update');

            Route::get('departments', [DepartmentController::class, 'index'])->name('departments');
            Route::get('departments/create', [DepartmentController::class, 'create'])->name('departments.create');
            Route::post('departments', [DepartmentController::class, 'store'])->name('departments.store');
            Route::get('departments/{department}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
            Route::put('departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
            Route::delete('departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');

            Route::get('classes', [ClassController::class, 'index'])->name('classes');
            Route::get('classes/create', [ClassController::class, 'create'])->name('classes.create');
            Route::post('classes', [ClassController::class, 'store'])->name('classes.store');
            Route::get('classes/{class}/edit', [ClassController::class, 'edit'])->name('classes.edit');
            Route::put('classes/{class}', [ClassController::class, 'update'])->name('classes.update');
            Route::delete('classes/{class}', [ClassController::class, 'destroy'])->name('classes.destroy');


            Route::get('facilities', [FacilityController::class, 'index'])->name('facilities');
            Route::get('facilities/create', [FacilityController::class, 'create'])->name('facilities.create');
            Route::post('facilities', [FacilityController::class, 'store'])->name('facilities.store');
            Route::get('facilities/{facility}/edit', [FacilityController::class, 'edit'])->name('facilities.edit');
            Route::put('facilities/{facility}', [FacilityController::class, 'update'])->name('facilities.update');
            Route::delete('facilities/{facility}', [FacilityController::class, 'destroy'])->name('facilities.destroy');


            Route::get('mandatory-disclosures', [MandatoryDisclosureController::class, 'index'])->name('mandatory-disclosures');
            Route::get('mandatory-disclosures/create', [MandatoryDisclosureController::class, 'create'])->name('mandatory-disclosures.create');
            Route::post('mandatory-disclosures', [MandatoryDisclosureController::class, 'store'])->name('mandatory-disclosures.store');
            Route::get('mandatory-disclosures/{disclosure}/edit', [MandatoryDisclosureController::class, 'edit'])->name('mandatory-disclosures.edit');
            Route::put('mandatory-disclosures/{disclosure}', [MandatoryDisclosureController::class, 'update'])->name('mandatory-disclosures.update');
            Route::delete('mandatory-disclosures/{disclosure}', [MandatoryDisclosureController::class, 'destroy'])->name('mandatory-disclosures.destroy');
            Route::patch('mandatory-disclosures/{disclosure}/toggle', [MandatoryDisclosureController::class, 'toggle'])->name('mandatory-disclosures.toggle');


            // Master > Disclosure Categories
            Route::get('disclosure-categories',                  [DisclosureCategoryController::class, 'index'])->name('disclosure-categories');
            Route::get('disclosure-categories/create',           [DisclosureCategoryController::class, 'create'])->name('disclosure-categories.create');
            Route::post('disclosure-categories',                 [DisclosureCategoryController::class, 'store'])->name('disclosure-categories.store');
            Route::get('disclosure-categories/{category}/edit',  [DisclosureCategoryController::class, 'edit'])->name('disclosure-categories.edit');
            Route::put('disclosure-categories/{category}',       [DisclosureCategoryController::class, 'update'])->name('disclosure-categories.update');

            // Delete / restore. If you have an admin-only middleware group (like Events delete), put these two inside it.
            Route::delete('disclosure-categories/{category}',    [DisclosureCategoryController::class, 'destroy'])->name('disclosure-categories.destroy');
            Route::patch('disclosure-categories/{id}/restore',   [DisclosureCategoryController::class, 'restore'])->name('disclosure-categories.restore')->whereNumber('id');

            Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs');
            Route::get('activity-logs/export', [ActivityLogController::class, 'export'])->name('activity-logs.export');
            Route::get('activity-logs/{activityLog}', [ActivityLogController::class, 'show'])
                ->whereNumber('activityLog')
                ->name('activity-logs.show');
        });

        // ---- Staff-assignable modules (gated by the "permissions" checkboxes) ----
        Route::middleware('module:news-notices')->group(function () {
            Route::get('news-notices', [NewsNoticeController::class, 'index'])->name('news-notices');
            Route::get('news-notices/create', [NewsNoticeController::class, 'create'])->name('news-notices.create');
            Route::post('news-notices', [NewsNoticeController::class, 'store'])->name('news-notices.store');
            Route::get('news-notices/{newsNotice}/edit', [NewsNoticeController::class, 'edit'])->name('news-notices.edit');
            Route::put('news-notices/{newsNotice}', [NewsNoticeController::class, 'update'])->name('news-notices.update');
            Route::delete('news-notices/{newsNotice}', [NewsNoticeController::class, 'destroy'])->name('news-notices.destroy');
        });

        Route::middleware('module:events')->group(function () {
            Route::get('events', [EventController::class, 'index'])->name('events');
            Route::get('events/create', [EventController::class, 'create'])->name('events.create');
            Route::post('events', [EventController::class, 'store'])->name('events.store');
            Route::get('events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
            Route::put('events/{event}', [EventController::class, 'update'])->name('events.update');
            Route::delete('events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
        });

        Route::middleware('module:gallery')->group(function () {
            Route::get('gallery', [GalleryController::class, 'index'])->name('gallery');
            Route::get('gallery/create', [GalleryController::class, 'create'])->name('gallery.create');
            Route::post('gallery', [GalleryController::class, 'store'])->name('gallery.store');
            Route::get('gallery/{gallery}/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
            Route::put('gallery/{gallery}', [GalleryController::class, 'update'])->name('gallery.update');
            Route::delete('gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
        });


        Route::middleware('module:enquiries')->group(function () {
            Route::get('admission-enquiries', [AdmissionEnquiryController::class, 'index'])->name('admission-enquiries');
            Route::get('admission-enquiries/export', [AdmissionEnquiryController::class, 'export'])->name('admission-enquiries.export');
            Route::get('admission-enquiries/{admissionEnquiry}', [AdmissionEnquiryController::class, 'show'])
                ->whereNumber('admissionEnquiry')->name('admission-enquiries.show');
            Route::put('admission-enquiries/{admissionEnquiry}', [AdmissionEnquiryController::class, 'update'])
                ->whereNumber('admissionEnquiry')->name('admission-enquiries.update');
            Route::patch('admission-enquiries/{admissionEnquiry}/status', [AdmissionEnquiryController::class, 'updateStatus'])
                ->whereNumber('admissionEnquiry')->name('admission-enquiries.status');
            Route::delete('admission-enquiries/{admissionEnquiry}', [AdmissionEnquiryController::class, 'destroy'])
                ->whereNumber('admissionEnquiry')->name('admission-enquiries.destroy');
        });
        // NOTE: there is no Enquiries module/controller in the app yet, so
        // "enquiries" is only a selectable permission for now (it does
        // nothing on its own). Once an EnquiryController + routes exist,
        // wrap them the same way: Route::middleware('module:enquiries')->group(...).

        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });
});
