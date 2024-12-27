<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChapaController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('layout');
})->name('home');

Route::resource('students', StudentController::class)->only(['create', 'store']);
Route::post('students/next', [StudentController::class, 'nextStep'])->name('students.next');

Route::resource('courses', CourseController::class)->only(['create', 'store']);
Route::post('courses/stepTwo', [CourseController::class, 'stepTwo'])->name('courses.stepTwo');


Route::get('payments/payment', [PaymentController::class, 'showPaymentPage'])->name('payments.payment');
/*
Route::post('payments/process', [PaymentController::class, 'processPayment'])->name('payments.process');

Route::get('payments/callback', [PaymentController::class, 'handleCallback'])->name('payments.callback');
Route::get('payments/success', [PaymentController::class, 'showSuccessPage'])->name('payments.success');
Route::get('payments/failure', [PaymentController::class, 'showFailurePage'])->name('payments.failure');
*/

// Chapa Payment Routes
Route::post('pay', [ChapaController::class, 'initialize'])->name('pay'); // Payment initialization
Route::get('callback/{reference}', [ChapaController::class, 'callback'])->name('callback'); // Callback from Chapa

// Success and Failure Routes
Route::get('payments/success', [PaymentController::class, 'showSuccessPage'])->name('payments.success');
Route::get('payments/failure', [PaymentController::class, 'showFailurePage'])->name('payments.failure');
