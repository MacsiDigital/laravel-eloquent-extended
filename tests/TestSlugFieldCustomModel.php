<?php

namespace Extended\Tests;

use Extended\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;

class TestSlugFieldCustomModel extends Model
{
    use HasSlug;

    protected $table = 'test_slug_custom_models';

    protected $findSlugField = 'slug';
    protected $slugField = 'slug';
}
