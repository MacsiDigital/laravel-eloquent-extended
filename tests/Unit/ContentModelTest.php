<?php

namespace Extended\Tests\Unit;

use Extended\Tests\TestCase;
use Illuminate\Database\QueryException;
use Extended\Tests\TestContentModel;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ContentModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_model_can_have_content_attributes()
    {
        $model = new TestContentModel;
        $model->test_content_field = 'Test Content Field';
        $model->save();

        $model->refresh();

        $this->assertEquals($model->test_content_field, 'Test Content Field');
    }

    /** @test */
    public function a_model_cannot_have_content_attributes_that_are_not_set()
    {
        $model = new TestContentModel;
        $model->not_a_test_content_field = 'Test Field';
        try {
            $model->save();
        } catch(QueryException $e) {
            $this->assertEquals(0, TestContentModel::count());
            return;
        }

        $this->fail('Database did not throw an exception');

    }

    /** @test */
    public function a_model_can_have_content_in_different_languages()
    {
        $model = new TestContentModel;
        $model->test_content_field = 'Test Content Field';
        $model->setContentLanguage('de');
        $model->test_content_field = 'Test DE Content Field';
        $model->save();

        $model->refresh();

        $model->setContentLanguage('de');

        $this->assertEquals($model->test_content_field, 'Test DE Content Field');

        $model->setContentLanguage('en');

        $this->assertEquals($model->test_content_field, 'Test Content Field');
    }

}
