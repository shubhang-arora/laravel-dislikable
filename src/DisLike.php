<?php namespace Shubhang\DisLikeable;

use Illuminate\Database\Eloquent\Model as Eloquent;

class DisLike extends Eloquent {

	protected $table = 'dislikeable_dislikes';
	public $timestamps = true;
	protected $fillable = ['dislikable_id', 'dislikable_type', 'user_id'];

	public function dislikable()
	{
		return $this->morphTo();
	}

}