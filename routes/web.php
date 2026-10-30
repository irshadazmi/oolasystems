<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\ChatbotController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Public Website
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'home'])
    ->name('home');

Route::get('/about', [PageController::class, 'about'])
    ->name('about');

Route::get('/services', [PageController::class, 'services'])
    ->name('services');

Route::get('/industries', [PageController::class, 'industries'])
    ->name('industries');

Route::get('/portfolio', [PageController::class, 'portfolio'])
    ->name('portfolio');

Route::get('/learnings', [PageController::class, 'learnings'])
    ->name('learnings');

Route::get('/contact', [PageController::class, 'contact'])
    ->name('contact');

Route::get('/privacy', [PageController::class, 'privacy'])
    ->name('privacy');

Route::get('/terms', [PageController::class, 'terms'])
    ->name('terms');

Route::get('/sitemap', [PageController::class, 'sitemap'])
    ->name('sitemap');


/*
|--------------------------------------------------------------------------
| Public Careers
|--------------------------------------------------------------------------
*/

Route::get('/careers', [CareerController::class, 'publicIndex'])
    ->name('careers');


/*
|--------------------------------------------------------------------------
| Public Contact & Inquiry Submission
|--------------------------------------------------------------------------
*/

Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.submit');

Route::post('/inquiry', [InquiryController::class, 'store'])
    ->name('inquiry.submit');

Route::post('/chatbot/message', [ChatbotController::class, 'message'])->name('chatbot.message');

Route::post('/chatbot/reset', [ChatbotController::class, 'reset'])->name('chatbot.reset');


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.submit');


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| All inquiry, lead-management and AI lead-analysis functionality
| is handled by InquiryController.
|
*/

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/', [PageController::class, 'admin'])
            ->name('dashboard');

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');


        /*
        |--------------------------------------------------------------------------
        | Contacts
        |--------------------------------------------------------------------------
        */

        Route::get('/contacts', [ContactController::class, 'index'])
            ->name('contacts.index');

        Route::get('/contacts/{contact}', [ContactController::class, 'show'])
            ->name('contacts.show');

        Route::get('/contacts/{contact}/edit', [ContactController::class, 'edit'])
            ->name('contacts.edit');

        Route::patch('/contacts/{contact}', [ContactController::class, 'update'])
            ->name('contacts.update');

        Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])
            ->name('contacts.destroy');


        /*
        |--------------------------------------------------------------------------
        | Inquiries
        |--------------------------------------------------------------------------
        |
        | InquiryController handles:
        |
        | - Inquiry CRUD
        | - Lead management
        | - AI lead analysis
        | - AI re-analysis
        | - Follow-up management
        | - Contact tracking
        |
        */

        Route::get('/inquiries', [InquiryController::class, 'index'])
            ->name('inquiries.index');

        Route::get('/inquiries/{inquiry}', [InquiryController::class, 'show'])
            ->name('inquiries.show');

        Route::get('/inquiries/{inquiry}/edit', [InquiryController::class, 'edit'])
            ->name('inquiries.edit');

        Route::patch('/inquiries/{inquiry}', [InquiryController::class, 'update'])
            ->name('inquiries.update');

        Route::delete('/inquiries/{inquiry}', [InquiryController::class, 'destroy'])
            ->name('inquiries.destroy');


        /*
        |--------------------------------------------------------------------------
        | AI Lead Analysis
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/inquiries/{inquiry}/reanalyze',
            [InquiryController::class, 'reanalyze']
        )->name('inquiries.reanalyze');


        /*
        |--------------------------------------------------------------------------
        | Lead Management
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/inquiries/{inquiry}/lead-status',
            [InquiryController::class, 'updateLeadStatus']
        )->name('inquiries.lead-status');


        Route::post(
            '/inquiries/{inquiry}/follow-up',
            [InquiryController::class, 'updateFollowUp']
        )->name('inquiries.follow-up');


        Route::post(
            '/inquiries/{inquiry}/mark-contacted',
            [InquiryController::class, 'markContacted']
        )->name('inquiries.mark-contacted');


        /*
        |--------------------------------------------------------------------------
        | Careers - Admin
        |--------------------------------------------------------------------------
        */

        Route::get('/careers', [CareerController::class, 'index'])
            ->name('careers.index');

        Route::get('/careers/create', [CareerController::class, 'create'])
            ->name('careers.create');

        Route::post('/careers', [CareerController::class, 'store'])
            ->name('careers.store');

        Route::get('/careers/{career}', [CareerController::class, 'show'])
            ->name('careers.show');

        Route::get('/careers/{career}/edit', [CareerController::class, 'edit'])
            ->name('careers.edit');

        Route::patch('/careers/{career}', [CareerController::class, 'update'])
            ->name('careers.update');

        Route::delete('/careers/{career}', [CareerController::class, 'destroy'])
            ->name('careers.destroy');


        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */

        Route::get('/users', [UserController::class, 'index'])
            ->name('users.index');

        Route::get('/users/create', [UserController::class, 'create'])
            ->name('users.create');

        Route::post('/users', [UserController::class, 'store'])
            ->name('users.store');

        Route::get('/users/{user}', [UserController::class, 'show'])
            ->name('users.show');

        Route::get('/users/{user}/edit', [UserController::class, 'edit'])
            ->name('users.edit');

        Route::patch('/users/{user}', [UserController::class, 'update'])
            ->name('users.update');

        Route::delete('/users/{user}', [UserController::class, 'destroy'])
            ->name('users.destroy');


        /*
        |--------------------------------------------------------------------------
        | Visitors
        |--------------------------------------------------------------------------
        */

        Route::get('/visitors', [VisitorController::class, 'index'])
            ->name('visitors.index');

        Route::get('/visitors/{visitor}', [VisitorController::class, 'show'])
            ->name('visitors.show');

        Route::get('/visitors/{visitor}/edit', [VisitorController::class, 'edit'])
            ->name('visitors.edit');

        Route::patch('/visitors/{visitor}', [VisitorController::class, 'update'])
            ->name('visitors.update');

        Route::delete('/visitors/{visitor}', [VisitorController::class, 'destroy'])
            ->name('visitors.destroy');

    });


