<?php

namespace App\Providers;

use App\Models\Dialog\Dialog;
use App\Models\Dialog\DialogMessage;
use App\Models\Post;
use App\Models\User\PrivacySetting;
use App\Models\User\User;
use App\Policies\DialogMessagePolicy;
use App\Policies\DialogPolicy;
use App\Policies\PostPolicy;
use App\Policies\PrivacySettingPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Post::class => PostPolicy::class,
        Dialog::class => DialogPolicy::class,
        DialogMessage::class => DialogMessagePolicy::class,
        PrivacySetting::class => PrivacySettingPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
