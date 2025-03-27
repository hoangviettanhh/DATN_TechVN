<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'checkout/vnpay-return',
        'checkout/*',
        'order/success/*'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        // Add ngrok header for all routes
        header('ngrok-skip-browser-warning: true');

        if ($request->is('checkout/vnpay-return') || $request->is('order/success/*')) {
            Log::info('Payment Return Session in Middleware:', [
                'session_id' => session()->getId(),
                'user_id' => session('user_id'),
                'all' => session()->all()
            ]);

            // Nếu có user_id trong session, đăng nhập lại
            if (!Auth::check() && session()->has('user_id')) {
                Auth::loginUsingId(session('user_id'), true);
                Log::info('Logged in user in middleware:', ['user_id' => Auth::id()]);
            }
        }

        return parent::handle($request, $next);
    }
} 