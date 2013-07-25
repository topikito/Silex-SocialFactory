<?php

namespace SocialFactory;

/**
 * Class Object
 * @package SocialFactory
 */
abstract class Object
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

	protected function _buildSocialResponse($type, $socialId, $avatar, $metadata, $email = null)
	{
		$response = new Response($type, $socialId, $avatar, $metadata, $email);
		return $response;
	}

	abstract public function login();
	abstract public function auth();
}