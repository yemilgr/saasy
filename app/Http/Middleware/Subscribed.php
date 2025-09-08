<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Subscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ?string $product = null): Response
    {
        if ($product && !$request->user()?->subscribedToProduct($product)) {
            $this->goToCheckout($request);
        }

        if (!$request->user()?->subscribed()) {
            $this->goToCheckout($request);
        }

        return $next($request);
    }

    private function goToCheckout(Request $request): RedirectResponse
    {
        return redirect()->route('filament.app.pages.checkout');
    }
}
