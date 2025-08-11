<?php

namespace App\Providers;
use App\Models\Album;
use App\Models\Comment;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('is-admin', fn(User $user) => $user->role === 'admin');
        Gate::define('manage-album', fn(User $user, Album $album) => $user->id === $album->user_id);
        Gate::define('view-album', function (User $user, Album $album) {
            if ($user->id === $album->user_id || $user->role === 'admin') return true;
            return $album->sharedWithUsers()->where('user_id', $user->id)->exists();
        });
        Gate::define('manage-photo', fn(User $user, Photo $photo) => $user->id === $photo->user_id || $user->role === 'admin');
        Gate::define('view-photo', function(User $user, Photo $photo) {
            return Gate::allows('view-album', $photo->album);
        });
        Gate::define('manage-comment', fn(User $user, Comment $comment) => $user->id === $comment->user_id || $user->id === $comment->photo->user_id || $user->role === 'admin');
    }
}