/*
|--------------------------------------------------------------------------
| Tutorials
|--------------------------------------------------------------------------
|
| Keep all existing URL paths and route names. Only replace each controller
| action with the generic index/show methods. TutorialController resolves
| which tutorial to load from the current route name.
|
*/

Route::prefix('tutorials')->group(function () {
    Route::get('/agenticai', [TutorialController::class, 'index'])
        ->name('tutorial.agenticai.index');
    Route::get('/agenticai/{slug}', [TutorialController::class, 'show'])
        ->name('tutorial.agenticai.show');

    Route::get('/linuxadmin', [TutorialController::class, 'index'])
        ->name('tutorial.linuxadmin.index');
    Route::get('/linuxadmin/{slug}', [TutorialController::class, 'show'])
        ->name('tutorial.linuxadmin.show');

    Route::get('/cybersecurity', [TutorialController::class, 'index'])
        ->name('tutorial.cybersecurity.index');
    Route::get('/cybersecurity/{slug}', [TutorialController::class, 'show'])
        ->name('tutorial.cybersecurity.show');

    Route::get('/githubjira', [TutorialController::class, 'index'])
        ->name('tutorial.githubjira.index');
    Route::get('/githubjira/{slug}', [TutorialController::class, 'show'])
        ->name('tutorial.githubjira.show');

    Route::get('/javafundamentals', [TutorialController::class, 'index'])
        ->name('tutorial.javafundamentals.index');
    Route::get('/javafundamentals/{slug}', [TutorialController::class, 'show'])
        ->name('tutorial.javafundamentals.show');

    Route::get('/reactnative', [TutorialController::class, 'index'])
        ->name('tutorial.reactnative.index');
    Route::get('/reactnative/{slug}', [TutorialController::class, 'show'])
        ->name('tutorial.reactnative.show');

    Route::get('/gcpdatamodeling', [TutorialController::class, 'index'])
        ->name('tutorial.gcpdatamodeling.index');
    Route::get('/gcpdatamodeling/{slug}', [TutorialController::class, 'show'])
        ->name('tutorial.gcpdatamodeling.show');

    Route::get('/selenium', [TutorialController::class, 'index'])
        ->name('tutorial.selenium.index');
    Route::get('/selenium/{slug}', [TutorialController::class, 'show'])
        ->name('tutorial.selenium.show');

    Route::get('/springboot', [TutorialController::class, 'index'])
        ->name('tutorial.springboot.index');
    Route::get('/springboot/{slug}', [TutorialController::class, 'show'])
        ->name('tutorial.springboot.show');

    Route::get('/dotnet/fundamental', [TutorialController::class, 'index'])
        ->name('tutorial.dotnet.fundamental.index');
    Route::get('/dotnet/fundamental/{slug}', [TutorialController::class, 'show'])
        ->name('tutorial.dotnet.fundamental.show');

    Route::get('/dotnet/core', [TutorialController::class, 'index'])
        ->name('tutorial.dotnet.core.index');
    Route::get('/dotnet/core/{slug}', [TutorialController::class, 'show'])
        ->name('tutorial.dotnet.core.show');

    Route::get('/dotnet/database', [TutorialController::class, 'index'])
        ->name('tutorial.dotnet.database.index');
    Route::get('/dotnet/database/{slug}', [TutorialController::class, 'show'])
        ->name('tutorial.dotnet.database.show');

    Route::get('/dotnet/frontend', [TutorialController::class, 'index'])
        ->name('tutorial.dotnet.frontend.index');
    Route::get('/dotnet/frontend/{slug}', [TutorialController::class, 'show'])
        ->name('tutorial.dotnet.frontend.show');
});

