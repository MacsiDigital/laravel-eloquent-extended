<?php

namespace Extended\Tests;

use Extended\Traits\HasContent;
use Extended\Traits\IsExtended;
use Illuminate\Database\Eloquent\Model;

class TestContentModel extends Model
{
	use IsExtended, HasContent;

	protected $table = 'test_models';

	protected $contentAttributes = [
		'test_content_field'
	];
}