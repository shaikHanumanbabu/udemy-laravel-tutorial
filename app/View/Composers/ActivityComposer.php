<?php

namespace App\View\Composers;

use App\Models\User;
use App\Models\BlogPost;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class ActivityComposer
{
    public function compose(View $view)
    {
        $most_commented = Cache::remember('mostCommented', now()->addSeconds(10), function() {
            return BlogPost::mostCommented()->take(5)->get();
        });
        $mostActive = Cache::remember('mostActive', now()->addSeconds(10), function() {
            return User::withMostBlogPosts()->take(5)->get();
        });
        $lastMonthActive = Cache::remember('lastMonthActive', now()->addSeconds(10), function() {
            return User::withMostBlogPostsLastMonth()->take(5)->get();
        });

        $view->with('most_commented', $most_commented);
        $view->with('mostActive', $mostActive);
        $view->with('lastMonthActive', $lastMonthActive);
    }
}
