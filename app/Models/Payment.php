<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @OA\Schema(
 *     schema="Payment",
 *     type="object",
 *     title="Payment",
 *     @OA\Property(property="id", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000"),
 *     @OA\Property(property="name_client", type="string", example="John Doe"),
 *     @OA\Property(property="cpf", type="string", example="12345678909"),
 *     @OA\Property(property="description", type="string", example="Payment for services"),
 *     @OA\Property(property="amount", type="number", format="float", example=100.99),
 *     @OA\Property(property="status", type="string", example="pending"),
 *     @OA\Property(
 *         property="payment_method",
 *         type="string",
 *         enum={"pix", "boleto", "bank_transfer"},
 *         example="pix"
 *     ),
 *     @OA\Property(property="paid_at", type="string", format="date-time", example="2023-06-21T15:03:01Z"),
 * )
 *
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
