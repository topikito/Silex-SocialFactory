<?php

namespace SocialFactory;

use Exception;

/**
 * Class Object
 * @package SocialFactory
 */
abstract class SocialObject
{
	/**
	 * @var \Silex\Application
	 */
	protected $_app;
	protected $_host;

	/**
	 * Initialize the social object with the app so we can use the session
	 *
	 * @param \Silex\Application $app
	 * @throws Exception
	 */
	public function __construct(\Silex\Application $app)
	{
		if (empty($app['session']))
		{
			throw new Exception('No data for social login: Session not defined');
		}
		$this->_app = $app;
	}

	protected function _buildSocialResponse($type, $socialId, $avatar, $metadata, $email = null, $token = null)
	{
		$response = new SocialResponse($type, $socialId, $avatar, $metadata, $email, $token);
		return $response;
	}

	abstract public function login();
	abstract public function auth();
}