<?php

namespace EloquentPlus\Tests;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;
use EloquentPlus\Providers\EloquentPlusServiceProvider;

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
            EloquentPlusServiceProvider::class,
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
    }

}
