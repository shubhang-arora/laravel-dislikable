Laravel DisLikeable Plugin
============

Trait for Laravel Eloquent models to allow easy implementation of a "Dislike" feature.

#### Composer Install (for Laravel 5)

	composer require shubhang-arora/laravel-dislikeable "~1.0.7"

#### Install and then run the migrations

```php
'providers' => array(
	 Shubhang\DisLikeable\DisLikeableServiceProvider::class,
);
```

```bash
php artisan vendor:publish --provider="Shubhang\DisLikeable\DisLikeableServiceProvider"
php artisan migrate
```

#### Setup your models

    class Article extends \Illuminate\Database\Eloquent\Model {
		use Shubhang\DisLikeable\DisLikeableTrait;
	}

#### Sample Usage

	$article->dislike(); // dislike the article for current user
	$article->dislike($myUserId); // pass in your own user id
	$article->dislike(0); // just add dislikes to the count, and don't track by user
	
	$article->undislike(); // remove dislike from the article
	$article->undislike($myUserId); // pass in your own user id
	$article->undislike(0); // remove dislikes from the count -- does not check for user
	
	$article->dislikeCount; // get count of dislikes
	
	$article->dislikes; // Iterable Illuminate\Database\Eloquent\Collection of existing dislikes
	
	$article->disliked(); // check if currently logged in user disliked the article
	$article->disliked($myUserId);
	
	Article::whereDisLiked($myUserId) // find only articles where user disliked them
		->with('dislikeCounter') // highly suggested to allow eager load
		->get();

#### Credits

 - Shubhang Arora
