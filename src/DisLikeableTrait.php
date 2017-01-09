<?php namespace Shubhang\DisLikeable;

/**
 * Copyright (C) 2014 Robert Conner
 */

trait DisLikeableTrait {

	/**
	 * Fetch only records that currently logged in user has liked/followed
	 */
	public function scopeWhereDisLiked($query, $userId=null)
	{
		if(is_null($userId)) {
			$userId = $this->loggedInUserId();
		}
		
		return $query->whereHas('dislikes', function($q) use($userId) {
			$q->where('user_id', '=', $userId);
		});
	}
	
	/**
	 * Populate the $model->likes attribute
	 */
	public function getDisLikeCountAttribute()
	{
		return $this->dislikeCounter ? $this->dislikeCounter->count : 0;
	}
	
	/**
	 * Collection of the likes on this record
	 */
	public function dislikes()
	{
		return $this->morphMany('\Shubhang\DisLikeable\DisLike', 'dislikable');
	}

	/**
	 * Counter is a record that stores the total likes for the
	 * morphed record
	 */
	public function dislikeCounter()
	{
		return $this->morphOne('\Shubhang\DisLikeable\DisLikeCounter', 'dislikable');
	}
	
	/**
	 * Add a like for this record by the given user.
	 * @param $userId mixed - If null will use currently logged in user.
	 */
	public function dislike($userId=null)
	{
		if(is_null($userId)) {
			$userId = $this->loggedInUserId();
		}
		
		if($userId) {
			$dislike = $this->dislikes()
				->where('user_id', '=', $userId)
				->first();
	
			if($dislike) return;
	
			$dislike = new DisLike();
			$dislike->user_id = $userId;
			$this->dislikes()->save($dislike);
		}

		$this->incrementDisLikeCount();
	}

	/**
	 * Remove a like from this record for the given user.
	 * @param $userId mixed - If null will use currently logged in user.
	 */
	public function undislike($userId=null)
	{
		if(is_null($userId)) {
			$userId = $this->loggedInUserId();
		}
		
		if($userId) {
			$dislike = $this->dislikes()
				->where('user_id', '=', $userId)
				->first();
	
			if(!$dislike) return;
	
			$dislike->delete();
		}

		$this->decrementDisLikeCount();
	}
	
	/**
	 * Has the currently logged in user already "liked" the current object
	 *
	 * @param string $userId
	 * @return boolean
	 */
	public function disliked($userId=null)
	{
		if(is_null($userId)) {
			$userId = $this->loggedInUserId();
		}
		
		return (bool) $this->dislikes()
			->where('user_id', '=', $userId)
			->count();
	}
	
	/**
	 * Private. Increment the total like count stored in the counter
	 */
	private function incrementDisLikeCount()
	{
		$counter = $this->dislikeCounter()->first();
		
		if($counter) {
			
			$counter->count++;
			$counter->save();
			
		} else {
			
			$counter = new DisLikeCounter;
			$counter->count = 1;
			$this->dislikeCounter()->save($counter);
			
		}
	}
	
	/**
	 * Private. Decrement the total like count stored in the counter
	 */
	private function decrementDisLikeCount()
	{
		$counter = $this->dislikeCounter()->first();

		if($counter) {
			$counter->count--;
			if($counter->count) {
				$counter->save();
			} else {
				$counter->delete();
			}
		}
	}
	
	/**
	 * Fetch the primary ID of the currently logged in user
	 * @return number
	 */
	/*public function loggedInUserId()
	{
		return \Auth::id();
	}*/
	
}
