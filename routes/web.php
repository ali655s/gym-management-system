<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FranchiseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\MemberSubscriptionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/branches', [BranchController::class, 'index'])->name('branches.index');
Route::get('/trainers', [TrainerController::class, 'index'])->name('trainers.index');
Route::get('/memberships', [MembershipController::class, 'index'])->name('memberships.index');
Route::get('/franchise', [FranchiseController::class, 'index'])->name('franchise.index');
Route::post('/franchise', [FranchiseController::class, 'store'])->name('franchise.store');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Authenticated Member Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Checkout & Subscription activation
    Route::get('/memberships/{plan}/checkout', [MembershipController::class, 'checkout'])->name('memberships.checkout');
    Route::post('/memberships/{plan}/subscribe', [MembershipController::class, 'subscribe'])->name('memberships.subscribe');

    // Member Subscriptions & Renewals
    Route::get('/my-memberships', [MemberSubscriptionController::class, 'index'])->name('member.memberships');
    Route::post('/subscriptions/{subscription}/renew', [MemberSubscriptionController::class, 'renew'])->name('subscriptions.renew');

    // Dashboard alias redirects to member subscriptions
    Route::get('/dashboard', function () {
        return redirect()->route('member.memberships');
    })->name('dashboard');

    // Member Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('branches', App\Http\Controllers\Admin\BranchController::class);
        Route::resource('membership-plans', App\Http\Controllers\Admin\MembershipPlanController::class);
        Route::resource('gym-classes', App\Http\Controllers\Admin\GymClassController::class);
        Route::resource('trainers', App\Http\Controllers\Admin\TrainerController::class);
        Route::resource('partners', App\Http\Controllers\Admin\PartnerController::class);
        Route::resource('members', App\Http\Controllers\Admin\MemberController::class);
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::resource('subscriptions', App\Http\Controllers\Admin\SubscriptionController::class)->only(['index']);
        Route::patch('subscriptions/{subscription}/approve', [App\Http\Controllers\Admin\SubscriptionController::class, 'approve'])->name('subscriptions.approve');
        Route::patch('subscriptions/{subscription}/reject', [App\Http\Controllers\Admin\SubscriptionController::class, 'reject'])->name('subscriptions.reject');
        Route::patch('subscriptions/{subscription}/renew', [App\Http\Controllers\Admin\SubscriptionController::class, 'renew'])->name('subscriptions.renew');
        Route::patch('subscriptions/{subscription}/cancel', [App\Http\Controllers\Admin\SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
        Route::get('franchise-applications', [App\Http\Controllers\Admin\FranchiseApplicationController::class, 'index'])->name('franchise-applications.index');
        Route::get('franchise-applications/{application}', [App\Http\Controllers\Admin\FranchiseApplicationController::class, 'show'])->name('franchise-applications.show');
        Route::patch('franchise-applications/{application}/status', [App\Http\Controllers\Admin\FranchiseApplicationController::class, 'updateStatus'])->name('franchise-applications.updateStatus');
        Route::delete('franchise-applications/{application}', [App\Http\Controllers\Admin\FranchiseApplicationController::class, 'destroy'])->name('franchise-applications.destroy');
        Route::get('contact-messages', [App\Http\Controllers\Admin\ContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::get('contact-messages/{message}', [App\Http\Controllers\Admin\ContactMessageController::class, 'show'])->name('contact-messages.show');
        Route::patch('contact-messages/{message}/toggle', [App\Http\Controllers\Admin\ContactMessageController::class, 'toggleRead'])->name('contact-messages.toggleRead');
        Route::delete('contact-messages/{message}', [App\Http\Controllers\Admin\ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
    });

require __DIR__.'/auth.php';
