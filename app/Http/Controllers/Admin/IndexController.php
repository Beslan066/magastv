<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audiobook;
use App\Models\News;
use App\Models\RadioBroadcast;
use App\Models\RadioNews;
use App\Models\RadioTransfer;
use App\Models\Transfer;
use App\Models\User;
use App\Models\VideoReportage;
use App\Models\VideoTransfer;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index() {

        $newsCount = News::count();
        $videoReportageCount = VideoReportage::count();
        $transferCount = Transfer::count();
        $videoTransferCount = VideoTransfer::count();

        $usersCount = User::count();
        $lastUsers = User::query()->orderBy('created_at', 'desc')->with(['role'])->take(5)->get();

        $popularPosts = News::query()->select('slug', 'title', 'views')->orderBy('views', 'desc')->limit(6)->get();
        $popularVideoReportages = VideoReportage::query()->select('slug', 'title', 'views')->orderBy('views', 'desc')->limit(6)->get();


        // Radio

        $radioNewsCount = RadioNews::count();
        $radioTransferCount = RadioTransfer::query()->count();
        $radioBroadcastCount = RadioBroadcast::query()->count();
        $audiobooksCount = Audiobook::count();


        return view('admin.index', [
            'newsCount' => $newsCount,
            'videoReportageCount' => $videoReportageCount,
            'transferCount' => $transferCount,
            'videoTransferCount' => $videoTransferCount,
            'usersCount' => $usersCount,
            'popularPosts' => $popularPosts,
            'popularVideoReportages' => $popularVideoReportages,
            'lastUsers' => $lastUsers,
            'audiobooksCount' => $audiobooksCount,
            'radioNewsCount' => $radioNewsCount,
            'radioTransferCount' => $radioTransferCount,
            'radioBroadcastCount' => $radioBroadcastCount,
        ]);
    }
}
