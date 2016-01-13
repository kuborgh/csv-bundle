CSV Bundle
==========
[![Build Status][travis-image]][travis-url]
[travis-url]: https://travis-ci.org/kuborgh/csv-bundle
[travis-image]: https://secure.travis-ci.org/kuborgh/csv-bundle.svg?branch=master

This bundle is intended to be simple, but rfc4180 conform csv parser and writer. It will be extended in the future to 
fit more and more needs of custom implementations.

Installation
------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require kuborgh/csv-bundle
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new Kuborgh\CsvBundle\CsvBundle(),
        );

        // ...
    }

    // ...
}
```

Configuration
-------------

Following configuration variables exist an can be inserted into the config.yml of your project
```yml
kuborgh_csv:
    parser:
        # Add here as many parser as you need. Each will get it's own service kuborgh_csv.parser.my_parser
        my_parser:
            # Delimiter (default: ",")
            delimiter: ","
            
            # Line Ending (default: "\r\n")
            line_ending: "\r\n"
            
            # Implementation for the parser. Possible values are "character" (default) oder "simple" (not recommended).
            # You can add your own parser implementation by registering the class name in parameters like  
            # kuborgh_csv.parser.<my_implementation>.class 
            implementation: character
```

Usage
-----
```php
$parser = $container->get('kuborgh_csv.parser.<my_parser>');
$array = $parser->parse($csv);
```

Testing
-------
The whole parser should be unittested. You can run the tests with
```bash
$ composer install
$ bin/phpunit
```
