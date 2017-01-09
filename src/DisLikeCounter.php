<?php namespace Shubhang\DisLikeable;

use Illuminate\Database\Eloquent\Model as Eloquent;

class DisLikeCounter extends Eloquent {

	protected $table = 'dislikeable_dislike_counters';
	public $timestamps = false;
	protected $fillable = ['dislikable_id', 'dislikable_type', 'count'];
	
	public function dislikable()
	{
		return $this->morphTo();
	}
	
}