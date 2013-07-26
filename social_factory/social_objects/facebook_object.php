<?php

namespace SocialFactory\SocialObjects;
use Facebook;
use Exception;

/**
 * Class FacebookObject : Called this way so it doesn't interfere with Facebooks class (Not using namespace)
 * @package SocialFactory\SocialObjects
 */
class FacebookObject extends \SocialFactory\Object
{
	const SOCIAL_USERID_VARIABLE = '{{userId}}';
	const SOCIAL_FACEBOOK_AVATAR_LARGE_URL = 'https://graph.facebook.com/{{userId}}/picture?type=large';

	protected $_appId;
	protected $_secret;

	protected $_facebookObject;

	/**
	 * Returns the Facebook's object.
	 *
	 * @return Facebook
	 * @throws Exception
	 */
	protected function _getFB()
	{
		$facebookObject = null;
		if ($this->_facebookObject instanceof Facebook)
		{
			$facebookObject = $this->_facebookObject;
		}
		else
		{
			if (empty($this->_appId))
			{
				throw new Exception('No data for social login: Facebook AppId');
			}
			if (empty($this->_secret))
			{
				throw new Exception('No data for social login: Facebook secret');
			}

			$config = [
				'appId' => $this->_appId,
				'secret' => $this->_secret,
				'fileUpload' => true
			];

			$facebookObject = new Facebook($config);
		}

		return $facebookObject;
	}

	/* SETTERS */
	public function setAppId($appId)
	{
		$this->_appId = $appId;
		return $this;
	}

	public function setSecret($secret)
	{
		$this->_secret = $secret;
		return $this;
	}

	/**
	 * We login the user and get its user id.
	 *
	 * @return string|null Users ID
	 */
	public function login()
	{
		$facebook = $this->_getFB();
		$userId = $facebook->getUser();
		return $userId;
	}

	public function auth()
	{
		$facebook = $this->_getFB();

		$token = $facebook->getAccessToken();
		$accountData = $facebook->api('/me');

		$avatar = str_replace(self::SOCIAL_USERID_VARIABLE, $accountData['id'], self::SOCIAL_FACEBOOK_AVATAR_LARGE_URL);

		$result = $this->_buildSocialResponse('facebook', $accountData['id'], $avatar, $accountData, $accountData['email'], $token);
		return $result;
	}
}