<?php

namespace EloquentPlus\Tests;

use EloquentPlus\Traits\EloquentPlus;
use Illuminate\Database\Eloquent\Model;

class TestExtendedModel extends Model
{
	use EloquentPlus;

	protected $table = 'test_models';

	protected $extendedAttributes = [
		'test_field',
	];

}