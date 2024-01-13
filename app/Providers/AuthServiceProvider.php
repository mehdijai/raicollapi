<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Playlist;
use App\Models\Privilege;
use App\Models\Role;
use App\Models\Track;
use App\Models\User;
use App\Models\Validation;
use App\Policies\MediaPolicy;
use App\Policies\UsersPolicy;
use App\Policies\ValidationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UsersPolicy::class,
        Role::class => UsersPolicy::class,
        Privilege::class => UsersPolicy::class,
        Validation::class => ValidationPolicy::class,
        Track::class => MediaPolicy::class,
        Album::class => MediaPolicy::class,
        Artist::class => MediaPolicy::class,
        Playlist::class => MediaPolicy::class,
        Playlist::class => MediaPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
