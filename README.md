MandrillMailer
==============

[![Build Status](https://travis-ci.org/chrisbarr/mandrill-mailer.svg)](https://travis-ci.org/chrisbarr/mandrill-mailer)

SwiftMailer-like interface for sending emails using the Mandrill Messages API

##Basic Usage
Include it using [composer](https://getcomposer.org/):
```
$ composer require chrisbarr/mandrill-mailer
```
Or add it to your composer.json file:
```json
{
  "require": {
    "chrisbarr/mandrill-mailer": "~0.1"
  }
}
```

Then use it like so:
```php
<?php
require('vendor/autoload.php');

$mailer = new MandrillMailer/Mailer(MANDRILL_API_KEY);

$message = new MandrillMailer/Message();
$message->setFrom('from@example.com', 'From User');
$message->setTo('to@example.com', 'To User');
$message->setSubject('This is my subject');
$message->setHtml('<p>Html goes here</p>');

$mailer->send($message);
```

###See Also
Read more about the Mandrill Messages API here: https://mandrillapp.com/api/docs/messages.JSON.html

Use the official Mandrill PHP library here: https://mandrillapp.com/api/docs/index.php.html

###Reasons for developing
* I wanted to use something with a nicer interface than this: https://mandrillapp.com/api/docs/messages.php.html#method-send
* SwiftMailer is excellent at sending emails using SMTP, but I couldn't find an easy way to send messages using an API
* I wanted to use [Travis CI](https://travis-ci.org/) and be listed on [Packagist](https://packagist.org/) :)
