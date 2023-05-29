<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Cache\Events\CacheHit;
use Illuminate\Cache\Events\CacheMissed;
use Illuminate\Support\Facades\Log;

class CacheSubscriber
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handleCacheHit(CacheHit $event)
    {
        Log::info("{$event->key} cache hit");
    }

    public function handleCachMissed(CacheMissed $event)
    {
        Log::info("{$event->key} cache miss");
    }

    public function subscribe($events)
    {
        $events->listen(
            CacheHit::class,
            'App\Listener\CacheSubscriber@handleCacheHit'
        );
        $events->listen(
            CacheHit::class,
            'App\Listener\CacheSubscriber@handleCacheMissed'
        );
    }
}
