<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AgeRestrictionController;
use App\Http\Controllers\Admin\AudiobookController;
use App\Http\Controllers\Admin\AudiobookFileController;
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
use App\Http\Controllers\Admin\RadioTransferController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SupervisorController;
use App\Http\Controllers\Admin\TidingController;
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
use App\Http\Controllers\Frontend\SitemapController;
use App\Models\AudiobookFile;
use App\Models\News;
use App\Models\VideoReportage;
use App\Models\VideoTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::get('/proxy/audio', function() {
    $streamUrl = 'http://media.zaoitt.ru:8086/ingradio';

    \Log::info('Radio proxy started for: ' . request()->ip());
ы
    // ВАЖНО: Убираем все middleware для этого роута
    // Добавьте в конце роута:
})->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// А сам код функции должен быть таким:

//

Route::get('/proxy/audio', function() {
    $streamUrl = 'http://media.zaoitt.ru:8086/ingradio';

    \Log::info('Radio proxy started for: ' . request()->ip());

    // Отключаем все буферизации
    if (ob_get_level()) {
        ob_end_clean();
    }

    // Отключаем кэширование
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');

    // Разрешаем CORS
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, OPTIONS');

    // Устанавливаем Content-Type как у оригинального потока
    header('Content-Type: audio/mpeg');

    // Для Icecast добавляем icy-метаданные
    header('icy-br: 128');
    header('icy-genre: Other');
    header('icy-name: Magas FM');
    header('icy-pub: 1');

    // Отключаем лимит времени выполнения
    set_time_limit(0);

    // Закрываем сессию, чтобы не блокировать
    if (session_id()) {
        session_write_close();
    }

    // Настройки для подключения к Icecast
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => implode("\r\n", [
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'Accept: audio/mpeg, audio/*',
                'Connection: close',
                'Icy-MetaData: 1'
            ]),
            'timeout' => 10,
            'ignore_errors' => true
        ],
        'socket' => [
            'bindto' => '0:0'
        ]
    ]);

    try {
        // Открываем поток напрямую к Icecast
        $fp = @fopen($streamUrl, 'rb', false, $context);

        if (!$fp) {
            \Log::error('Failed to open radio stream');
            header('HTTP/1.1 502 Bad Gateway');
            echo 'Cannot connect to radio server';
            exit;
        }

        // Читаем и отправляем данные
        while (!feof($fp) && connection_status() == 0) {
            $chunk = fread($fp, 8192);
            if ($chunk !== false) {
                echo $chunk;
                flush();
            }

            // Небольшая пауза
            usleep(5000);
        }

        fclose($fp);
        exit;

    } catch (\Exception $e) {
        \Log::error('Proxy error: ' . $e->getMessage());
        header('HTTP/1.1 500 Internal Server Error');
        echo 'Proxy error';
        exit;
    }
})->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

Route::options('/proxy/audio', function() {
    return response('', 204)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, OPTIONS')
        ->header('Access-Control-Allow-Headers', '*')
        ->header('Access-Control-Max-Age', '86400');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/on-air', [HomeController::class, 'onAir'])->name('onAir');
Route::get('/news', [NewsController::class, 'news'])->name('home.news.index');
Route::get('/news-inh', [NewsController::class, 'newsIng'])->name('newsIng');
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
Route::get('/radio/transfers/{transfer}', [HomeController::class, 'radioTransferSingle'])->name('radio.transfer.single');
Route::get('/radio/books', [HomeController::class, 'radioBooks'])->name('radio.books');
Route::get('/radio/books/single/{book}', [HomeController::class, 'booksSingle'])->name('books.single');
Route::get('/event/{event}', [HomeController::class, 'eventSingle'])->name('event.single');
Route::get('/watch', [HomeController::class, 'watching'])->name('watching');
Route::get('/realeses', [HomeController::class, 'realese'])->name('realeses');
Route::get('/ads', [HomeController::class, 'ads'])->name('ads');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contacts');
Route::get('/musical-card', [HomeController::class, 'musicalCard'])->name('musicalCard');
Route::get('/search', [SearchController::class, 'search']);
Route::get('/search/all', [SearchController::class, 'allResults'])->name('search.all');
Route::get('/filter-news', [HomeController::class, 'filterNews'])->name('home.news.filter');
Route::get('/radio/filter', [HomeController::class, 'filterRadio'])->name('home.radio.filter');
Route::post('/radio/filter-programs', [HomeController::class, 'filterPrograms'])
    ->name('radio.filter.programs')
    ->withoutMiddleware(['csrf']);
Route::get('/sort-news', [HomeController::class, 'sortNews']);
Route::get('/pravila-ispolzovaniya-materialov', [HomeController::class, 'pravila'])->name('pravila');
Route::get('/soglasie-na-obrabotku-personalnykh-dannykh', [HomeController::class, 'soglasie'])->name('soglasie');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacyPolicy');


Route::get('dzen.xml', [HomeController::class, 'generateYandexNews'])->name('yandex_news');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');







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
        Route::resource('/ages', AgeRestrictionController::class);
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

        Route::resource('/tidings', TidingController::class);


        Route::resource('/radio-transfers', RadioTransferController::class)
            ->names([
                'index' => 'radio-transfers',
                'create' => 'radio-transfers.create',
                'store' => 'radio-transfers.store',
                'edit' => 'radio-transfers.edit',
                'update' => 'radio-transfers.update',
                'destroy' => 'radio-transfers.destroy',
            ])
            ->parameters([
                'radio-transfers' => 'transfer'
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
        Route::resource('audiobook-files', AudiobookFileController::class)
            ->names([
                'index' => 'bookFiles',
                'create' => 'bookFiles.create',
                'store' => 'bookFiles.store',
                'edit' => 'bookFiles.edit',
                'update' => 'bookFiles.update',
                'destroy' => 'bookFiles.destroy',
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
