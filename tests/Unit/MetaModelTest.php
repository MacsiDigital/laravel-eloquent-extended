<?php

namespace Extended\Tests\Unit;

use Extended\Tests\TestCase;
use Illuminate\Database\QueryException;
use Extended\Tests\TestMetaModel;
use Illuminate\Foundation\Testing\RefreshDatabase;


class MetaModelTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    public function a_model_can_have_meta_attributes()
    {
        $model = new TestMetaModel;
        $model->test_meta_field = 'Test Meta Field';
        $model->save();

        $this->assertEquals(1, TestMetaModel::count());

        $model = TestMetaModel::first();

        $this->assertEquals($model->test_meta_field, 'Test Meta Field');
    }

    /** @test */
    public function a_model_cannot_have_meta_attributes_that_are_not_set()
    {
        $model = new TestMetaModel;
        $model->not_a_test_meta_field = 'Test Field';
        try {
            $model->save();
        } catch(QueryException $e) {
            $this->assertEquals(0, TestMetaModel::count());
            return;
        }

        $this->fail('Database did not throw an exception');

    }

    /** @test */
    public function a_model_can_have_meta_in_different_languages()
    {
        $model = new TestMetaModel;
        $model->test_meta_field = 'Test Meta Field';
        $model->setMetaLanguage('de');
        $model->test_meta_field = 'Test DE Meta Field';
        $model->save();

        $this->assertEquals(1, TestMetaModel::count());

        $model = TestMetaModel::first();

        $model->setMetaLanguage('de');

        $this->assertEquals($model->test_meta_field, 'Test DE Meta Field');

        $model->setMetaLanguage('en');

        $this->assertEquals($model->test_meta_field, 'Test Meta Field');
    }

}
