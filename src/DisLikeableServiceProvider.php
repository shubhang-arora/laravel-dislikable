<?php namespace Shubhang\DisLikeable;

use Illuminate\Support\ServiceProvider;

/**
 * Copyright (C) 2015 Shubhang-arora
 */
class DisLikeableServiceProvider extends ServiceProvider {

	protected $defer = true;
	
	public function boot() {
		$this->publishes([
			__DIR__.'/../migrations/2015_09_10_065447_create_reportable_tables.php' => database_path('migrations/2015_09_10_065447_create_reportable_tables.php'),
		]);
	}
	
	public function register() {
		$this->app->bind('DisLikeable', function($app){
			return new DisLikeable;
		});
	}

	public function when() {
		return array('artisan.start');
	}
	
}