<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\CloseController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PorderController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ViewGameController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Asosiy sahifa
Route::get('/', function () {
    return view('welcome');
});

// Umumiy dashboard sahifasi (foydalanuvchilar va adminlar uchun)
Route::get('/dashboard', function () {
    if (auth()->user()->can('isAdmin')) {
        return redirect()->route('admin.dashboard');
    } elseif (auth()->user()->can('isUser')) {
        return redirect()->route('user.dashboard');
    }
    return redirect('/');
})->middleware('auth')->name('dashboard');

// Dashboard sahifasi (faqat adminlar uchun)
Route::get('/admin/dashboard', [AdminController::class, 'index'])->middleware('can:isAdmin')->name('admin.dashboard');

// Dashboard sahifasi (faqat foydalanuvchilar uchun)
Route::get('/user/dashboard', [GameController::class, 'index'])->middleware('can:isUser')->name('user.dashboard');

// Profile sahifasi
Route::middleware('auth')->group(function () {
    // Profil tahrirlash
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Profil o'chirish
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Game, Close, Order, Porder, Section, Product, ViewGame, Report, Admin resurslari
Route::resource('games', GameController::class);
Route::resource('closes', CloseController::class);
Route::resource('orders', OrderController::class);
Route::resource('porders', PorderController::class);
Route::resource('sections', SectionController::class);
Route::resource('products', ProductController::class);
Route::resource('viewgames', ViewGameController::class);
Route::resource('reports', ReportController::class);
Route::resource('admins', AdminController::class);
Route::resource('payments', PaymentController::class);
Route::resource('users', UserController::class);

Route::post('/porders/cancel', [PorderController::class, 'cancel'])->name('porder.cancel');

Route::post('/products/{id}/inactive', [ProductController::class, 'inactive'])->name('products.inactive');

Route::get('/export/{id}', [AdminController::class, 'export'])->name('export.excel');

Route::post('/user/{id}/change-password', [UserController::class, 'changePassword'])->name('user.changePassword');

Route::post('/user/{id}/block', [UserController::class, 'blockUser'])->name('user.block');

Route::post('/user/{id}/unblock', [UserController::class, 'unblockUser'])->name('user.unblock');

Route::get('close/{id}/showreport', [CloseController::class, 'showReport'])->name('show.report');

Route::get('close/{id}/showtotal', [CloseController::class, 'showTotal'])->name('show.total');

Route::post('user/{id}/profile', [UserController::class, 'profile'])->name('user.profile');

Route::post('/payments/cancel', [PaymentController::class, 'cancel'])->name('payments.cancel');



require __DIR__.'/auth.php';
