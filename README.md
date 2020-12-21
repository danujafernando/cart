# Laravel Shopping Cart
[![Issues](https://img.shields.io/github/issues/danujafernando/cart?style=flat-square)](https://github.com/danujafernando/cart/issues)
[![Stars](https://img.shields.io/github/stars/danujafernando/cart?style=flat-square)](https://github.com/danujafernando/cart/stargazers)
[![License](https://img.shields.io/github/license/danujafernando/cart?style=flat-square)](https://packagist.org/packages/danujafernando/cart)
[!(https://img.shields.io/twitter/url?style=social)](https://twitter.com/DanFernando1)


A simple laravel shopping cart package


## INSTALLATION

Install the package through [Composer](http://getcomposer.org/).

`composer require danujafernando/cart`

## CONFIGURATION

1.Publish config file

`php artisan vendor:publish --tag='cart-config'`

2.Migrate tables

`php artisan migrate`

## Usage Example

1.Add items to cart

```php

    $product_id = 2;
    $user_id = 1;
    // If user_id is null or zero then it takes session value Session::get('_token');
    // it will be help for user add to cart items before he log in
    $quantity = 3;
    $unit_price = 15.00;
    $attributes = [
        [
            'name' => 'Color',
            'value' => 'Red',
            'price' => '2.00'
        ]
    ]; 
    Cart::add($product_id, $user_id, $quantity, $unit_price, $attributes);

```

2.Check your attribute array is validate or not

```php

    $attributes = [
        [
            'name' => 'Color',
            'value' => 'Blue',
            'price' => '3.00'
        ],
        [
            'name' => 'Size',
            'value' => 'XL',
            'price' => '5.00'
        ]
    ];
    Cart::validateAttribute($attributes);

    // return value is true.

    $attributes = [
        [
            'name' => 'Color',
            'price' => '3.00'
        ],
        [
            'name' => 'Size',
            'value' => 'XL',
            'price' => '5.00'
        ]
    ];
    Cart::validateAttribute($attributes);

    // return value is false because the value is missing from first attribute.
```
### IMPORTANT NOTE!

By default attribute array need name, value and price. if you want to change it your can do it using config/cart.php file

` 'product_attributes_keys' => [ 'name', 'value', 'price'] `

3.Cart items assign to user after logged in

```php

     // before user log in, Session::get('_token') value store another name
     /*
     *  $previous_session_id = Session::get('_token');
     *  Session::put('previous_session_id', $previous_session_id);
     *  This should be run showLoginForm() in your Logincontroller
     */

    // After user logged in 
    /*
    *  $previous_session_id = Session::get('previous_session_id');
    *  This should be run authenticated() in your Logincontroller
    */
    Cart::assignCartToLoggedUser($user_id, $previous_session_id);

```

4.Retrieve cart items

```php

    $user_id = 3;
    $carts = Cart::getCart($user_id);

```

5.Update cart item quantity

```php

    $cart_id = 3;
    $quantity = 2;
    Cart::updateCartQuantity($cart_id, $quantity);

```

6.Update cart item price

```php

    $cart_id = 3;
    $unit_price = 29.99;
    Cart::updateCartUnitPrice($cart_id, $unit_price);

```

7.Update cart item attributes

```php

    //you have to pass full attributes array 
    Cart::updateCartAttribute($cart_id, $attributes);

```

8.Delete full cart items

```php

    $user_id = 2;
    // this function will be delete all items by user_id
    Cart::deleteCart($user_id);

```

9.Delete a cart item

```php

    $cart_id = 30;
    Cart::removeCartItem($user_id);

```

10.Get cart total.
```php

    $user_id = 2;
    get_subtotal($user_id);

```

## License

The Laravel Shopping Cart is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

### Disclaimer

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
