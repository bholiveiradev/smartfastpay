<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class Payment
 * @package App\Models
 */
class Payment extends Model
{
    use HasFactory;

    /** @var string */
    protected $keyType = 'string';

    /** @var bool */
    public $incrementing = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_client',
        'cpf',
        'description',
        'amount',
        'status',
        'payment_method',
        'paid_at',
    ];

    /**
     * Boot function for using uuid
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function ($payment) {
            $payment->id = Str::uuid();
        });
    }
}
