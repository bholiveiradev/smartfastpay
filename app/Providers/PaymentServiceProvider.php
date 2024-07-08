<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public $bindings = [
        \App\Services\Payments\PaymentStrategyInterface::class => \App\Services\Payments\Strategies\PixPayment::class,
        \App\Services\Payments\PaymentStrategyInterface::class => \App\Services\Payments\Strategies\BoletoPayment::class,
        \App\Services\Payments\PaymentStrategyInterface::class => \App\Services\Payments\Strategies\BankTransferPayment::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
