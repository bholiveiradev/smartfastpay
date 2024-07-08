<?php

namespace App\Services\Payment\Strategies;

use App\Services\Payment\PaymentStrategyInterface;

/**
 * Class BankTransferPayment
 * @package App\Services\Payment\Strategies
 */
class BankTransferPayment implements PaymentStrategyInterface
{
    /**
     * Calculate the tax rate.
     *
     * @return bool
     */
    public function calculateTaxRate(float $amount): float
    {
        return (float) $amount * (4 / 100);
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
