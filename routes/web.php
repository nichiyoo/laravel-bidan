<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PatientController as AdminPatientController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ReviewController;

use App\Models\Article;
use App\Models\Service;

Route::get('/', function () {
    $articles = Article::where('status', '=', 'published')->take(3)->get();
    $services = Service::take(3)->get();

    return view('welcome', [
        'articles' => $articles,
        'services' => $services,
    ]);
})->name('welcome');

Route::get('/articles', function () {
    $articles = Article::where('status', '=', 'published')->paginate(6)->withQueryString();
    return view('articles.index', [
        'articles' => $articles
    ]);
})->name('articles.index');

Route::get('/articles/{article}', function (Article $article) {
    $article->views += 1;
    $article->save();

    return view('articles.show', [
        'article' => $article
    ]);
})->name('articles.show');

Route::get('/services', function () {
    $services = Service::paginate(6)->withQueryString();

    return view('services.index', [
        'services' => $services,
    ]);
})->name('services.index');

Route::get('/testimonials', function () {
    return view('testimonials.index');
})->name('testimonials.index');

/**
 * Helper to redirect to dashboard
 */
Route::middleware('auth')->get('/dashboard', function () {
    return redirect()->route(auth()->user()->role . 's.dashboards.index');
})->name('dashboard');

/**
 * Admin Related Routes
 */
Route::middleware(['auth', 'role:admin'])
    ->prefix('admins')
    ->name('admins.')
    ->group(function () {
        Route::resource('dashboards', AdminDashboardController::class)->only(['index']);

        Route::get('appointments/{appointment}/diagnoses/create', [DiagnosisController::class, 'create'])->name('appointments.diagnoses.create');
        Route::post('appointments/{appointment}/diagnoses/store', [DiagnosisController::class, 'store'])->name('appointments.diagnoses.store');
        Route::get('diagnoses/{diagnosis}/edit', [DiagnosisController::class, 'edit'])->name('diagnoses.edit');
        Route::put('diagnoses/{diagnosis}/update', [DiagnosisController::class, 'update'])->name('diagnoses.update');

        // export
        Route::get('users/export', [AdminUserController::class, 'export'])->name('users.export');
        Route::get('patients/export', [AdminPatientController::class, 'export'])->name('patients.export');
        Route::get('articles/export', [AdminArticleController::class, 'export'])->name('articles.export');
        Route::get('services/export', [AdminServiceController::class, 'export'])->name('services.export');
        Route::get('payments/export', [AdminPaymentController::class, 'export'])->name('payments.export');
        Route::get('appointments/export', [AppointmentController::class, 'export'])->name('appointments.export');
        Route::get('diagnoses/export', [DiagnosisController::class, 'export'])->name('diagnoses.export');
        Route::get('reviews/export', [ReviewController::class, 'export'])->name('reviews.export');

        Route::get('users/report', [AdminUserController::class, 'report'])->name('users.report');
        Route::get('patients/report', [AdminPatientController::class, 'report'])->name('patients.report');
        Route::get('articles/report', [AdminArticleController::class, 'report'])->name('articles.report');
        Route::get('services/report', [AdminServiceController::class, 'report'])->name('services.report');
        Route::get('payments/report', [AdminPaymentController::class, 'report'])->name('payments.report');
        Route::get('appointments/report', [AppointmentController::class, 'report'])->name('appointments.report');
        Route::get('diagnoses/report', [DiagnosisController::class, 'report'])->name('diagnoses.report');
        Route::get('reviews/report', [ReviewController::class, 'report'])->name('reviews.report');

        Route::resource('users', AdminUserController::class)->except(['show']);
        Route::resource('patients', AdminPatientController::class)->except(['show']);
        Route::resource('payments', AdminPaymentController::class)->except(['show']);
        Route::resource('services', AdminServiceController::class)->except(['show']);
        Route::resource('articles', AdminArticleController::class)->except(['show']);
        Route::resource('reviews', ReviewController::class)->only(['edit', 'update', 'destroy']);
    });

/**
 * Patient Related Routes
 */
Route::middleware(['auth', 'role:patient,admin'])
    ->prefix('patients')
    ->name('patients.')
    ->group(function () {
        Route::resource('dashboards', DashboardController::class);

        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::delete('appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
        Route::resource('appointments', AppointmentController::class);

        Route::resource('receipts', ReceiptController::class)->only(['index']);
        Route::resource('diagnoses', DiagnosisController::class)->only(['index', 'show']);
        Route::resource('reviews', ReviewController::class)->except(['edit', 'update', 'destroy']);
    });


require __DIR__ . '/auth.php';
