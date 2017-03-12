# NowSMS for Laravel
This package makes it easy to send NowSMS notifications with Laravel.

[![Total Downloads](https://img.shields.io/packagist/dm/junityco/laravel-nowsms.svg?style=flat)](https://packagist.org/packages/junityco/laravel-nowsms)
[![Latest Version](https://img.shields.io/packagist/v/junityco/laravel-nowsms.svg?style=flat)](https://github.com/junityco/laravel-nowsms/releases)
[![License](https://img.shields.io/packagist/l/junityco/laravel-nowsms.svg?style=flat)](https://packagist.org/packages/junityco/laravel-nowsms)

## Installation

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

```bash
$ composer require junityco/laravel-nowsms
```

Add the service provider to `config/app.php` in the `providers` array.

```php
Junity\NowSms\NowSmsServiceProvider::class
```

If you want you can use the [facade](http://laravel.com/docs/facades). Add the reference in `config/app.php` to your aliases array.

```php
'NowSms' => Junity\NowSms\Facades\NowSms::class
```

You will also need to install `guzzlehttp/guzzle` http client to send requests.

### Setting up your NowSMS account

Add your NowSMS url, username, password `config/services.php`:

```php
// config/services.php
...
'nowsms' => [
    'url' => 'http://127.0.0.1:8800',
    'username' => '',
    'password' => '',
],
...
```

## Usage

Now you can use the channel in your `via()` method inside the notification:

``` php
use Junity\NowSms\Messages\SmsMessage;
use Junity\NowSms\Channels\NowSmsChannel;
use Illuminate\Notifications\Notification;

class AccountApproved extends Notification
{
    public function via($notifiable)
    {
        return [NowSmsChannel::class];
    }

    public function toNowSms($notifiable)
    {
        return (new SmsMessage)
            ->from("SenderID")
            ->content("Your account was approved!");
    }
}
```

In order to let your Notification know which phone are you sending/calling to, the channel will look for the `phone_number` attribute of the Notifiable model. If you want to override this behaviour, add the `routeNotificationForNowsms` method to your Notifiable model.

```php
public function routeNotificationForNowsms()
{
    return '+1234567890';
}
```

## Example using via code

```php
use Junity\NowSms\Facades\NowSms;

NowSms::send([
    'Text' => 'Some text',
    'Sender' => 'MyApp',
], '+1234567890');
```
