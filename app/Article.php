<?php namespace App;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

	protected $fillable = [
		'title',
		'body',
		'published_at',		
	];

	protected $dates = ['published_at'];

	public function scopePublished($query)
	{
		$query->where('published_at', '<=', Carbon::now());
	}

	public function scopeUnpublished($query)
	{
		$query->where('published_at', '>', Carbon::now());
	}

	public function setPublishedAtAttribute($date)
	{
		$this->attributes['published_at'] = Carbon::createFromFormat('Y-m-d', $date);
	}

	public function getPublishedAtAttribute($date)
	{
		return Carbon::parse($date)->format('Y-m-d');
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function tags()
	{
		return $this->belongsToMany('App\Tag')->withTimestamps();
	}

	public function getTagListAttribute()
	{
		return $this->tags->lists('id');
	}

}
