<?php

namespace App\Livewire\Public\Article;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Core\Article;
use App\Models\Utility\Action;
use App\Models\Utility\PivotTags;

class Detail extends Component
{
    public $data;
    public $prevArticle;
    public $nextArticle;
    public $hasLiked;
    public $likeCount;
    public $shareCount;

    public function render()
    {
        $tags = PivotTags::where('taggable_id', $this->data->id)
                         ->where('taggable_type', 'article')
                         ->with('getTags')
                         ->get();

        $this->hasLiked = $this->checkIfLiked();
        $this->likeCount = Action::where('type', 'like')
                                 ->where('actionable_type', 'article')
                                 ->where('actionable_id', $this->data->id)
                                 ->count();

        $this->shareCount = Action::where('type', 'share')
                                  ->where('actionable_type', 'article')
                                  ->where('actionable_id', $this->data->id)
                                  ->count();

        return view('livewire.public.article.detail', [
            'tags' => $tags,
        ])->layoutData(['title' => $this->data->title]);
    }

    public function mount($slug)
    {
        $this->data = Article::where('slug', $slug)->firstOrFail();

        if ($this->shouldIncrementViewCount()) {
            $this->data->increment('view_count');
        }

        $this->prevArticle = Article::where('id', '<', $this->data->id)->orderBy('id', 'desc')->first();
        $this->nextArticle = Article::where('id', '>', $this->data->id)->orderBy('id', 'asc')->first();
    }

    protected function shouldIncrementViewCount()
    {
        $ip = request()->ip();
        $viewed = session()->get('viewed_articles', []);

        if (!in_array($this->data->id . '-' . $ip, $viewed)) {
            session()->push('viewed_articles', $this->data->id . '-' . $ip);
            return true;
        }

        return false;
    }

    protected function checkIfLiked()
    {
        return Action::where('type', 'like')
                     ->where('actionable_type', 'article')
                     ->where('actionable_id', $this->data->id)
                     ->where('ip_address', request()->ip())
                     ->where('device', request()->header('User-Agent'))
                     ->exists();
    }

    public function like()
    {
        if (!$this->hasLiked) {
            Action::create([
                'type' => 'like',
                'actionable_type' => 'article',
                'actionable_id' => $this->data->id,
                'ip_address' => request()->ip(),
                'device' => request()->header('User-Agent'),
            ]);

            $this->hasLiked = true;
            $this->likeCount++;
        }
    }

    public function unlike()
    {
        $action = Action::where('type', 'like')
                        ->where('actionable_type', 'article')
                        ->where('actionable_id', $this->data->id)
                        ->where('ip_address', request()->ip())
                        ->where('device', request()->header('User-Agent'))
                        ->first();

        if ($action) {
            $action->delete();
            $this->hasLiked = false;
            $this->likeCount--;
        }
    }

    public function share($platform)
    {
        $ip = request()->ip();
        $device = request()->header('User-Agent');

        // Check if the article has already been shared by the same IP and device
        $shared = Action::where('type', 'share')
                        ->where('actionable_type', 'article')
                        ->where('actionable_id', $this->data->id)
                        ->where('ip_address', $ip)
                        ->where('device', $device)
                        ->exists();

        if (!$shared) {
            Action::create([
                'type' => 'share',
                'actionable_type' => 'article',
                'actionable_id' => $this->data->id,
                'ip_address' => $ip,
                'device' => $device,
            ]);

            $this->shareCount++;
        }

        // Prepare share URL
        $title = urlencode($this->data->title);
        $content = urlencode(Str::limit(strip_tags($this->data->content), 100));
        $thumbnail = asset('storage/article/' . $this->data->thumbnail);
        $url = route('public.articles.detail', $this->data->slug);

        switch ($platform) {
            case 'facebook':
                $shareUrl = "https://www.facebook.com/sharer/sharer.php?u=$url&quote=$title - $content";
                break;
            case 'twitter':
                $shareUrl = "https://twitter.com/intent/tweet?url=$url&text=$title - $content";
                break;
            case 'google_plus':
                $shareUrl = "https://plus.google.com/share?url=$url";
                break;
            case 'whatsapp':
                $shareUrl = "https://api.whatsapp.com/send?text=$title - $content $url";
                break;
            case 'instagram':
                // Note: Instagram doesn't support direct URL sharing like others
                $shareUrl = "https://www.instagram.com";
                break;
            default:
                $shareUrl = "";
                break;
        }

        // return new tab with share URL
        return redirect($shareUrl);
    }

    public function prevArticle()
    {
        if ($this->prevArticle) {
            return redirect()->route('public.articles.detail', $this->prevArticle->slug);
        }
    }

    public function nextArticle()
    {
        if ($this->nextArticle) {
            return redirect()->route('public.articles.detail', $this->nextArticle->slug);
        }
    }
}
