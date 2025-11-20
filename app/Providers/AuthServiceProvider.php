<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\WineyardRow;
use App\Models\Harvest;
use App\Models\Treatment;
use App\Models\Purchase;
use App\Policies\WineyardRowPolicy;
use App\Policies\HarvestPolicy;
use App\Policies\TreatmentPolicy;
use App\Policies\PurchasePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Mapovanie modelov na policies
     */
    protected $policies = [
        WineyardRow::class => WineyardRowPolicy::class,
        Harvest::class => HarvestPolicy::class,
        Treatment::class => TreatmentPolicy::class,
        Purchase::class => PurchasePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
