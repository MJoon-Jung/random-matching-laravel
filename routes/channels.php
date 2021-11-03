<?php

use Illuminate\Support\Facades\Broadcast;
use App\Domains\User\Models\User;
use App\Domains\Channel\Models\Member;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('users.{id}', function (User $user, int $id) {
    return $user->id === $id;
});

Broadcast::channel('channel.{channelId}', function (User $user, int $channelId) {
    $isMember = Member::where('channel_id', $channelId)
        ->where('member_id', $user->id)
        ->exists();
    if(!$isMember) {
        throw new HttpException('접근 권한이 없습니다.', 403);
    }
    return ['id' => $user->id, 'name' => $user->name];
});
