# Laravel Shopping Cart
[![Issues](https://img.shields.io/github/issues/danujafernando/cart?style=flat-square)](https://github.com/danujafernando/cart/issues)
[![Stars](https://img.shields.io/github/stars/danujafernando/cart?style=flat-square)](https://github.com/danujafernando/cart/stargazers)

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

1. Add items to cart

```php

    $product_id = 2;
    $user_id = 1;
    // If user_id is null or zero then it takes session value Session::get('_token');
    $quantity = 3;
    $unit_price = 15.00;
    $attributes = [
        [
            'name' => 'Color',
            'value' => 'Red',
            'price' => '2.00'
        ]
    ];
    Cart::add($product_id, $user_id = 0, $quantity = 1, $unit_price = 0.01, $attributes = []);

```

2. Check your attribute array is validate or not

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