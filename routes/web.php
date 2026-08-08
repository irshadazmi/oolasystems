<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\VisitorController;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/industries', [PageController::class, 'industries'])->name('industries');
Route::get('/portfolio', [PageController::class, 'portfolio'])->name('portfolio');
Route::get('/resources', [PageController::class, 'resources'])->name('resources');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/sitemap', [PageController::class, 'sitemap'])->name('sitemap');
Route::get('/careers', [PageController::class, 'careers'])->name('careers');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');
Route::post('/inquiry', [InquiryController::class, 'store'])->name('inquiry.submit');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/careers', [CareerController::class, 'publicIndex'])->name('careers');

// Admin Routes (Protected by auth middleware)
Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [PageController::class, 'admin'])->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Contacts
        Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
        Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
        Route::get('/contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
        Route::patch('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
        Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

        // Inquiries
        Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
        Route::get('/inquiries/{inquiry}', [InquiryController::class, 'show'])->name('inquiries.show');
        Route::get('/inquiries/{inquiry}/edit', [InquiryController::class, 'edit'])->name('inquiries.edit');
        Route::patch('/inquiries/{inquiry}', [InquiryController::class, 'update'])->name('inquiries.update');
        Route::delete('/inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('inquiries.destroy');

        // Careers
        Route::get('/careers', [CareerController::class, 'index'])->name('careers.index');
        Route::get('/careers/create', [CareerController::class, 'create'])->name('careers.create');
        Route::post('/careers', [CareerController::class, 'store'])->name('careers.store');
        Route::get('/careers/{career}', [CareerController::class, 'show'])->name('careers.show');
        Route::get('/careers/{career}/edit', [CareerController::class, 'edit'])->name('careers.edit');
        Route::patch('/careers/{career}', [CareerController::class, 'update'])->name('careers.update');
        Route::delete('/careers/{career}', [CareerController::class, 'destroy'])->name('careers.destroy');

        // Users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Visitors
        Route::get('/visitors', [VisitorController::class, 'index'])->name('visitors.index');
        Route::get('/visitors/{visitor}', [VisitorController::class, 'show'])->name('visitors.show');
        Route::get('/visitors/{visitor}/edit', [VisitorController::class, 'edit'])->name('visitors.edit');
        Route::patch('/visitors/{visitor}', [VisitorController::class, 'update'])->name('visitors.update');
        Route::delete('/visitors/{visitor}', [VisitorController::class, 'destroy'])->name('visitors.destroy');
    });

Route::prefix('tutorials')->group(function () {
    // Agentic AI
    Route::get('/agenticai', [TutorialController::class, 'agenticAIIndex'])->name('tutorial.agenticai.index');
    Route::get('/agenticai/{slug}', [TutorialController::class, 'agenticAIShow'])->name('tutorial.agenticai.show');

    // Java Fundamentals
    Route::get('/javafundamentals', [TutorialController::class, 'javaFundamentalsIndex'])->name('tutorial.javafundamentals.index');
    Route::get('/javafundamentals/{slug}', [TutorialController::class, 'javaFundamentalsShow'])->name('tutorial.javafundamentals.show');

    // React Native
    Route::get('/reactnative', [TutorialController::class, 'reactNativeIndex'])->name('tutorial.reactnative.index');
    Route::get('/reactnative/{slug}', [TutorialController::class, 'reactNativeShow'])->name('tutorial.reactnative.show');

    // GCP Data Modeling
    Route::get('/gcpdatamodeling', [TutorialController::class, 'gcpDataModelingIndex'])->name('tutorial.gcpdatamodeling.index');
    Route::get('/gcpdatamodeling/{slug}', [TutorialController::class, 'gcpDataModelingShow'])->name('tutorial.gcpdatamodeling.show');


    // Selenium
    Route::get('/selenium', [TutorialController::class, 'seleniumIndex'])->name('tutorial.selenium.index');
    Route::get('/selenium/{slug}', [TutorialController::class, 'seleniumShow'])->name('tutorial.selenium.show');

    // Spring Boot
    Route::get('/springboot', [TutorialController::class, 'springBootIndex'])->name('tutorial.springboot.index');
    Route::get('/springboot/{slug}', [TutorialController::class, 'springBootShow'])->name('tutorial.springboot.show');

    // .NET fundamental Fundamentals
    Route::get('/dotnet/fundamental', [TutorialController::class, 'dotnetfundamentalIndex'])->name('tutorial.dotnet.fundamental.index');
    Route::get('/dotnet/fundamental/{slug}', [TutorialController::class, 'dotnetfundamentalShow'])->name('tutorial.dotnet.fundamental.show');

    // .NET Core & Web Development
    Route::get('/dotnet/core', [TutorialController::class, 'dotnetCoreIndex'])->name('tutorial.dotnet.core.index');
    Route::get('/dotnet/core/{slug}', [TutorialController::class, 'dotnetCoreShow'])->name('tutorial.dotnet.core.show');

    // Database & Data Access
    Route::get('/dotnet/database', [TutorialController::class, 'dotnetDatabaseIndex'])->name('tutorial.dotnet.database.index');
    Route::get('/dotnet/database/{slug}', [TutorialController::class, 'dotnetDatabaseShow'])->name('tutorial.dotnet.database.show');

    // Frontend
    Route::get('/dotnet/frontend', [TutorialController::class, 'dotnetFrontendIndex'])->name('tutorial.dotnet.frontend.index');
    Route::get('/dotnet/frontend/{slug}', [TutorialController::class, 'dotnetFrontendShow'])->name('tutorial.dotnet.frontend.show');
});


// routes/web.php
Route::get('/refresh-captcha/{type}', function ($type) {

    $a = rand(1, 9);
    $b = rand(1, 9);

    $question = "$a + $b = ?";
    $answer = $a + $b;

    if ($type === 'contact') {
        session([
            'captcha_contact_question' => $question,
            'captcha_contact_answer' => $answer
        ]);
    } else {
        session([
            'captcha_inquiry_question' => $question,
            'captcha_inquiry_answer' => $answer
        ]);
    }

    return response()->json(['question' => $question]);
});

Route::get('/dev/run-migrate', function () {
    abort_unless(request('key') === 'oola@123', 403);

    Artisan::call('migrate', ['--force' => true]);
    return 'Migration completed';
});

Route::get('/dev/run-migrate-careers', function () {

    abort_unless(request('key') === 'oola@123', 403);

    Artisan::call('migrate', [
        '--path' => 'database/migrations/2026_08_08_103219_create_careers_table.php',
        '--force' => true,
    ]);

    return 'Careers migration completed';

});

Route::get('/dev/clear-cache', function () {
    abort_unless(request('key') === 'oola@123', 403);

    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');

    return 'Cache cleared';
});
