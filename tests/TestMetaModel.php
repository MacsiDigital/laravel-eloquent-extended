<?php

namespace EloquentPlus\Tests;

use EloquentPlus\Traits\HasMeta;
use EloquentPlus\Traits\EloquentPlus;
use Illuminate\Database\Eloquent\Model;

class TestMetaModel extends Model
{
	use EloquentPlus, HasMeta;

	protected $table = 'test_models';

	protected $metaAttributes = [
		'test_meta_field'
	];
}