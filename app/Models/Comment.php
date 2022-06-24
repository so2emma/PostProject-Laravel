<?php

namespace App\Models;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'content',
    ];
    public function blogPost()
    {
        return $this->belongsTo('App\Models\BlogPost');
    }
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new LatestScope);
    }
}
