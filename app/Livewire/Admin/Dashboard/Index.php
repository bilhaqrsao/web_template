<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Models\Core\Page;
use App\Models\Core\Video;
use App\Models\Core\Banner;
use App\Models\Core\Berkas;
use App\Models\Core\Article;
use App\Models\Core\Gallery;
use App\Models\Core\Pengumuman;
use App\Models\LogActivity\LogUser;
use App\Models\Utility\Action;
use App\Models\Utility\Visitor;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class Index extends Component
{
    public $limitLogs = 5;
    public $visitorRange = 'last_month';

    public function render()
    {
        // article
        $sumArticle = Article::count();
        $sumArticlePublished = Article::where('status', 'Publish')->count();

        // page
        $sumPage = Page::count();
        $sumPagePublished = Page::where('status', 'Publish')->count();

        // pengumuman
        $sumPengumuman = Pengumuman::count();
        $sumPengumumanPublished = Pengumuman::where('status', 'Publish')->count();

        // berkas
        $sumBerkas = Berkas::count();
        $sumBerkasPublished = Berkas::where('status', 'Publish')->count();
        $sumDownload = Berkas::sum('download');

        // gallery
        $sumGallery = Gallery::count();
        $sumGalleryPublished = Gallery::where('status', 'Publish')->count();

        // video
        $sumVideo = Video::count();
        $sumVideoPublished = Video::where('status', 'Publish')->count();

        // banner
        $sumBanner = Banner::count();

        // aktifitas
        $logs = LogUser::latest()->paginate($this->limitLogs);

        // kegiatan pengunjung
        $sumLike = Action::where('type', 'like')->count();
        // chartlike
        $chartLike = [];
        $rangeLike = CarbonPeriod::create(Carbon::now()->subWeek(), Carbon::now());
        foreach ($rangeLike as $date) {
            $like = Action::where('type', 'like')->whereDate('created_at', $date)->count();
            $chartLike[] = [
                'date' => $date->translatedFormat('D'),
                'like' => $like,
            ];
        }

        $sumDislike = Action::where('type', 'dislike')->count();
        // chartdislike
        $chartDislike = [];
        $rangeDislike = CarbonPeriod::create(Carbon::now()->subWeek(), Carbon::now());
        foreach ($rangeDislike as $date) {
            $dislike = Action::where('type', 'dislike')->whereDate('created_at', $date)->count();
            $chartDislike[] = [
                'date' => $date->translatedFormat('D'),
                'dislike' => $dislike,
            ];
        }


        $sumShare = Action::where('type', 'share')->count();

        // pengunjung
        $chartVisitor = [];
        if ($this->visitorRange == 'last_month') {
            $dateRange = CarbonPeriod::create(Carbon::now()->subMonth(), Carbon::now());
        } elseif ($this->visitorRange == 'last_week') {
            $dateRange = CarbonPeriod::create(Carbon::now()->subWeek(), Carbon::now());
        }

        foreach ($dateRange as $date) {
            $visitor = Visitor::whereDate('created_at', $date)->count();
            $chartVisitor[] = [
                'date' => $date->translatedFormat('D, d M Y'),
                'visitor' => $visitor,
            ];
        }

        return view('livewire.admin.dashboard.index',[
            'sumArticle' => $sumArticle,
            'sumArticlePublished' => $sumArticlePublished,
            'sumPage' => $sumPage,
            'sumPagePublished' => $sumPagePublished,
            'sumPengumuman' => $sumPengumuman,
            'sumPengumumanPublished' => $sumPengumumanPublished,
            'sumBerkas' => $sumBerkas,
            'sumBerkasPublished' => $sumBerkasPublished,
            'sumDownload' => $sumDownload,
            'sumGallery' => $sumGallery,
            'sumGalleryPublished' => $sumGalleryPublished,
            'sumVideo' => $sumVideo,
            'sumVideoPublished' => $sumVideoPublished,
            'sumBanner' => $sumBanner,
            'logs' => $logs,
            'sumLike' => $sumLike,
            'chartLike' => $chartLike,
            'sumDislike' => $sumDislike,
            'chartDislike' => $chartDislike,
            'sumShare' => $sumShare,
            'chartVisitor' => $chartVisitor,
        ])->layout('components.admin_layouts.app')->layoutData([
            'title' => 'Dashboard',
        ]);
    }

    public function loadMoreLogs()
    {
        $this->limitLogs += 20;
    }
}
