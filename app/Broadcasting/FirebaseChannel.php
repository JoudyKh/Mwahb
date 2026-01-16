<?php

namespace App\Broadcasting;

use App\Models\User;
use App\Notifications\BaseNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Google_Client;


class FirebaseChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    public function send(BaseNotification $notification, User|Collection $user)
    {

        Log::info('firbase channel');


        pushFirebaseNotification($user->fcmTokens()->pluck('fcm_token')->toArray(), $notification->getTitle(), $notification->getBody(), $notification->getAttribute('data'));
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user): array|bool
    {
        return true ;
    }
}
