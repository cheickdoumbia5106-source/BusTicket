<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\ReservationController;
use App\Http\Controllers\Client\SearchController;
use App\Http\Controllers\Client\TicketController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VilleController;
use App\Http\Controllers\Admin\BusController;
use App\Http\Controllers\Admin\TrajetController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\UserController;

// ======================
// ROUTES PUBLIQUES
// ======================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/recherche', [SearchController::class, 'search'])->name('search');
Route::get('/trajet/{id}/sieges', [SearchController::class, 'showSieges'])->name('sieges.show');

// ======================
// AUTHENTIFICATION (Google OAuth)
// ======================
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// ======================
// ROUTES PROTÉGÉES (AUTHENTIFICATION REQUISE)
// ======================
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
    
    // Profil utilisateur
    Route::get('/mon-compte', [ProfileController::class, 'index'])->name('profile');
    Route::put('/mon-compte', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/mon-compte/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/reservation/{reservation}/annuler', [ProfileController::class, 'cancelReservation'])->name('reservation.cancel');
});
    // ======================
    // DASHBOARD REDIRECTION
    // ======================
    Route::middleware(['auth'])->get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home');
    })->name('dashboard');

// ======================
// ROUTES ADMINISTRATION (AUTH + ADMIN)
// ======================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
            
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Gestion des villes (CRUD complet)
    Route::resource('villes', VilleController::class);
    
    // Gestion des bus (CRUD complet)
    Route::resource('buses', BusController::class);
    
    // Gestion des trajets (CRUD complet)
    Route::resource('trajets', TrajetController::class);
    
    // Gestion des utilisateurs (CRUD complet)
    Route::resource('users', UserController::class);
    
    // Gestion des réservations
    Route::get('/reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/{reservation}', [AdminReservationController::class, 'show'])->name('reservations.show');
    Route::put('/reservations/{reservation}/status', [AdminReservationController::class, 'updateStatus'])->name('reservations.status');
    Route::delete('/reservations/{reservation}', [AdminReservationController::class, 'destroy'])->name('reservations.destroy');
});

// ======================
// FICHIER D'AUTHENTIFICATION LARAVEL BREEZE
// ======================
require __DIR__.'/auth.php';