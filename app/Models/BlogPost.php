<?php

namespace App\Models;

use App\Scopes\DeletedAdminScope;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogPost extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'content', 'user_id'];
    use HasFactory;

    public function comments()
    {
        return $this->morphMany('App\Models\Comment',"commentable")->latest();
    }
    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }
    public function tags()
    {
        return $this->belongsToMany("App\Models\Tag")->withTimestamps();
    }

    public function image()
    {
        return $this->morphOne(Image::class, "imageable");
    }

    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }
    public function ScopeMostCommented(Builder $query)
    {
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public function scopeLatestWithRelations(Builder $query)
    {
        return $query->latest()
            ->withCount('comments')
            ->with('user')
            ->with('tags');
    }

    public static function boot()
    {
        static::addGlobalScope(new DeletedAdminScope);
        parent::boot();


        static::deleting(function (BlogPost $blogPost) {
            $blogPost->comments()->delete();
        });

        static::updating(function (BlogPost $blogPost) {
            Cache::forget('blog-post-{$blogPost->id}');
        });

        static::restoring(function (BlogPost $blogPost) {
            $blogPost->comments()->restore();
        });
    }
}
