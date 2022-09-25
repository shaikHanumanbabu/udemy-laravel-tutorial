<?php

namespace App\Models;

use App\Scopes\LatestScope;
use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Taggable;

    protected $hidden = ['deleted_at', 'commentable_type', 'commentable_id', 'user_id'];
    protected $fillable = ['user_id', 'content'];

    // public function blogPost()
    // {
    //     // return $this->hasMany(BlogPost::class, 'post_id', 'blog_post_id');
    //     return $this->belongsTo(BlogPost::class);
    // }

    public function commentable()
    {
        # code...
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    

    public function scopeLatest(Builder $builder)
    {
        return $builder->orderBy(static::CREATED_AT, 'desc');
    }
    
    public static function boot()
    {
        parent::boot();

        // static::addGlobalScope(new LatestScope);
        


    }
}
