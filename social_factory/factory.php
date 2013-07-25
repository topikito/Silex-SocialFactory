<?php

namespace SocialFactory;

use \SocialFactory\SocialObjects\Twitter;
use \SocialFactory\SocialObjects\Facebook;

/**
 * Class Factory
 * @package SocialFactory
 */
class Factory
{
	/**
	 * @param string $type
	 * @param \Silex\Application $app
	 * @return null|Facebook|Twitter
	 */
	public static function create($type, $app)
	{
		$socialType = null;

		switch ($type):

			case 'twitter':
				$socialType = new Twitter($app);
				break;

			case 'facebook':
				$socialType = new Facebook($app);
				break;

		endswitch;

		return $socialType;
	}

	static public function createTwitter($app)
	{
		return new Twitter($app);
	}

	static public function createFacebook($app)
	{
		return new Twitter($app);
	}
}