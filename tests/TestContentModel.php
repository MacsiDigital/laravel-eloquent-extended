<?php

namespace EloquentPlus\Tests;

use EloquentPlus\Traits\HasContent;
use EloquentPlus\Traits\EloquentPlus;
use Illuminate\Database\Eloquent\Model;

class TestContentModel extends Model
{
	use EloquentPlus, HasContent;

	protected $table = 'test_models';

	protected $contentAttributes = [
		'test_content_field'
	];
}