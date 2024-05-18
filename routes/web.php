<?php

use App\Models\Organization;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FinancialTransactionController;

Route::get('/', \App\Livewire\Page::class)->name('home');
Route::get('/tentang', \App\Livewire\Page::class)->name('about');

Route::get('/ppdb', \App\Livewire\Page::class)->name('ppdb.index');
Route::get('/ppdb/formulir', \App\Livewire\Ppdb\Registration::class)->name('student-registration');
Route::get('/ppdb/biaya', \App\Livewire\Ppdb\Price::class)->name('ppdb.price');

Route::get('/peraturan', \App\Livewire\Law\Index::class)->name('law.index');

Route::get('/lembaga/{slug}', \App\Livewire\Organization\Show::class)->name('organizations.show');

Route::get('/blog', \App\Livewire\Post\Index::class)->name('posts.index');
Route::get('/blog/{slug}', \App\Livewire\Post\Show::class)->name('posts.show');

Route::get('/orang-tua', \App\Livewire\Guardian\Login::class)->name('guardian.login');
Route::get('/orang-tua/santri/{token}', \App\Livewire\Guardian\ViewProfileStudent::class)->name('guardian.view-profile-student');

Route::middleware('auth')->group(function () {
    Route::get('/admin/financial-transactions/pdf', [FinancialTransactionController::class, 'generatePdfReport'])->name('admin.financial-transactions.pdf');
});

Route::get('/pdf', function () {
    return view('reports.pdf_financial_transactions_v2', [
        'transactions' => [],
        'yayasan' => Organization::query()
            ->where('slug', 'yayasan-pondok-pesantren-ki-ageng-mbodo')
            ->first(),
    ]);
})->name('pdf');

require __DIR__ . '/auth.php';

// Route::fallback(\App\Livewire\Page::class);
