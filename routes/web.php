<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\MailController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/mail', [MailController::class, 'index'])->name('mail');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/admin/amphures/{province_id}', [AddressController::class, 'getAmphures']);
Route::get('/admin/tambons/{amphure_id}', [AddressController::class, 'getTambons']);
Route::get('/admin/zipcode/{tambon_id}', [AddressController::class, 'getZipCode']);


Route::get('/admin/login', function () {
    return redirect(route('login')); // เปลี่ยนเส้นทางไปยังหน้า login ของ Laravel
})->name('admin.login');
require __DIR__.'/auth.php';
