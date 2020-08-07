<?php

namespace Extended\Tests;

use Extended\Providers\ExtendedServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp() : void
    {
        parent::setup();

        $this->setUpEnvironment();

        $this->setUpDatabase();
    }

    /**
      * @param \Illuminate\Foundation\Application $app
      *
      * @return array
      */
    protected function getPackageProviders($app)
    {
        return [
            ExtendedServiceProvider::class,
        ];
    }

    protected function setUpEnvironment()
    {
    }
    
    protected function setUpDatabase()
    {
        Schema::create('test_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('extended');
            $table->timestamps();
        });

        Schema::create('test_slug_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uri');
            $table->timestamps();
        });

        Schema::create('test_slug_custom_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug');
            $table->timestamps();
        });
    }
}
