<?php

namespace App\Models;

use App\Scopes\LatestScope;
use App\Scopes\DeletedAdminScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Taggable;
    protected $fillable = ['title', 'content', 'user_id'];
    // public function comments()
    // {
    //     return $this->hasMany(Comment::class)->latest();
    // }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function tags()
    // {
    //     return $this->belongsToMany(Tag::class)->withTimestamps();
    // }

    public function image()
    {
        return $this->morphOne(Image::class,  'imageble');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class , 'commentable')->latest();
    }

    



    public function scopeLatest(Builder $builder)
    {
        return $builder->orderBy(static::CREATED_AT, 'desc');
    }

    public function scopeMostCommented(Builder $builder)
    {
        return $builder->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public static function boot()
    {
        static::addGlobalScope(new DeletedAdminScope);
        parent::boot();
        static::deleting(function(BlogPost $post) {
            $post->comments()->delete();
            $post->image()->delete();
        });

        static::updating(function(BlogPost $post) {
            Cache::forget("blog-post-{$post->id}");
        });

        static::restoring(function(BlogPost $post) {
            $post->comments()->restore();
        });
    }
}
