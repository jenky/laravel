<?php

namespace App\Http\Controllers;

use Brick\Money\Money as 💸;
use Illuminate\Http\Request;
use Jenky\Cartolic\Contracts\Cart\Cart;
use Jenky\Cartolic\Money;
use Jenky\Cartolic\Purchasable;

class TestController extends Controller
{
    public function __invoke(Cart $cart)
    {
        $item = Purchasable::make()
            ->withName('Kit Kat')
            ->withDescription('Test product')
            ->withPrice(new Money(💸::ofMinor(999, 'USD')));


        $cart->add($item);

        return $cart;
    }
}
