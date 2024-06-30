<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class TaskObserver
{
    public function saved(User $user): void
    {
        if ($user->isDirty('avatar_path')) {
            if (!is_null($user->getOriginal('avatar_path'))) {
                if ($user->avatar_path != 'avatars/default.png') {
                    Storage::disk('public')->delete($user->getOriginal('avatar_path'));
                }
            }
        }
    }

    public function deleted(User $user): void
    {
        if (!is_null($user->avatar_path)) {
            if ($user->avatar_path != 'avatars/default.png') {
                Storage::disk('public')->delete($user->avatar_path);
            }
        }
    }
}
