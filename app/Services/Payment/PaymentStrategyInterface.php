<?php

namespace App\Services\Payment;

/**
 * Interface PaymentStrategyInterface
 * @package App\Services\Payment
 */
interface PaymentStrategyInterface
{
    /**
     * Calculate the tax rate.
     *
     * @return float
     */
    public function calculateTaxRate(float $amount): float;

    /**
     * Process the payment.
     *
     * @return bool
     */
    public function processPayment(): bool;
}
