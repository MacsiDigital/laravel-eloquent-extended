<?php

namespace Extended\Tests;

use Extended\Traits\HasSlug;
use Extended\Traits\HasContent;
use Extended\Traits\IsExtended;
use Illuminate\Database\Eloquent\Model;

class TestSlugCustomModel extends Model
{
	use IsExtended, HasContent, HasSlug;

	protected $table = 'test_models';

	protected $contentAttributes = [
		'slug'
	];

	protected $findSlugField = 'extended->slug';
	protected $slugField = 'slug';
}