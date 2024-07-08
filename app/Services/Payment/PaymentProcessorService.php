<?php

namespace App\Services\Payment;

use App\Models\Merchant;
use App\Models\Payment;
use App\Services\Payment\PaymentStrategyInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class PaymentProcessorService
 * @package App\Services\Payment
 */
class PaymentProcessorService
{
    /**
     * Create a new PaymentProcessorService instance
     *
     * @param PaymentStrategyInterface $processor
     */
    public function __construct(protected PaymentStrategyInterface $processor)
    {
    }

    /**
     * Process the payment and add the merchant balance
     *
     * @param Payment   $payment
     * @param Merchant  $merchant
     * @return Payment
     */
    public function process(Payment $payment, Merchant $merchant): Payment
    {
        DB::beginTransaction();

        try {
            $payment->status = 'failed';

            $tax = $this->processor->calculateTaxRate(amount: $payment->amount);

            $success = $this->processor->processPayment();

            // Change payment status and add balance to merchant only if payment is successful
            if ($success) {
                $payment->status = 'paid';
                $payment->paid_at = now();

                $merchant->balance += $payment->amount - $tax;
                $merchant->save();
            }

            $payment->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        return $payment;
    }
}
