<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileManagementController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\NotificationController;
use App\Models\Ticket;


use App\Http\Controllers\ProductController as CustomerProductController;
use App\Http\Controllers\PressroomController as CustomerPressroomController;
use App\Http\Controllers\LiveChatController as UserLiveChatController;

use App\Http\Controllers\OutletController as CustomerOutletController;
use App\Http\Controllers\EventController as CustomerEventController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\TransactionController as CustomerTransactionController;
use App\Http\Controllers\Customer\FeedbackController as CustomerFeedbackController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\EventVerificationController;
use App\Http\Controllers\Admin\EventParticipantController;
// use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PressroomController;
use App\Http\Controllers\Admin\OutletController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserPointController;
use App\Http\Controllers\Admin\RewardController;
use App\Http\Controllers\Admin\RewardRedemptionController;
use App\Http\Controllers\Admin\MediaInquiryController;
use App\Http\Controllers\Admin\LiveChatController as AdminLiveChatController;

use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Admin\ChatTopicController;
use App\Http\Controllers\Admin\InstagramController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\CheckinController as AdminCheckinController;

use App\Http\Controllers\Partner\EventController as PartnerEventController;
use App\Http\Controllers\Partner\CheckinController as PartnerCheckinController;
use App\Http\Controllers\Manager\ReportController;

use App\Http\Controllers\MidtransNotificationController;

