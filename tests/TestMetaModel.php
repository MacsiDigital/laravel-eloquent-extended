<?php

namespace Extended\Tests;

use Extended\Traits\HasMeta;
use Extended\Traits\IsExtended;
use Illuminate\Database\Eloquent\Model;

class TestMetaModel extends Model
{
	use IsExtended, HasMeta;

	protected $table = 'test_models';

	protected $metaAttributes = [
		'test_meta_field'
	];
}