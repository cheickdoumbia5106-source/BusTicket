<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\ReservationController;
use App\Http\Controllers\Client\SearchController;
use App\Http\Controllers\Client\TicketController;
use Illuminate\Support\Facades\Auth;

// Routes publiques
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/recherche', [SearchController::class, 'search'])->name('search');
Route::get('/trajet/{id}/sieges', [SearchController::class, 'showSieges'])->name('sieges.show');

// Routes protégées (authentification requise)
Route::middleware(['auth'])->group(function () {
    // Réservation
    Route::post('/reservation/preparer', [ReservationController::class, 'prepare'])->name('reservation.prepare');
    Route::get('/reservation/recapitulatif', [ReservationController::class, 'recap'])->name('reservation.recap');
    Route::post('/reservation/confirmer', [ReservationController::class, 'confirm'])->name('reservation.confirm');
    
    // Paiement
    Route::get('/paiement/{reservation}/{mode}', [PaymentController::class, 'process'])->name('paiement.process');
    Route::post('/paiement/simuler/{reservation}', [PaymentController::class, 'simulatePayment'])->name('paiement.simulate');
    
    // Ticket
    Route::get('/ticket/{reservation}', [TicketController::class, 'show'])->name('ticket.show');
    Route::get('/ticket/{reservation}/download', [TicketController::class, 'download'])->name('ticket.download');
    
    // Profil
    Route::get('/mon-compte', [ProfileController::class, 'index'])->name('profile');
    Route::put('/mon-compte', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/mon-compte/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/reservation/{reservation}/annuler', [ProfileController::class, 'cancelReservation'])->name('reservation.cancel');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

require __DIR__.'/auth.php';
