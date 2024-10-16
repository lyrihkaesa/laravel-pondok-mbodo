<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Page::class)->name('home');
Route::get('/tentang', \App\Livewire\Page::class)->name('about');

Route::get('/login', function () {
    return redirect()->route('filament.admin.auth.login');
})->name('login');

Route::get('/ppdb', \App\Livewire\Page::class)->name('ppdb.index');
Route::get('/ppdb/formulir', \App\Livewire\Ppdb\Registration::class)->name('student-registration');
Route::get('/ppdb/biaya', \App\Livewire\Page::class)->name('ppdb.price');

Route::get('/peraturan', \App\Livewire\Law\Index::class)->name('law.index');

Route::get('/lembaga/{slug}', \App\Livewire\Organization\Show::class)->name('organizations.show');

Route::get('/blog', \App\Livewire\Post\Index::class)->name('posts.index');
Route::get('/blog/{slug}', \App\Livewire\Post\Show::class)->name('posts.show');

Route::get('/orang-tua', \App\Livewire\Guardian\Login::class)->name('guardian.login');
Route::get('/orang-tua/santri/{token}', \App\Livewire\Guardian\ViewProfileStudent::class)->name('guardian.view-profile-student');

Route::get('auth/{provider}', [\App\Http\Controllers\ConnectedAccountController::class, 'redirectToProvider'])
    ->name('auth.redirect');

Route::get('auth/{provider}/callback', [\App\Http\Controllers\ConnectedAccountController::class, 'handleProviderCallback'])
    ->name('auth.callback');

Route::middleware('auth')->group(function () {
    Route::get('/admin/financial-transactions/pdf', [Controllers\FinancialTransactionController::class, 'generatePdfReport'])->name('admin.financial-transactions.pdf');
    Route::get('/admin/student-bill/pdf', [Controllers\StudentBillController::class, 'generatePdfReport'])->name('admin.student-bill.pdf');
});

Route::get('/pdf', function () {
    return view('reports.pdf_financial_transactions_v2', [
        'transactions' => [],
        'yayasan' =>  \App\Models\Organization::query()
            ->where('slug', 'yayasan-pondok-pesantren-ki-ageng-mbodo')
            ->first(),
    ]);
})->name('pdf');

// require __DIR__ . '/auth.php';

Route::fallback(\App\Livewire\Page::class);
