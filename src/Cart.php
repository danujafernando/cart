<?php

namespace DanujaFernando\Cart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Cart extends Model{

    public static $runsMigrations = true;

    /**
     * Add items to cart
     * 
     */

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Items add to cart
     * 
     * @param int $product_id
     * @param int $user_id
     * @param int $quantity
     * @param double $unit_price
     * @param array $attributes
     * 
     * @return bool
     */
    public static function add($product_id, $user_id = 0, $quantity = 1, $unit_price = 0.01, $attributes = [])
    {
        if(count($attributes) != 0)
        {
            if(!Cart::validateAttributes($attributes))
            {
                return false;
            }
        }
        
        $session_id = Session::get('_token');

        $cart = new Cart();
        $cart->user_id = $user_id;
        $cart->product_id = $product_id;
        $cart->session_id = $session_id;
        $cart->quantity = $quantity;
        $cart->unit_price = $unit_price;
        $cart->attributes = json_encode($attributes);
        $cart->save();

        return true;
    }

    /**
     * validate product attributes
     * @param array $attributes
     * 
     * @return bool
     */
    public static function validateAttribute($attributes)
    {
        $status = 1;
        $product_attributes_keys = config('cart.product_attributes_keys');
        foreach($attributes as $attribute)
        {
            foreach($product_attributes_keys as $key)
            {
                if(!array_key_exists($key, $attribute))
                {
                    $status = 0;
                    break;
                }
            }
            if(!$status)
            {
                break;
            }
        }
        return $status;
    }

    /**
     * Assign cart item after user logged in
     * 
     * @param  int user_id
     * @param  Illuminate\Support\Facades\Session $session -  '_token' value before user logged in
     * 
     * @return bool
     */
    public static function assignCartToLoggedUser($user_id, $session_id)
    {
        $new_session_id = Session::get('_token');
        self::where('session_id', $session_id)
            ->update([ 
                'user_id' => $user_id, 
                'session_id' => $new_session_id
            ]);
        return true;
    }

    /**
     * update quantity using cart id
     * 
     * @param int cart_id
     * @param int quantity
     * 
     * @return bool
     */
    public static function updateCartQuantity($cart_id, $quantity)
    {
        self::where('id', $cart_id)->update(['quantity' => $quantity]);
        return true;
    }

     /**
     * update unit_price using cart id
     * 
     * @param int cart_id
     * @param double unit_price
     * 
     * @return bool
     */
    public static function updateCartUnitPrice($cart_id, $unit_price)
    {
        self::where('id', $cart_id)->update(['unit_price' => $unit_price]);
        return true;
    }

     /**
     * update attribute using cart id
     * 
     * @param int cart_id
     * @param array attributes
     * 
     * @return bool
     */
    public static function updateCartAttribute($cart_id, $attributes)
    {
        if(count($attributes) != 0)
        {
            if(!self::validateAttributes($attributes))
            {
                return false;
            }
            self::where('id', $cart_id)->update(['attributes' => json_encode($attributes) ]);
            return true;
        }
        return false;
    }

    /**
     * delete cart
     * 
     * @param int user_id
     * 
     * @return bool
     */
    public static function deleteCart($user_id = 0)
    {
        if($user_id)
        {
            self::where('user_id', $user_id)->delete();
        }
        else
        {
            $session_id = Session::get('_token');
            self::where('session_id', $session_id)->delete();
        }
        return true;
    } 

    /**
     * delete cart item
     * 
     * @param int cart_id
     * 
     * @return bool
     */
    public static function removeCartItem($cart_id)
    {
        self::where('id', $cart_id)->delete();
        return true;
    } 
    
}