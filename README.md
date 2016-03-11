#  PHP iOS Emoji

An iOS emoji parser for Laravel 5.
![cry](https://raw.githubusercontent.com/euclid1990/php-ios-emoji/master/assets/img/1f602.png)

## Installation

[PHP](https://php.net) 5.5+ and [Laravel 5](https://laravel.com/docs/5.2) are required.

The PHP iOs Emoji Service Provider can be installed via [Composer](http://getcomposer.org) by requiring the
`euclid1990/php-ios-emoji` package and setting the `minimum-stability` to `dev` in your
project's `composer.json`.

```json
{
    "require": {
        "laravel/framework": "5.*",
        "euclid1990/php-ios-emoji": "~1.0"
    },
    "minimum-stability": "dev"
}
```

or

Require this package with composer:
```
composer require euclid1990/php-ios-emoji
```

Update your packages with ```composer update``` or install with ```composer install```.

## Setup

#### Bootstrap

To use the Emoji Service Provider, you must register the provider when bootstrapping your Laravel application. There are essentially two ways to do this.

Find the `providers` key in `config/app.php` and register the Emoji Service Provider.

```php
    'providers' => [
        // ...
        'euclid1990\PhpIosEmoji\Providers\EmojiServiceProvider',
    ]
```
for Laravel 5.1+
```php
    'providers' => [
        // ...
        euclid1990\PhpIosEmoji\Providers\EmojiServiceProvider::class,
    ]
```

Find the `aliases` key in `config/app.php`.

```php
    'aliases' => [
        // ...
        'Emoji' => 'euclid1990\PhpIosEmoji\Facades\Emoji',
    ]
```
for Laravel 5.1+
```php
    'aliases' => [
        // ...
        'Emoji' => euclid1990\PhpIosEmoji\Facades\Emoji::class,
    ]
```

#### Public Assets

Run following command: It will move all emotion icon images and style.css file to `/public/ios-emoji`.

```
php artisan vendor:publish --tag=public --force
```

#### Add Stylesheet
Add the style sheet we prepared for you.

```
<link rel="stylesheet" href="{{ asset('/ios-emoji/css/style.css') }}">
```
Or use helper:
```
<link rel="stylesheet" href="{{ ios_emoji_css() }}">
```

## Usage

#### 1. Example:

```
\Emoji::parse($text);
```

```
<!DOCTYPE html>
<html>
<head>
    <title>PHP iOS Emoji</title>
    <link rel="stylesheet" href="{{ ios_emoji_css() }}">
</head>
<body>
    <p>'Parse the emotions: :smiley: :smile: :baby: :blush: :relaxed: :wink: :heart_eyes: :kissing_heart: in this string.'</p>
    <p>           ↓           </p>
    <p>{!! \Emoji::parse('Parse the emotions: :smiley: :smile: :baby: :blush: :relaxed: :wink: :heart_eyes: :kissing_heart: in this string.') !!}</p>
</body>
</html>
```

Result:

![Preview](https://raw.githubusercontent.com/euclid1990/php-ios-emoji/master/demo/preview.png)

#### 2. Use Helper:

```
$text = "Parse the emotions: :smiley: :smile: in this string.";
// iOS Emoji Parser
ios_emoji($text);
```

## Reference

1. [Emoji Alias](https://github.com/euclid1990/php-ios-emoji/blob/master/data/ecode_to_alias.php)

