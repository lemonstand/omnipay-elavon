# Omnipay: Elavon

**Elavon payment processing driver for the Omnipay PHP payment processing library**

[![Build Status](https://travis-ci.org/lemonstand/omnipay-elavon.svg)](https://travis-ci.org/lemonstand/omnipay-elavon) [![Coverage Status](https://coveralls.io/repos/github/lemonstand/omnipay-elavon/badge.svg?branch=master)](https://coveralls.io/github/lemonstand/omnipay-elavon?branch=master) [![Latest Stable Version](https://poser.pugx.org/lemonstand/omnipay-elavon/v/stable.svg)](https://packagist.org/packages/lemonstand/omnipay-elavon) [![Total Downloads](https://poser.pugx.org/lemonstand/omnipay-elavon/downloads)](https://packagist.org/packages/lemonstand/omnipay-elavon)

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements Elavon Payments support for Omnipay. Please see the full [Converge documentation](https://www.myvirtualmerchant.com/VirtualMerchant/download/developerGuide.pdf) for more information.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "lemonstand/omnipay-elavon": "~1.0"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Basic Usage

The following gateways are provided by this package:

* Converge

```php
    $gateway = Omnipay::create('Elavon_Converge');
    $gateway->setMerchantId('[MERCHANT_ID]');
    $gateway->setUsername('[USER_ID]');
    $gateway->setPassword('[USER_PIN]');

    // Test mode hits the demo endpoint.
    $gateway->setTestMode(true);

    try {
        $params = array(
            'amount'                => 10.00,
            'card'                  => $card,
            'ssl_invoice_number'    => 1,
            'ssl_show_form'         => 'false',
            'ssl_result_format'     => 'ASCII',
        );

        $response = $gateway->purchase($params)->send();

        if ($response->isSuccessful()) {
            // successful
        } else {
            throw new ApplicationException($response->getMessage());
        }
    } catch (ApplicationException $e) {
        throw new ApplicationException($e->getMessage());
    }

```

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.


## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/lemonstand/omnipay-elavon/issues),
or better yet, fork the library and submit a pull request.
