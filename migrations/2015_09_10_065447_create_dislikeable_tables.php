<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDisLikeableTables extends Migration {

	public function up() {
		
		Schema::create('dislikeable_dislikes', function(Blueprint $table) {
			$table->increments('id');
			$table->string('dislikable_id', 36);
			$table->string('dislikable_type', 255);
			$table->string('user_id', 36)->index();
			$table->timestamps();
			$table->unique(['dislikable_id', 'dislikable_type', 'user_id'], 'dislikeable_dislikes_unique');
		});
		
		Schema::create('dislikeable_dislike_counters', function(Blueprint $table) {
			$table->increments('id');
			$table->string('dislikable_id', 36);
			$table->string('dislikable_type', 255);
			$table->integer('count')->unsigned()->default(0);
			$table->unique(['dislikable_id', 'dislikable_type'], 'dislikeable_counts');
		});
		
	}

	public function down() {
		Schema::drop('dislikeable_dislikes');
		Schema::drop('dislikeable_dislike_counters');
	}
}