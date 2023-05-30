<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class Counter
{
    public function increment(string $key, array $tags = null): int
    {
        $sessionId = session()->getId();
        $counterKey = "{$key}-counter";
        $usersKey = "{$key}-users";

        $users = Cache::get($usersKey, []);
        $usersUpdate = [];
        $difference = 0;
        $now = now();

        foreach ($users as $session => $lastVisit){
            if(now()->diffInMinutes($lastVisit) >= 1){
                $difference--;
            } else {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if(
            !array_key_exists($sessionId, $users)
            || $now->diffInMinutes($users[$sessionId]) >= 1
            ) {
            $difference++;
        }

        $usersUpdate[$sessionId] = $now;
        Cache::forever('$userKey', $usersUpdate);

        if(!Cache::has($counterKey)) {
            Cache::forever('$counterKey', 1);
        } else {
            Cache::increment($counterKey, $difference);
        }

        $counter = Cache::get('$counterKey');
        return $counter;
    }
}
