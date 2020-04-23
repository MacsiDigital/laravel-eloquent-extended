<?php

namespace Extended\Tests;

use Extended\Traits\HasSlug;
use Extended\Traits\HasContent;
use Extended\Traits\IsExtended;
use Illuminate\Database\Eloquent\Model;

class TestSlugModel extends Model
{
	use IsExtended, HasContent, HasSlug;

	protected $table = 'test_models';

	protected $contentAttributes = [
		'uri'
	];

	protected $findSlugField = 'extended->uri';
	protected $slugField = 'uri';
}