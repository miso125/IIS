<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Vinoradek;
use App\Models\Sklizen;
use App\Models\Osetreni;
use App\Models\Nakup;
use App\Policies\VinoradekPolicy;
use App\Policies\SklizenPolicy;
use App\Policies\OsetreniPolicy;
use App\Policies\NakupPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Mapovanie modelov na policies
     */
    protected $policies = [
        Vinoradek::class => VinoradekPolicy::class,
        Sklizen::class => SklizenPolicy::class,
        Osetreni::class => OsetreniPolicy::class,
        Nakup::class => NakupPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
