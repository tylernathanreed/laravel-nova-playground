<?php

namespace App\Support\Omdb;

use Cache;
use Zttp\Zttp;

class RetrieveMoviePoster
{
	/**
	 * The video resource.
	 *
	 * @var \App\Nova\Resources\Video
	 */
	protected $video;

	/**
	 * Creates a new movie poster retriever.
	 *
	 * @param  \App\Nova\Resources\Video  $video
	 *
	 * @return $this
	 */
	public function __construct($video)
	{
		$this->video = $video;
	}

	/**
	 * Retrieves the movie poster url.
	 *
	 * @return string|null
	 */
	public function __invoke()
	{
		return Cache::rememberForever('posters.' . md5($this->video->title), function() {
			return Zttp::get('http://www.omdbapi.com', [
				't' => $this->video->title,
				'apikey' => config('services.omdb.secret')
			])->json()['Poster'] ?? null;
		});
	}
}