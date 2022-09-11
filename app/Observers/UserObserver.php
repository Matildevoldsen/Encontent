<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Arr;

class UserObserver
{
    /**
     * @param User $user
     */
    public function created(User $user)
    {
        $user->storeCurrentPasswordInHistory($user->password);
    }

    /**
     * @param User $user
     */
    public function updated(User $user)
    {
        if ($password = Arr::get($user->getChanges(), 'password')) {
            $user->storeCurrentPasswordInHistory($password);
        }
    }

    /**
     * @param User $user
     */
    public function deleted(User $user)
    {

    }

    /**
     * @param User $user
     */
    public function restored(User $user)
    {

    }

    /**
     * @param User $user
     */
    public function forceDeleted(User $user)
    {

    }
}