Route::get('/industrial-training', [ProjectController::class, 'index'])
    ->name('oolalabs.projects.index');
Route::get('/industrial-training/{slug}', [ProjectController::class, 'show'])
    ->where('slug', '[A-Za-z0-9_-]+')
    ->name('oolalabs.projects.show');


/*
|--------------------------------------------------------------------------
| CAPTCHA Refresh
|--------------------------------------------------------------------------
*/

Route::get('/refresh-captcha/{type}', function ($type) {

    $a = rand(1, 9);
    $b = rand(1, 9);

    $question = "$a + $b = ?";
    $answer = $a + $b;

    if ($type === 'contact') {

        session([
            'captcha_contact_question' => $question,
            'captcha_contact_answer' => $answer,
        ]);

    } else {

        session([
            'captcha_inquiry_question' => $question,
            'captcha_inquiry_answer' => $answer,
        ]);
    }

    return response()->json([
        'question' => $question,
    ]);
});


/*
|--------------------------------------------------------------------------
| Development Utilities
|--------------------------------------------------------------------------
|
| IMPORTANT:
| These routes should not be exposed in production.
|
|--------------------------------------------------------------------------
*/

Route::get('/dev/run-migrate', function () {

    abort_unless(
        request('key') === 'oola@123',
        403
    );

    Artisan::call(
        'migrate',
        ['--force' => true]
    );

    return 'Migration completed';
});


Route::get('/dev/run-migrate-careers', function () {

    abort_unless(
        request('key') === 'oola@123',
        403
    );

    Artisan::call(
        'migrate',
        [
            '--path' =>
                'database/migrations/2026_08_08_103219_create_careers_table.php',
            '--force' => true,
        ]
    );

    return 'Careers migration completed';
});


Route::get('/dev/clear-cache', function () {

    abort_unless(
        request('key') === 'oola@123',
        403
    );

    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');

    return 'Cache cleared';
});
