<?php

namespace App\Http\Controllers;

use App\Product;
use Faker\Factory;
use Illuminate\Http\Request;
use Jenky\Cartolic\Contracts\Cart;

class TestController extends Controller
{
    public function __invoke(Cart $cart)
    {
        $item = new Product(Factory::create());

        $cart->add($item);
        $cart->add($item, 5);

        // dd($cart);
        return $cart;
    }
}
