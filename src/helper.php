<?php

use DanujaFernando\Cart\Cart;
use Illuminate\Support\Facades\Session;

if(!function_exists('get_subtotal'))
{
    function get_subtotal($user_id = 0)
    {
        $sub_total = 0;
        $carts = get_cart_items($user_id);
        foreach($carts as $cart){
            $attributes = cart_attributes_pirce($cart->attributes);
            $price = ($cart->quantity + $attributes) * $cart->unit_price;
            $sub_total += $price;
        }

        return $sub_total;
    }
}

if(!function_exists('get_cart_items'))
{
    function get_cart_items($user_id = 0)
    {
        if($user_id)
        {
            $carts = Cart::where('user_id', $user_id)->get();
        }
        else
        {
            $session_id = Session::get('_token');
            $carts = Cart::where('session_id', $session_id)->get();
        }
        $carts = $carts->get()
                        ->map(function($item){
                            if($item->attributes){
                                $item->attributes = json_decode($item->attributes, true);
                            }
                            return $item;
                        });
        return $carts;
    }
}

if(!function_exists('cart_attributes')){

    function cart_attributes_pirce($attributes){
        $attribute_price = 0;
        if($attributes){
            foreach($attributes as $attribute)
            {
                if(array_key_exists('price', $attribute))
                {
                    $attribute_price += doubleval($attributes['price']);
                }
            }
        }

        return $attribute_price;
    }
}