<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Marketing\MembershipController;
use App\Http\Controllers\RetailDepartment\PatientSearchController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\Marketing\PurchaseHistoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PatientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PatientSearchController as ApiPatientSearchController;
use App\Http\Controllers\Admin\EventMemberController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/test', function () {
    return view('test');
})->name('test');

// Retail Department Routes (No Auth Required)
Route::prefix('retail_dept')->name('retail_dept.')->group(function() {
    Route::get('/retail_search', [PatientSearchController::class, 'index'])->name('retail_search');
    Route::post('/search', [PatientSearchController::class, 'search'])->name('search');
    Route::get('/member/{id}', [PatientSearchController::class, 'getMemberDetails'])->name('member.details');
});

// Receipt routes (No Auth Required)
Route::post('/receipts', [ReceiptController::class, 'store'])->name('receipts.store');
Route::get('/receipts/member/{memberId}', [ReceiptController::class, 'getMemberReceipts'])->name('receipts.member');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin routes
    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', UserController::class);
        Route::resource('patients', PatientController::class);
        Route::post('patients/import', [PatientController::class, 'import'])->name('patients.import');
        // Member Management
        Route::resource('members', \App\Http\Controllers\Marketing\MembershipController::class);
        Route::post('members/{member}/toggle-flag', [\App\Http\Controllers\Marketing\MembershipController::class, 'toggleFlag'])->name('members.toggleFlag');
        Route::post('members/{member}/toggle-ecard', [\App\Http\Controllers\Marketing\MembershipController::class, 'toggleEcard'])->name('members.toggleEcard');

        //api route to fetch patients from form
            Route::get('/eventMembers', [\App\Http\Controllers\Admin\EventMemberController::class, 'index'])->name('eventMembers.index');
            Route::put('/verify/{id}', [EventMemberController::class, 'verify'])->name('eventMembers.verify');
            Route::put('/reject/{id}', [EventMemberController::class, 'reject'])->name('eventMembers.reject');
            Route::get('/unverified', [EventMemberController::class, 'unverified'])->name('eventMembers.unverified');

    }); // <-- Close admin group

    // Marketing Department Routes
    Route::middleware(['auth', 'role:marketing'])->prefix('marketing')->name('marketing.')->group(function () {
        Route::get('/dashboard', [MembershipController::class, 'dashboard'])->name('dashboard');

        // Membership Management Routes
        Route::prefix('membership')->name('membership.')->group(function () {
            Route::get('/registration', [MembershipController::class, 'registration'])->name('registration');
            Route::post('/store', [MembershipController::class, 'store'])->name('store');
            Route::get('/list', [MembershipController::class, 'list'])->name('list');
            Route::get('/search-patients', [MembershipController::class, 'searchPatients'])->name('search-patients');
            Route::get('/pending-members', [MembershipController::class, 'pendingList'])->name('pending');
            Route::put('/pending-members/{id}/verify', [MembershipController::class, 'verifyPending'])->name('pending.verify');
            Route::put('/pending-members/{id}/reject', [MembershipController::class, 'rejectPending'])->name('pending.reject');
            Route::post('/pending-members/update', [MembershipController::class, 'updatePendingMembers'])->name('pending.update');
            Route::get('/{id}', [MembershipController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [MembershipController::class, 'edit'])->name('edit');
            Route::put('/{id}', [MembershipController::class, 'update'])->name('update');
            Route::post('/{member}/toggle-ecard', [MembershipController::class, 'toggleEcard'])->name('toggle-ecard');
        });

        Route::get('/unverified-members', [\App\Http\Controllers\Marketing\MembershipController::class, 'unverifiedList'])->name('membership.unverified');
    });

    // Marketing routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/marketing/members/{memberId}/purchases', [PurchaseHistoryController::class, 'show'])->name('marketing.members.purchases');
    });

    Route::get('/patients/search', [ApiPatientSearchController::class, 'search'])->name('patients.search');
});

require __DIR__.'/auth.php';
