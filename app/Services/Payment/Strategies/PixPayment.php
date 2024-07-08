<?php

namespace App\Services\Payment\Strategies;

use App\Services\Payment\PaymentStrategyInterface;

/**
 * Class PixPayment
 * @package App\Services\Payment\Strategies
 */
class PixPayment implements PaymentStrategyInterface
{
    /**
     * Calculate the tax rate.
     *
     * @return float
     */
    public function calculateTaxRate(float $amount): float
    {
        return (float) $amount * (1.5 / 100);
    }

    /**
     * Simulates payment processing with a 70% chance of approval
     *
     * @return bool
     */
    public function processPayment(): bool
    {
        return rand(0, 100) <= 70;
    }
}
