<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Order;

class CheckoutController extends Controller
{
    public function checkout($subdomain, CartService $cartService)
    {
        if (!$cartService->all()) abort(500);

        return view('front.checkout');
    }

    public function proccess($subdomain, CartService $cartService, Request $request, Order $order)
    {
        if (!$cartService->all()) abort(500);

        $order->create([
            'user_id' => auth()->id(),
            'items' => $cartService->all(),
            'shipping_value' => session('shipping_value'),
            'store_id' => Store::whereSubdomain($subdomain)->first()->id,
            'code' => Str::uuid(),
        ]);

        $cartService->clear();

        return redirect()->route('checkout.thanks', $subdomain);
    }

    public function thanks($subdomain)
    {
        return view('front.thanks');
    }
}
