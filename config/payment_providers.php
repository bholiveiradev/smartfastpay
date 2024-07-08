<?php

return [
    'providers' => [
        'pix'           => \App\Services\Payment\Strategies\PixPayment::class,
        'boleto'        => \App\Services\Payment\Strategies\BoletoPayment::class,
        'bank_transfer' => \App\Services\Payment\Strategies\BankTransferPayment::class,
    ],
];
