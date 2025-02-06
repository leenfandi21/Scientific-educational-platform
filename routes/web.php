<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\MarkA1Controller;
use App\Http\Controllers\PusherController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadFile;
use App\Http\Controllers\NewTableController;
use App\Http\Controllers\QuestionGrammerController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdminActionController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\GrammerController;
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
Route::view('/dashboard/{any}', 'app')->where('any', '.*');
Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {

   // Route::get('files',[UploadFile::class,'index']);
    // Route::GET('files', ['uses' => 'UploadFile@index']);AdminAuthController@postLogin
    //Route::post('files', [UploadFile::class,'index']);
  //  Route::post('/login', [AdminAuthController::class, 'postLogin']);
    Route::get('/files', [UploadFile::class, 'index']);
    Route::get('/chats', [PusherController::class, 'index']);
    Route::get('/course', [CourseController::class, 'index']);
   // Route::get('/course', [NewTableController::class, 'index']);

});

Route::get('/new-table', [NewTableController::class, 'create']);
Route::post('/new-table', [NewTableController::class, 'store']);

Route::post('/upload', [UploadFile::class, 'upload'])->name('upload');

Route::post('/uploadCourse', [CourseController::class, 'uploadFiles'])->name('uploadCourse');
Route::get('/mark_a1/create', [MarkA1Controller::class, 'create'])->name('mark_a1.create');
Route::post('/mark_a1', [MarkA1Controller::class, 'store'])->name('mark_a1.store');
Route::get('/form', [QuestionGrammerController::class, 'showForm'])->name('show_form');
Route::post('/form', [QuestionGrammerController::class, 'submitForm'])->name('submit_form');
Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
Route::get('/orders',[OrderController::class,'index'] )->name('orders.index');
Route::get('/news_post', [AdminActionController::class, 'index1'])->name('news_post.index');
Route::post('/news_post', [AdminActionController::class, 'store'])->name('news_post.store');
Route::get('/news_post/{news_post}/edit', [AdminActionController::class, 'edit'])->name('news_post.edit');
Route::put('/news_post/{news_post}', [AdminActionController::class, 'update'])->name('news_post.update');
Route::delete('/news_post/{news_post}', [AdminActionController::class, 'destroy'])->name('news_post.destroy');
Route::get('/get-files', [CourseController::class, 'getFiles'])->name('getFiles');
Route::post('/delete-file', [CourseController::class, 'deleteFile'])->name('deleteFile');
Route::get('/grammers', [GrammerController::class, 'indexView'])->name('grammers.index');
Route::post('/grammers', [GrammerController::class, 'storeView'])->name('grammers.store');
Route::get('/grammers/{grammer}/edit', [GrammerController::class, 'edit'])->name('grammers.edit');
Route::put('/grammers/{grammer}', [GrammerController::class, 'update'])->name('grammers.update');
Route::delete('/grammers/{grammer}', [GrammerController::class, 'destroy'])->name('grammers.destroy');
