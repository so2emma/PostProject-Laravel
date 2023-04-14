<?php

namespace App\Models;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use App\Traits\Taggable;

class Comment extends Model
{
    use SoftDeletes, HasFactory, Taggable;

    protected $fillable = [
        'content',
        "user_id"
    ];

    // public function blogPost()
    // {
    //     return $this->belongsTo('App\Models\BlogPost');
    // }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function(Comment $comment) {
            // dump($comment);
            // dd(BlogPost::class);
            // if($comment->commentable_type === BlogPost::class) {
            //     Cache::tags(["blog-post"])->forget("blog-post-{$comment->commentable_id}");
            //     Cache::tags(["blog-post"])->forget("mostCommented");
            // }
        });
        // static::addGlobalScope(new LatestScope);
    }
}
