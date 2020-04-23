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

#### Slugs

We can use Mutliple Language Slugs by adding both HasContent and HasSlug traits and setting the slug fields.

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

You can then add a uri like so

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

We can then retrieve by slug with the withSlug scoped query method

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