/*
|--------------------------------------------------------------------------
| AGE VERIFICATION
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\AgeVerificationController;
Route::get('/age-verification', [AgeVerificationController::class, 'index'])->name('age.verification');
Route::post('/age-verify', [AgeVerificationController::class, 'verify'])->name('age.verify');

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');

// MIDTRANS WEBHOOK (CSRF exempt in bootstrap/app.php)
Route::post('/midtrans/notification', [MidtransNotificationController::class, 'handleNotification'])
    ->name('midtrans.notification');

// PRODUCTS
Route::get('/products', [CustomerProductController::class, 'index'])->name('product.index');
Route::get('/products/{product}', [CustomerProductController::class, 'show'])->name('product.show');

// OUTLETS
Route::get('/outlets', [CustomerOutletController::class, 'index'])->name('outlets.index');
Route::get('/outlets/{outlet}', [CustomerOutletController::class, 'show'])->name('outlets.show');
Route::get('/api/outlets', [CustomerOutletController::class, 'apiIndex'])->name('api.outlets');

// PRESSROOM
Route::get('/pressroom', [CustomerPressroomController::class, 'index'])->name('pressroom.index');
Route::get('/pressroom/{slug}', [CustomerPressroomController::class, 'show'])->name('pressroom.show');
Route::post('/pressroom/media-inquiry', [CustomerPressroomController::class, 'sendMediaInquiry'])->name('pressroom.media.send');

// EVENTS (public)
Route::get('/events', [CustomerEventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [CustomerEventController::class, 'show'])->name('events.show');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES (ANY ROLE)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Message Center (Customer)
    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('/messages/active-session', [UserLiveChatController::class, 'getActiveSession'])->name('chat.active-session');
        Route::get('/messages/start', [UserLiveChatController::class, 'startSession'])->name('chat.start');
        Route::get('/messages/{session}', [UserLiveChatController::class, 'show'])->name('chat.show');
        Route::post('/messages/{session}/send', [UserLiveChatController::class, 'sendMessage'])->name('chat.send');
        Route::post('/messages/{session}/request-admin', [UserLiveChatController::class, 'requestAdmin'])->name('chat.request-admin');
        Route::get('/messages/{session}/fetch', [UserLiveChatController::class, 'fetchMessages'])->name('chat.messages');
    });

    // Event Registration
    Route::get('/event/{event}/register', [EventRegistrationController::class, 'create'])->name('event.register');
    Route::post('/event/{event}/register', [EventRegistrationController::class, 'store'])->name('event.register.store');


    // Smart Dashboard Redirect
    Route::get('/dashboard', function () {
        return match (auth()->user()->role?->name) {
            'admin'   => redirect()->route('admin.dashboard'),
            'manager' => redirect()->route('manager.dashboard'),
            'partner' => redirect()->route('partner.dashboard'),
            default   => redirect()->route('customer.dashboard'),
        };
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // General Profile Management (All Roles)
    Route::get('/profile/manage', [ProfileManagementController::class, 'edit'])->name('profile.manage');
    Route::put('/profile/manage', [ProfileManagementController::class, 'update'])->name('profile.manage.update');
    Route::put('/profile/password', [ProfileManagementController::class, 'updatePassword'])->name('profile.password.update');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-read');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
});

/*
|--------------------------------------------------------------------------
| CUSTOMER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {

    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

    // Vouchers
    Route::post('/voucher/{voucher}/redeem', [CustomerDashboardController::class, 'redeemVoucher'])->name('voucher.redeem');
    Route::get('/vouchers', [CustomerDashboardController::class, 'myVouchers'])->name('vouchers.index');

    Route::post('/reward/{reward}/redeem', [CustomerDashboardController::class, 'redeemReward'])->name('reward.redeem');

    // Payment
    Route::get('/payment/{registration}', [EventRegistrationController::class, 'payment'])->name('payment.show');
Route::get('/payment/{registration}/success',
    [EventRegistrationController::class, 'paymentSuccess']
)->name('payment.success');

    // Ticket PDF
    Route::get('/ticket/{ticket}/pdf', [CustomerDashboardController::class, 'generateTicketPdf'])->name('ticket.pdf');

Route::get('/ticket/verify/{ticket_number}', function ($ticket_number) {

    $ticket = Ticket::where(
        'ticket_number',
        $ticket_number
    )->first();

    if (!$ticket) {
        return "Ticket invalid";
    }

    return view('customer.tickets.verify', compact('ticket'));

})->name('ticket.verify');

    // Transactions
    Route::get('/transactions', [CustomerTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [CustomerTransactionController::class, 'show'])->name('transactions.show');

    // Feedback
    // Feedback
Route::get(
    '/event/{event}/feedback',
    [CustomerFeedbackController::class, 'create']
)->name('event.feedback.create');

Route::post(
    '/event/{event}/feedback',
    [CustomerFeedbackController::class, 'store']
)->name('event.feedback.store');
Route::get(
    '/feedback/history',
    [CustomerFeedbackController::class, 'history']
)->name('feedback.history');
Route::get(
'/event/{event}/feedback/view',
[CustomerFeedbackController::class,'show']
)->name('event.feedback.show');
Route::get(
'/event/{event}/feedback/edit',
[CustomerFeedbackController::class,'edit']
)->name('event.feedback.edit');

Route::put(
'/event/{event}/feedback/update',
[CustomerFeedbackController::class,'update']
)->name('event.feedback.update');

    // Points history
    Route::get('/points/history', [CustomerDashboardController::class, 'pointHistory'])->name('points.history');
});

/*
|--------------------------------------------------------------------------
| PARTNER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:partner'])->prefix('partner')->name('partner.')->group(function () {

    Route::get('/dashboard', [PartnerEventController::class, 'dashboard'])->name('dashboard');

    Route::resource('events', PartnerEventController::class)->except(['destroy']);

    Route::post('/events/{event}/submit', [PartnerEventController::class, 'submit'])->name('events.submit');

    Route::get('/events/{event}/participants', [PartnerEventController::class, 'participants'])->name('events.participants');
    Route::get('/events/{event}/feedbacks', [PartnerEventController::class, 'feedbacks'])->name('events.feedbacks');
    Route::get('/events/{event}/checkins', [PartnerEventController::class, 'checkins'])->name('events.checkins');
    Route::get('/events/{event}/export/pdf', [PartnerEventController::class, 'exportEventPdf'])->name('events.export.pdf');
    Route::get('/events/{event}/export/csv', [PartnerEventController::class, 'exportEventCsv'])->name('events.export.csv');

    // Partner QR Check-in
    Route::get('/checkin/scan', [PartnerCheckinController::class, 'scan'])->name('checkin.scan');
    Route::post('/checkin/process', [PartnerCheckinController::class, 'process'])->name('checkin.process');
});

/*
|--------------------------------------------------------------------------
| MANAGER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:manager'])->prefix('manager')->name('manager.')->group(function () {

    Route::get('/dashboard', [ReportController::class, 'dashboard'])->name('dashboard');

    // Events
    Route::get('/events', [ReportController::class, 'events'])->name('events.index');
    Route::get('/events/export/pdf', [ReportController::class, 'exportEventsPdf'])->name('events.export.pdf');
    Route::get('/events/export/csv', [ReportController::class, 'exportEventsCsv'])->name('events.export.csv');

    // Users
    Route::get('/users', [ReportController::class, 'users'])->name('users.index');
    Route::get('/users/export/pdf', [ReportController::class, 'exportUsersPdf'])->name('users.export.pdf');
    Route::get('/users/export/csv', [ReportController::class, 'exportUsersCsv'])->name('users.export.csv');

    // Transactions
    Route::get('/transactions', [ReportController::class, 'transactions'])->name('transactions.index');
    Route::get('/transactions/export/pdf', [ReportController::class, 'exportTransactionsPdf'])->name('transactions.export.pdf');
    Route::get('/transactions/export/csv', [ReportController::class, 'exportTransactionsCsv'])->name('transactions.export.csv');

    // Rewards
    Route::get('/rewards', [ReportController::class, 'rewards'])->name('rewards.index');
    Route::get('/rewards/export/pdf', [ReportController::class, 'exportRewardsPdf'])->name('rewards.export.pdf');
    Route::get('/rewards/export/csv', [ReportController::class, 'exportRewardsCsv'])->name('rewards.export.csv');

    // Engagement
    Route::get('/engagement', [ReportController::class, 'engagement'])->name('engagement.index');
    Route::get('/engagement/export/pdf', [ReportController::class, 'exportEngagementPdf'])->name('engagement.export.pdf');
    Route::get('/engagement/export/csv', [ReportController::class, 'exportEngagementCsv'])->name('engagement.export.csv');

    // Feedback Reports
    Route::get('/feedback', [ReportController::class, 'feedbacks'])->name('feedback.index');
    Route::get('/feedback/export/pdf', [ReportController::class, 'exportFeedbacksPdf'])->name('feedback.export.pdf');
    Route::get('/feedback/export/csv', [ReportController::class, 'exportFeedbacksCsv'])->name('feedback.export.csv');

    // Partner Reports
    Route::get('/partners', [ReportController::class, 'partners'])->name('partners.index');
    Route::get('/partners/export/pdf', [ReportController::class, 'exportPartnersPdf'])->name('partners.export.pdf');
    Route::get('/partners/export/csv', [ReportController::class, 'exportPartnersCsv'])->name('partners.export.csv');

    // Customer Reports  
    Route::get('/customers', [ReportController::class, 'customers'])->name('customers.index');
    Route::get('/customers/export/pdf', [ReportController::class, 'exportCustomersPdf'])->name('customers.export.pdf');
    Route::get('/customers/export/csv', [ReportController::class, 'exportCustomersCsv'])->name('customers.export.csv');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Event Management
    Route::resource('event', EventController::class)->except(['show']);

    Route::get('/event/verification', [EventVerificationController::class, 'index'])->name('event.verification');
    Route::post('/event/{event}/verify', [EventVerificationController::class, 'verify'])->name('event.verify');
    Route::post('/event/{event}/reject', [EventVerificationController::class, 'reject'])->name('event.reject');
    Route::get('/event/{event}/detail', [EventVerificationController::class, 'show'])->name('event.detail');
    Route::post('/event/{event}/publish', [EventVerificationController::class, 'publish'])->name('event.publish');
    Route::post('/event/{event}/unpublish', [EventVerificationController::class, 'unpublish'])->name('event.unpublish');

    Route::get('/event-participants', [EventParticipantController::class, 'index'])->name('event.participants');
    Route::get('/event-participants/{event}', [EventParticipantController::class, 'show'])->name('event.participants.detail');
    Route::get('/event-participants/{event}/participant/{ticket}', [EventParticipantController::class, 'participantDetail'])->name('event.participants.participant');
    Route::get('/event-participants/ticket/{ticket}/download', [EventParticipantController::class, 'downloadTicket'])->name('event.participants.ticket.download');

    // Check-in
    Route::get('/checkin/scan', [AdminCheckinController::class, 'scan'])->name('checkin.scan');
    Route::post('/checkin/process', [AdminCheckinController::class, 'process'])->name('checkin.process');

    // Gallery
    // Route::resource('gallery', GalleryController::class);

    // Products
    Route::resource('product', ProductController::class);

    // Pressroom
    Route::resource('pressroom', PressroomController::class);

    // Media Inquiries
    Route::get('/media-inquiries', [MediaInquiryController::class, 'index'])->name('media.inquiries');
    Route::get('/media-inquiries/{id}', [MediaInquiryController::class, 'show'])->name('media.inquiries.show');
    Route::post('/media-inquiries/{id}/reply', [MediaInquiryController::class, 'reply'])->name('media.inquiries.reply');
    Route::delete('/media-inquiries/{id}', [MediaInquiryController::class, 'destroy'])->name('media.inquiries.delete');

    // Outlets
    Route::resource('outlets', OutletController::class);
    Route::patch('outlets/{outlet}/toggle-status', [OutletController::class, 'toggleStatus'])->name('outlets.toggle-status');
    Route::patch('outlets/{outlet}/assign-partner', [OutletController::class, 'assignPartner'])->name('outlets.assign-partner');
    Route::get('outlets/{outlet}/products', [OutletController::class, 'manageProducts'])->name('outlets.products');
    Route::post('outlets/{outlet}/products', [OutletController::class, 'updateProducts'])->name('outlets.products.update');

    // Users
    Route::resource('users', UserController::class)->except(['show', 'destroy']);
    Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Points & Rewards
    Route::prefix('points')->name('points.')->group(function () {
        Route::get('/users', [UserPointController::class, 'index'])->name('users');
        Route::get('/users/{user}/detail', [UserPointController::class, 'show'])->name('users.detail');
        Route::resource('rewards', RewardController::class)->except(['show']);
        Route::patch('rewards/{reward}/toggle-status', [RewardController::class, 'toggleStatus'])->name('rewards.toggle-status');
        Route::get('/redemptions', [RewardRedemptionController::class, 'index'])->name('redemptions');
    });

    // Vouchers
    Route::resource('vouchers', VoucherController::class)->except(['show']);



    // Messages & Chat Topics
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [AdminLiveChatController::class, 'index'])->name('index');
        Route::get('/analytics', [AdminLiveChatController::class, 'analytics'])->name('analytics');
        Route::get('/{session}', [AdminLiveChatController::class, 'show'])->name('show');
        Route::post('/{session}/reply', [AdminLiveChatController::class, 'reply'])->name('reply');
        Route::post('/{session}/close', [AdminLiveChatController::class, 'close'])->name('close');
        Route::get('/{session}/messages', [AdminLiveChatController::class, 'fetchMessages'])->name('messages');
    });

    Route::post('chat-topics/seed', [ChatTopicController::class, 'seedDefaults'])->name('chat-topics.seed');
    Route::resource('chat-topics', ChatTopicController::class)->except(['show']);

    // Feedback
    Route::get('/feedback', [AdminFeedbackController::class, 'index'])->name('feedback.index');
    Route::get('/feedback/{feedback}', [AdminFeedbackController::class, 'show'])->name('feedback.show');

    // Instagram
    Route::resource('instagram', InstagramController::class)->except(['show']);

});

/*
|--------------------------------------------------------------------------
| Breeze Auth
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
