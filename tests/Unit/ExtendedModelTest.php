<?php

namespace Extended\Tests\Unit;

use Extended\Tests\TestCase;
use Extended\Tests\TestExtendedModel;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExtendedModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_model_can_have_extended_attributes()
    {
        $model = new TestExtendedModel;
        $model->test_field = 'Test Field';
        $model->save();

        $model->refresh();

        $this->assertEquals($model->test_field, 'Test Field');
    }

    /** @test */
    public function a_model_cannot_have_extended_attributes_that_are_not_set()
    {
        $model = new TestExtendedModel;
        $model->not_a_test_field = 'Test Field';

        try {
            $model->save();
        } catch (QueryException $e) {
            $this->assertEquals(0, TestExtendedModel::count());

            return;
        }

        $this->fail('Database did not throw an exception');
    }
}
