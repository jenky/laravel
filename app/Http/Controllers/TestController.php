<?php

namespace App\Http\Controllers;

use Brick\Math\RoundingMode;
use Brick\Money\Money as 💸;
use Illuminate\Http\Request;
use Jenky\Cartolic\Contracts\Cart\Cart;
use Jenky\Cartolic\Fee;
use Jenky\Cartolic\Money;
use Jenky\Cartolic\Purchasable;

class TestController extends Controller
{
    public function __invoke(Cart $cart)
    {
        // $cart->clear();
        $item = Purchasable::make()
            ->withName('Kit Kat')
            ->withDescription('Test product')
            ->withPrice(new Money(💸::ofMinor(999, 'USD')));

        $shipping = Fee::make('shipping', new Money(💸::ofMinor(199, 'USD')));
        $discount = Fee::make('promo', $cart->subtotal()->dividedBy(2, RoundingMode::DOWN)->negated());

        // $cart->add($item, 4);
        // $cart->remove($item, 2);

        $cart->fees()->add($shipping)->add($discount);

        dd($cart, $cart->fees(), $cart->items());

        return $cart->toArray();
    }
}
