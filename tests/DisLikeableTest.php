<?php

use Mockery as m;
use Shubhang\DisLikeable\DisLikeableTrait;

class TaggingTest extends PHPUnit_Framework_TestCase {

	public function tearDown()
	{
		m::close();
	}
	
	public function testDisLike()
	{
		$likable = m::mock('DisLikeableStub[incrementDisLikeCount]');
		$likable->shouldReceive('incrementDisLikeCount')->andReturn(null);
		
		$likable->dislike(0);
	}
	
	public function testUndislike()
	{
		$likable = m::mock('DisLikeableStub[decrementDisLikeCount]');
		$likable->shouldReceive('decrementDisLikeCount')->andReturn(null);
		
		$likable->undislike(0);
	}
	
}

class DisLikeableStub extends \Illuminate\Database\Eloquent\Model {
	use DisLikeableTrait;

	public function incrementDisLikeCount() {}
	public function decrementDisLikeCount() {}
}