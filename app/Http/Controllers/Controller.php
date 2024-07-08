<?php

namespace App\Http\Controllers;

/**
 * @OA\Server(url="http://laravel.test/api"),
 * @OA\Server(url="http://localhost/api"),
 * @OA\Info(
 *     version="1.0.0",
 *     title="SmartFastPay API",
 *     description="This is the API documentation for the SmartFastPay application for the PHP developer position."
 * ),
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 * )
 *
 * Abstract Class Controller
 * @package App\Http\Controllers
 */
abstract class Controller
{
    //
}
