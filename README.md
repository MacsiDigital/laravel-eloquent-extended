# Laravel Eloquent Extended

## Extended model attributes, Mulit Language attributes and Slugs
 
![Header Image](https://github.com/MacsiDigital/repo-design/raw/master/laravel-eloquent-extended/header.png)

<p align="center">
 <a href="https://github.com/MacsiDigital/laravel-eloquent-extended/actions?query=workflow%3ATests"><img src="https://github.com/MacsiDigital/laravel-eloquent-extended/workflows/Tests/badge.svg" style="max-width:100%;"  alt="tests badge"></a>
 <a href="https://packagist.org/packages/macsidigital/laravel-eloquent-extended"><img src="https://img.shields.io/packagist/v/macsidigital/laravel-eloquent-extended.svg?style=flat-square" alt="version badge"/></a>
 <a href="https://packagist.org/packages/macsidigital/laravel-eloquent-extended"><img src="https://img.shields.io/packagist/dt/macsidigital/laravel-eloquent-extended.svg?style=flat-square" alt="downloads badge"/></a>
</p>

Extended Eloquent Models, mainly for JSON and Multi Language Content

## Support us

We invest a lot in creating [open source packages](https://macsidigital.co.uk/open-source), and would be grateful for a [sponsor](https://github.com/sponsors/MacsiDigital) if you make money from your product that uses them.

## Installation

You can install the package via composer:

```bash
composer require macsidigital/laravel-eloquent-extended
```

## Usage

To use extended we just need to add the trait and add a protected extendedAttributes variable like so

``` php

use Extended\Traits\IsExtended;
use Illuminate\Database\Eloquent\Model;

class TestExtendedModel extends Model
{
	use IsExtended;

	protected $extendedAttributes = [
		'test_field',
	];

}
```

Once set it will act like a normal field

``` php
$test = new model;
$test->test_field = 'something';

echo $test->test_field;
```

### Content

To use content is similar with the exception that we can set languages

``` php

use Extended\Traits\IsExtended;
use Extended\Traits\HasContent;
use Illuminate\Database\Eloquent\Model;

class TestExtendedModel extends Model
{
	use IsExtended, HasContent;

	protected $contentAttributes = [
		'test_content_field',
	];

}
```

Once set it will act like a normal field

``` php
$test = new model;
$test->test_content_field = 'something';

echo $test->test_content_field;
```

We can set and get different languages like so

``` php
$test = new model;
$test->test_content_field = 'something';

$test->setContentLanguage('de');

$test->test_content_field = 'something DE';

$test->setContentLanguage('en');

echo $test->test_content_field; // 'something'

$test->setContentLanguage('de');

echo $test->test_content_field; // 'something DE'

```

### Slugs

We can use Multiple Language Slugs by adding both HasContent and HasSlug traits and setting the slug fields.

``` php

use Extended\Traits\HasSlug;
use Extended\Traits\IsExtended;
use Extended\Traits\HasContent;
use Illuminate\Database\Eloquent\Model;

class TestExtendedModel extends Model
{
	use IsExtended, HasContent, HasSlug;

	protected $contentAttributes = [
		'uri',
	];

	protected $findSlugField = 'extended->uri';
	protected $slugField = 'uri';

}
```

You can then add the uri like so

``` php
$test = new model;
$test->uri = 'something';

echo $test->uri; //esomething
```

To ensure there are no duplicate slugs you can use the method createSlug like so

``` php
$test = new model;
$test->createSlug('Test Something');

echo $test->uri; //test-something

$test = new model;
$test->createSlug('Test Something');

echo $test->uri; //test-something-h58s
```

We can set and get different languages like so

``` php
$test = new model;
$test->uri = 'something';

$test->setLanguage('de');

$test->uri = 'something-de';

$test->setMetaLanguage('en');

echo $test->uri; // 'something'

$test->setMetaLanguage('de');

echo $test->uri; // 'something-de'

```

We can then retrieve by the slug with the withSlug scoped query method

``` php
$test = new model;
$test->createSlug('something');

$model = model::withSlug('something')->first()

echo $model->uri; // 'something'

```

There is also a reversed function to get all models without the slug

``` php
$test = new model;
$test->createSlug('something');

$test = new model;
$test->createSlug('something-1234');

$model = model::withoutSlug('something')->first()

echo $model->uri; // 'something-1234'

```

We can also use slugs outside of the multi language scope, just set to a normal database field.

``` php

use Extended\Traits\HasSlug;
use Extended\Traits\IsExtended;
use Extended\Traits\HasContent;
use Illuminate\Database\Eloquent\Model;

class TestExtendedModel extends Model
{
	use HasSlug;

	protected $findSlugField = 'uri';
	protected $slugField = 'uri';

}
```

Then all functions will work as previous

### Route Model Binding

You can use {item:slug} in routes to automatically retrieve items by their slug.  Just remember to Typehint the model in the controller/Route action.


## Testing

We have a test suite testing our implementations, to use just run phpunit

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security-related issues, please email [info@macsi.co.uk](mailto:info@macsi.co.uk) instead of using the issue tracker.

## Credits

- [Colin Hall](https://github.com/colinhall17)
- [MacsiDigital](https://github.com/MacsiDigital)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
