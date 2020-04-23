<?php

namespace Extended\Tests;

use Extended\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;

class TestSlugFieldModel extends Model
{
	use HasSlug;

	protected $table = 'test_slug_models';

}