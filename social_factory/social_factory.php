<?php

namespace SocialFactory;

use SocialFactory\SocialObjects\FacebookObject;
use SocialFactory\SocialObjects\TwitterObject;

/**
 * Class Factory
 * @package SocialFactory
 */
class SocialFactory
{
	/**
	 * @param string $type
	 * @param \Silex\Application $app
	 * @return null|FacebookObject|TwitterObject
	 */
	public static function create($type, $app)
	{
		$socialType = null;

		switch ($type):

			case 'twitter':
				$socialType = new TwitterObject($app);
				break;

			case 'facebook':
				$socialType = new FacebookObject($app);
				break;

		endswitch;

		return $socialType;
	}

	static public function createTwitter($app)
	{
		return new TwitterObject($app);
	}

	static public function createFacebook($app)
	{
		return new FacebookObject($app);
	}
}