<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Services\Payment\{PaymentProcessorService, PaymentStrategyInterface};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\{AnonymousResourceCollection, JsonResource};
use Illuminate\Http\Response;

/**
 * Class PaymentController
 * @package App\Http\Controllers\Api
 */
class PaymentController extends Controller
{
    /**
     * Create a new PaymentController instance
     */
    public function __construct(
        /** @var Payment */
        private Payment $payment
    )
    {
    }

    /**
     * @OA\Get(
     *     path="/payments",
     *     summary="Get all payments",
     *     tags={"payments"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Display a list of payments",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Payment")
     *             )
     *         )
     *     )
     * )
     *
     * Display a list of payments.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $payments = $this->payment->all();
        return PaymentResource::collection($payments);
    }

    /**
     * @OA\Post(
     *     path="/payments",
     *     summary="Create a new payment",
     *     tags={"payments"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name_client", "cpf", "description", "amount", "payment_method"},
     *             @OA\Property(property="name_client", type="string", example="John Doe"),
     *             @OA\Property(property="cpf", type="string", example="12345678909"),
     *             @OA\Property(property="description", type="string", example="Payment for services"),
     *             @OA\Property(property="amount", type="number", format="float", example=100.99),
     *             @OA\Property(
     *                 property="payment_method",
     *                 type="string",
     *                 enum={"pix", "boleto", "bank_transfer"},
     *                 example="pix"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Payment created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Payment")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The selected payment method is invalid.")
     *         )
     *     )
     * )
     *
     * Store a newly created payment.
     *
     * @param PaymentRequest $request
     * @return JsonResource
     */
    public function store(PaymentRequest $request)
    {
        $data = $request->validated();

        $payment = $this->payment->create($data);

        $merchant = auth()->user()->merchant;

        $method = $data['payment_method'];

        /** @var PaymentStrategyInterface */
        $processor = config("payment_providers.providers.$method");

        $payment = (new PaymentProcessorService(new $processor()))->process(payment: $payment, merchant: $merchant);

        return PaymentResource::make($payment);
    }

    /**
     * @OA\Get(
     *     path="/payments/{payment}",
     *     summary="Get the specified payment",
     *     tags={"payments"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="payment",
     *         in="path",
     *         description="ID of payment to return",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Get details of a payment",
     *         @OA\JsonContent(ref="#/components/schemas/Payment")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Payment not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Payment not found.")
     *         )
     *     )
     * )
     *
     * Display the specified payment.
     *
     * @param string $payment
     * @return JsonResource|JsonResponse
     */
    public function show($payment): JsonResource|JsonResponse
    {
        if (! $payment = $this->payment->find($payment)) {
            return response()->json(['message' => 'Payment not found'], Response::HTTP_NOT_FOUND);
        }
        return PaymentResource::make($payment);
    }
}
