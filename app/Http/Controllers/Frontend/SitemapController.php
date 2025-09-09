<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\VideoTransfer;
use App\Models\Transfer;
use App\Models\Audiobook;
use App\Models\RadioNews;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $sitemap = $this->generateSitemap();

        return response($sitemap)
            ->header('Content-Type', 'application/xml');
    }

    private function generateSitemap(): string
    {
        $baseUrl = config('app.url');
        $now = Carbon::now()->toAtomString();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Статические страницы
        $staticPages = [
            'home',
            'onAir',
            'home.news.index',
            'newsIng',
            'tvProgram',
            'transfers',
            'radio',
            'radio.transfers',
            'radio.books',
            'realeses',
            'ads',
            'about',
            'contacts',
            'musicalCard',
            'pravila',
            'soglasie'
        ];

        foreach ($staticPages as $page) {
            $xml .= $this->createUrlElement(
                route($page),
                $now,
                'weekly',
                $page === 'home' ? '1.0' : '0.8'
            );
        }

        // Динамические страницы (новости)
        $news = News::where('status', 1)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->get();

        foreach ($news as $item) {
            $xml .= $this->createUrlElement(
                route('home.news.single', ['slug' => $item->slug]),
                $item->updated_at->toAtomString(),
                'monthly',
                '0.7'
            );
        }

        // Видео
        $videos = VideoTransfer::get();
        foreach ($videos as $video) {
            $xml .= $this->createUrlElement(
                route('home.videos.single', ['slug' => $video->slug]),
                $video->updated_at->toAtomString(),
                'monthly',
                '0.6'
            );
        }

        // Трансферы
        $transfers = Transfer::get();
        foreach ($transfers as $transfer) {
            $xml .= $this->createUrlElement(
                route('transfer', ['transfer' => $transfer->id]),
                $transfer->updated_at->toAtomString(),
                'monthly',
                '0.6'
            );
        }

        // Радио трансферы
        $radioTransfers = Transfer::get();

        foreach ($radioTransfers as $transfer) {
            $xml .= $this->createUrlElement(
                route('radio.transfer.single', ['transfer' => $transfer->id]),
                $transfer->updated_at->toAtomString(),
                'monthly',
                '0.6'
            );
        }

        // Книги
        $books = Audiobook::get();
        foreach ($books as $book) {
            $xml .= $this->createUrlElement(
                route('books.single', ['book' => $book->id]),
                $book->updated_at->toAtomString(),
                'monthly',
                '0.6'
            );
        }

        // События
        $events = RadioNews::query()
            ->where('published_at', '>=', now())
            ->get();

        foreach ($events as $event) {
            $xml .= $this->createUrlElement(
                route('event.single', ['event' => $event->id]),
                $event->updated_at->toAtomString(),
                'weekly',
                '0.7'
            );
        }

        $xml .= '</urlset>';

        return $xml;
    }

    private function createUrlElement(string $url, string $lastmod, string $changefreq, string $priority): string
    {
        return "
        <url>
            <loc>" . htmlspecialchars($url) . "</loc>
            <lastmod>{$lastmod}</lastmod>
            <changefreq>{$changefreq}</changefreq>
            <priority>{$priority}</priority>
        </url>";
    }
}
