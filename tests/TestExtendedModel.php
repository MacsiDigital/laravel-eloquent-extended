<?php

namespace Extended\Tests;

use Extended\Traits\IsExtended;
use Illuminate\Database\Eloquent\Model;

class TestExtendedModel extends Model
{
    use IsExtended;

    protected $table = 'test_models';

    protected $extendedAttributes = [
        'test_field',
    ];
}
