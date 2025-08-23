<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AudiobookController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\RadioBroadcastController;
use App\Http\Controllers\Admin\RadioNewsController;
use App\Http\Controllers\Admin\RadioProgramController;
use App\Http\Controllers\Admin\RadioShowTypeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SupervisorController;
use App\Http\Controllers\Admin\TransferController;
use App\Http\Controllers\Admin\TvProgramController;
use App\Http\Controllers\Admin\TvShowTypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VideoReportageController;
use App\Http\Controllers\Admin\VideoTransferController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\ProfileController;
use App\Models\News;
use App\Models\VideoReportage;
use App\Models\VideoTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/proxy/live-stream', function() {
    $streamUrl = 'https://public.mediacdn.ru/magas/';
    return response()->streamDownload(function() use ($streamUrl) {
        readfile($streamUrl);
    }, 'stream.m3u8', [
        'Content-Type' => 'application/x-mpegURL',
        'Access-Control-Allow-Origin' => '*'
    ]);
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/on-air', [HomeController::class, 'onAir'])->name('onAir');
Route::get('/news', [NewsController::class, 'news'])->name('home.news.index');
Route::get('/news/{slug}', [NewsController::class, 'newsSingle'])->name('home.news.single');
Route::get('/videos/{slug}', [HomeController::class, 'videoSingle'])->name('home.videos.single');
Route::get('/tv-program', [HomeController::class, 'tvProgram'])->name('tvProgram');
Route::get('/transfers', [HomeController::class, 'transfers'])->name('transfers');
Route::get('/transfer/{transfer}', [HomeController::class, 'transfer'])->name('transfer');
Route::post('/videos/{video}/view', function(VideoTransfer $video) {
    // Проверяем наличие куки, чтобы избежать накрутки
    $cookieName = 'video_view_' . $video->id;

    if (!request()->cookie($cookieName)) {
        $video->incrementViews();

        return response()
            ->json(['views' => $video->views])
            ->cookie($cookieName, true, 1440); // Кука на 24 часа
    }

    return response()->json(['views' => $video->views]);
});

Route::get('/radio', [HomeController::class, 'radio'])->name('radio');
Route::get('/radio/transfers', [HomeController::class, 'radioTransfers'])->name('radio.transfers');
Route::get('/radio/books', [HomeController::class, 'radioBooks'])->name('radio.books');
Route::get('/event/{event}', [HomeController::class, 'eventSingle'])->name('event.single');
Route::get('/watch', [HomeController::class, 'watch'])->name('watch');
Route::get('/realeses', [HomeController::class, 'realese'])->name('realeses');
Route::get('/ads', [HomeController::class, 'ads'])->name('ads');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contacts');

Route::get('/search', [SearchController::class, 'search']);
Route::get('/search/all', [SearchController::class, 'allResults'])->name('search.all');
Route::get('/filter-news', [HomeController::class, 'filterNews'])->name('home.news.filter');
Route::get('/radio/filter', [HomeController::class, 'filterRadio'])->name('home.radio.filter');
Route::post('/radio/filter-programs', [HomeController::class, 'filterPrograms'])
    ->name('radio.filter.programs')
    ->withoutMiddleware(['csrf']);
Route::get('/sort-news', [HomeController::class, 'sortNews']);





Route::group(['namespace' => 'App\Http\Controllers\Admin', 'middleware' => 'auth'], function () {
    Route::get('/admin', [IndexController::class, 'index'])->name('admin.index');

    Route::group(['prefix' => 'admin'], function () {
        Route::resource('/categories', CategoryController::class);
        Route::resource('/authors', AuthorController::class);
        Route::resource('/news', AdminNewsController::class);
        Route::resource('/radio-news', RadioNewsController::class);
        Route::resource('/files', FileController::class);
        Route::resource('/video-reportages', VideoReportageController::class);
        Route::resource('/tv-show-type', TvShowTypeController::class);
        Route::resource('/transfers', TransferController::class);
        Route::post('/transfers/upload-video', [TransferController::class, 'uploadVideo'])->name('transfers.uploadVideo');
        Route::resource('/video-transfers', VideoTransferController::class);
        Route::resource('/radio-show-type', RadioShowTypeController::class);
        Route::resource('/users', UserController::class);
        Route::resource('/supervisors', SupervisorController::class);
        Route::resource('/contacts', ContactController::class);

        Route::resource('/about', AboutController::class);

        Route::resource('/roles', RoleController::class);
        Route::resource('/radio-broadcast', RadioBroadcastController::class);

        Route::resource('tv-programs', TvProgramController::class)
            ->names([
                'index' => 'tv-programs.index',
                'create' => 'tv-programs.create',
                'store' => 'tv-programs.store',
                'edit' => 'tv-programs.edit',
                'update' => 'tv-programs.update',
                'destroy' => 'tv-programs.destroy',
            ]);
        Route::resource('radio-programs', RadioProgramController::class)
            ->names([
                'index' => 'radio-programs.index',
                'create' => 'radio-programs.create',
                'store' => 'radio-programs.store',
                'edit' => 'radio-programs.edit',
                'update' => 'radio-programs.update',
                'destroy' => 'radio-programs.destroy',
            ]);
        Route::resource('audiobooks', AudiobookController::class)
            ->names([
                'index' => 'admin.radio.books',
                'create' => 'admin.radio.books.create',
                'store' => 'admin.radio.books.store',
                'edit' => 'admin.radio.books.edit',
                'update' => 'admin.radio.books.update',
                'destroy' => 'admin.radio.books.destroy',
            ]);
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
