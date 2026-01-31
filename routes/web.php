<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClubSectionController;
use App\Http\Controllers\ClubItemController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PlacementTestController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\KidsController;
use App\Http\Controllers\KidsTestController;





/*
|--------------------------------------------------------------------------
| Public Home
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'home'])->name('home');


/*
|--------------------------------------------------------------------------
| Kids Registration
|--------------------------------------------------------------------------
*/

Route::get('/kids/register', [KidsController::class, 'index'])
    ->name('kids.register');

Route::post('/kids/register', [KidsController::class, 'store'])
    ->name('kids.store');

/*
|--------------------------------------------------------------------------
| Kids Zone 1 Test
|--------------------------------------------------------------------------
*/

// Start / resume Zone 1 (creates attempt if needed)
Route::get('/test/kids/zone1/{kid}', [KidsTestController::class, 'startZone1'])
    ->name('kids.zone1.start');

// Show questions
Route::get('/test/kids/zone1/attempt/{attempt}', [KidsTestController::class, 'zone1'])
    ->name('kids.zone1');

// Submit answers
Route::post('/test/kids/zone1/attempt/{attempt}/submit', [KidsTestController::class, 'submitZone1'])
    ->name('kids.zone1.submit');

// Result page
Route::get('/test/kids/zone1/attempt/{attempt}/result', [KidsTestController::class, 'resultZone1'])
    ->name('kids.zone1.result');






/*
|--------------------------------------------------------------------------
| Student Registration & Test Flow (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::prefix('test')->group(function () {

    // Entry points
   Route::get('/test/adult', [StudentController::class, 'create'])
    ->name('test.adult');

    // Registration
    Route::get('/register', [StudentController::class, 'create'])
        ->name('test.register');

    Route::post('/register', [StudentController::class, 'store'])
        ->name('test.store');
});



Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/students', [AdminController::class, 'students'])
        ->name('students');

    Route::get('/students/pdf', [AdminController::class, 'studentsPdf'])
        ->name('students.pdf');

    Route::get('/students/export', [AdminController::class, 'exportCsv'])
        ->name('students.export');

});





/*
|--------------------------------------------------------------------------
| Placement Test Flow (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/test/start/{student}', [PlacementTestController::class, 'start'])
    ->name('test.start');

Route::get('/test/{attempt}/question/{index}', [PlacementTestController::class, 'question'])
    ->name('test.question');

Route::post('/test/{attempt}/answer', [PlacementTestController::class, 'answer'])
    ->name('test.answer');

Route::get('/test/{attempt}/result', [PlacementTestController::class, 'result'])
    ->name('test.result');

    Route::get('/test/{attempt}/finish', [PlacementTestController::class, 'finish'])
    ->name('test.finish');

/*
|--------------------------------------------------------------------------
| Admin Authentication (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AdminAuthController::class, 'showLogin'])
    ->name('admin.login');

Route::post('/login', [AdminAuthController::class, 'login']);

Route::post('/logout', [AdminAuthController::class, 'logout'])
    ->middleware('admin')
    ->name('admin.logout');

Route::get('/admin/kids', [AdminController::class, 'kids'])->name('admin.kids');

// Kids Management Routes
Route::get('/admin/kids', [AdminController::class, 'kids'])->name('admin.kids');
Route::get('/admin/kids/pdf', [AdminController::class, 'kidsPdf'])->name('admin.kids.pdf');
Route::get('/admin/kids/export', [AdminController::class, 'kidsExport'])->name('admin.kids.export');


/*
|--------------------------------------------------------------------------
| Admin Dashboard & Management (PROTECTED)
|--------------------------------------------------------------------------
*/
Route::middleware('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    // Students
    Route::get('/students', [AdminController::class, 'index'])
        ->name('admin.students');

    Route::get('/students/pdf', [AdminController::class, 'studentsPdf'])
        ->name('admin.students.pdf');

    // Teachers
    Route::get('/add-teachers', [TeacherController::class, 'index'])
        ->name('admin.add-teachers');

    Route::post('/add-teachers', [TeacherController::class, 'store'])
        ->name('admin.add-teachers.store');

    Route::delete('/add-teachers/{teacher}', [TeacherController::class, 'destroy'])
        ->name('admin.add-teachers.destroy');



    // Gallery
    Route::get('/gallery', [GalleryController::class, 'index'])
        ->name('admin.gallery');

    Route::post('/gallery', [GalleryController::class, 'store'])
        ->name('admin.gallery.store');

    Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])
        ->name('admin.gallery.destroy');



    // Club Management
    Route::get('/club', function () {
        $section = \App\Models\ClubSection::firstOrCreate([]);
        $clubs   = \App\Models\ClubItem::orderBy('order')->get();
        return view('admin.club', compact('section', 'clubs'));
    })->name('admin.club');


    Route::post('/club/section', [ClubSectionController::class, 'update'])
        ->name('admin.club.section');

    Route::post('/club/items', [ClubItemController::class, 'store'])
        ->name('admin.club.items');

    Route::delete('/club/items/{clubItem}', [ClubItemController::class, 'destroy'])
        ->name('admin.club.items.destroy');

});
