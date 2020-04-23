<?php

namespace Extended\Tests\Unit;

use Extended\Tests\TestCase;
use Extended\Tests\TestSlugModel;
use Extended\Tests\TestSlugFieldModel;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SlugModelTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    public function an_extended_model_can_have_a_slug()
    {
        $model = new TestSlugModel;
        $model->uri = 'slug';
        $model->save();

        $this->assertEquals(1, TestSlugModel::count());

        $model = TestSlugModel::first();

        $this->assertEquals($model->uri, 'slug');
    }

    /** @test */
    public function an_extended_model_can_create_its_slug()
    {
        $model = new TestSlugModel;
        $model->createSlug('Test Slug');
        
        $model->save();

        $this->assertEquals(1, TestSlugModel::count());

        $model = TestSlugModel::first();

        $this->assertEquals($model->uri, 'test-slug');       

    }

    /** @test */
    public function an_extended_model_will_change_slug_if_duplicated()
    {
        $model = new TestSlugModel;
        $model->createSlug('Test Slug');
        $model->save();

        $model2 = new TestSlugModel;
        $model2->createSlug('Test Slug');
        $model2->save();

        $this->assertEquals(2, TestSlugModel::count());        

        $this->assertNotEquals($model->uri, $model2->uri);
    }

    /** @test */
    public function an_extended_model_can_have_slugs_in_different_languages()
    {
        $model = new TestSlugModel;
        $model->uri = 'slug-en';
        $model->save();

        $model->setContentLanguage('de');
        $model->uri = 'slug-de';
        $model->save();

        $this->assertEquals(1, TestSlugModel::count());

        $model = TestSlugModel::first();

        $model->setContentLanguage('de');

        $this->assertEquals($model->uri, 'slug-de');

        $model->setContentLanguage('en');

        $this->assertEquals($model->uri, 'slug-en');
    }

    /** @test */
    public function an_extended_model_can_be_retreived_by_its_slug()
    {
        $model = new TestSlugModel;
        $model->createSlug('Test Slug');
        $model->save();
        
        $this->assertEquals(1, TestSlugModel::count());

        $foundModel = TestSlugModel::withSlug('test-slug')->first();

        $this->assertNotNull($foundModel);
    }

    /** @test */
    public function extended_models_can_be_retreived_when_they_dont_have_a_matching_slug()
    {
        $model = new TestSlugModel;
        $model->createSlug('Test Slug');
        $model->save();

        $model = new TestSlugModel;
        $model->createSlug('Test Slug');
        $model->save();

        $model = new TestSlugModel;
        $model->createSlug('Test Slug');
        $model->save();

        $model = new TestSlugModel;
        $model->createSlug('Test Slug');
        $model->save();
        
        $this->assertEquals(4, TestSlugModel::count());

        $this->assertEquals(3, TestSlugModel::withoutSlug('test-slug')->count());
    }

    /** @test */
    public function a_model_can_have_a_slug()
    {
        $model = new TestSlugFieldModel;
        $model->uri = 'slug';
        $model->save();

        $this->assertEquals(1, TestSlugFieldModel::count());

        $model = TestSlugFieldModel::first();

        $this->assertEquals($model->uri, 'slug');
    }

    /** @test */
    public function a_model_can_create_its_slug()
    {
        $model = new TestSlugFieldModel;
        $model->createSlug('Test Slug');
        $model->save();
        
        $this->assertEquals(1, TestSlugFieldModel::count());

        $model = TestSlugFieldModel::first();

        $this->assertEquals($model->uri, 'test-slug');       

    }

    /** @test */
    public function a_model_will_change_slug_if_duplicated()
    {
        $model = new TestSlugFieldModel;
        $model->createSlug('Test Slug');
        $model->save();

        $model2 = new TestSlugFieldModel;
        $model2->createSlug('Test Slug');
        $model2->save();
        
        $this->assertEquals(2, TestSlugFieldModel::count());        

        $this->assertNotEquals($model->uri, $model2->uri);
    }

    /** @test */
    public function a_model_can_be_retreived_by_its_slug()
    {
        $model = new TestSlugFieldModel;
        $model->createSlug('Test Slug');
        $model->save();
        
        $this->assertEquals(1, TestSlugFieldModel::count());

        $this->assertDatabaseHas('test_slug_models', ['uri' => 'test-slug']);

        $foundModel = TestSlugFieldModel::withSlug('test-slug')->first();

        $this->assertNotNull($foundModel);
    }

    /** @test */
    public function models_can_be_retreived_when_they_dont_have_a_matching_slug()
    {
        $model = new TestSlugFieldModel;
        $model->createSlug('Test Slug');
        $model->save();
        
        $model = new TestSlugFieldModel;
        $model->createSlug('Test Slug');
        $model->save();
        
        $model = new TestSlugFieldModel;
        $model->createSlug('Test Slug');
        $model->save();
        
        $model = new TestSlugFieldModel;
        $model->createSlug('Test Slug');
        $model->save();
        
        $this->assertEquals(4, TestSlugFieldModel::count());

        $this->assertEquals(3, TestSlugFieldModel::withoutSlug('test-slug')->count());
    }

}
