<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Home::class)->name('home');
Route::get('/about', \App\Livewire\About::class)->name('about');
Route::get('/pesantren-putra', \App\Livewire\PesantrenPutra::class)->name('pesantren-putra');

Route::get('/ppdb', \App\Livewire\Ppdb\Index::class)->name('ppdb.index');
Route::get('/ppdb/formulir', \App\Livewire\StudentRegistrationForm::class)->name('student-regis tration');
Route::get('/ppdb/biaya', \App\Livewire\Ppdb\Price::class)->name('ppdb.price');

Route::get('/organizations/{slug}', App\Livewire\OrganizationShow::class)->name('organizations.show');

Route::get('/peraturan', \App\Livewire\Law\Index::class)->name('law.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
