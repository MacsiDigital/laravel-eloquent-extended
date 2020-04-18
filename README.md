# Eloquent Extended Package

Extended Eloquent Models, mainly for JSON and Multi Language Content

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

#### Content

To use content is similar with the exception that we can set languages

``` php

use Extended\Traits\IsExtended;
use Extended\Traits\HasContent;
use Illuminate\Database\Eloquent\Model;

class TestExtendedModel extends Model
{
	use IsExtended, HasContent;

	protected $extendedAttributes = [
		'content'
	];

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

#### Meta

To use meta is the same as content

``` php

use Extended\Traits\IsExtended;
use Extended\Traits\HasMeta;
use Illuminate\Database\Eloquent\Model;

class TestExtendedModel extends Model
{
	use IsExtended, HasMeta;

	protected $extendedAttributes = [
		'meta'
	];

	protected $metaAttributes = [
		'test_meta_field',
	];

}
```

Once set it will act like a normal field

``` php
$test = new model;
$test->test_meta_field = 'something';

echo $test->test_meta_field;
```

We can set and get different languages like so

``` php
$test = new model;
$test->test_meta_field = 'something';

$test->setMetaLanguage('de');

$test->test_meta_field = 'something DE';

$test->setMetaLanguage('en');

echo $test->test_meta_field; // 'something'

$test->setMetaLanguage('de');

echo $test->test_meta_field; // 'something DE'

```

### Testing

We have a test suite testing our implementations, to use just run phpunit

``` bash
phpunit
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Credits

- [Colin Hall](https://github.com/colinhall17)
- [All Contributors](../../contributors)

## License

This is copyrighted and cannot be reused without permission.
