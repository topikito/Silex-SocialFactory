<?php

namespace SocialFactory\SocialObjects;
use TwitterOAuth;
use Exception;

/**
 * Class Twitter
 * @package SocialFactory\SocialObjects
 */
class TwitterObject extends \SocialFactory\SocialObject
{
	const SOCIAL_TOKEN_NAME = 'token';
	const SOCIAL_TOKEN_SECRET_NAME = 'token_secret';
	const SOCIAL_OAUTH_VERIFY_CREDENTIALS_URI = '/account/verify_credentials';

	protected $_consumerKey;
	protected $_consumerSecret;
	protected $_oAuthToken;
	protected $_oAuthVerifier;

	protected $_callbackURL;

	/**
	 * Build the OAuth object. In this case, we use TwitterOAuth by "abraham":
	 * @url https://github.com/abraham/twitteroauth/
	 *
	 * @param null $token
	 * @param null $tokenSecret
	 * @return TwitterOAuth
	 * @throws Exception
	 */
	protected function _getTWOAuth($token = null, $tokenSecret = null)
	{
		if (empty($this->_consumerKey))
		{
			throw new Exception('No data for social login: Twitter key');
		}

		if (empty($this->_consumerSecret))
		{
			throw new Exception('No data for social login: Twitter secret');
		}

		return new TwitterOAuth($this->_consumerKey, $this->_consumerSecret, $token, $tokenSecret);
	}

	/* SETTERS */
	public function setConsumerKey($consumerKey)
	{
		$this->_consumerKey = $consumerKey;
		return $this;
	}

	public function setConsumerSecret($consumerSecret)
	{
		$this->_consumerSecret = $consumerSecret;
		return $this;
	}

	public function setOAuthToken($oAuthToken)
	{
		$this->_oAuthToken = $oAuthToken;
		return $this;
	}

	public function setOAuthVerifier($oAuthVerifier)
	{
		$this->_oAuthVerifier = $oAuthVerifier;
		return $this;
	}

	public function setCallbackURL($url)
	{
		$this->_callbackURL = $url;
	}

	/**
	 * Before we have authorization to retrieve the data, we try to login the user in twitter and get
	 * the credentials on the callback.
	 *
	 * @return string The URL for the redirect
	 * @throws Exception
	 */
	public function login()
	{
		if (empty($this->_callbackURL))
		{
			throw new Exception('No data for social login: Callback URL');
		}

		$oAuth = $this->_getTWOAuth();
		$tokenCredentials = $oAuth->getRequestToken($this->_callbackURL);
		$oauthRedirectUrl = $oAuth->getAuthorizeURL($tokenCredentials);

		$this->_app['session']->set(self::SOCIAL_TOKEN_NAME, $tokenCredentials['oauth_token']);
		$this->_app['session']->set(self::SOCIAL_TOKEN_SECRET_NAME, $tokenCredentials['oauth_token_secret']);

		return $oauthRedirectUrl;
	}

	/**
	 * Once we've managed to authenticate the user, we retrieve the data and return it in a standard way using
	 * our own Response object.
	 *
	 * @return \SocialFactory\SocialResponse
	 * @throws Exception
	 */
	public function auth()
	{
		if (empty($this->_oAuthVerifier))
		{
			throw new Exception('No data for social login: OAuth Verifier');
		}

		//We get the app config
		$token = $this->_app['session']->get(self::SOCIAL_TOKEN_NAME);
		$tokenSecret = $this->_app['session']->get(self::SOCIAL_TOKEN_SECRET_NAME);

		//Send an OAuth to twitter to try to login
		$oAuth = $this->_getTWOAuth($token, $tokenSecret);

		$tokenCredentials = $oAuth->getAccessToken($this->_oAuthVerifier);

		$oAuth = $this->_getTWOAuth($tokenCredentials['oauth_token'], $tokenCredentials['oauth_token_secret']);
		$oAuth->decode_json = false;
		$account = $oAuth->get(self::SOCIAL_OAUTH_VERIFY_CREDENTIALS_URI);

		$accountData = json_decode($account, true);

		$result = $this->_buildSocialResponse('twitter', $accountData['id'], $accountData['profile_image_url'], $accountData, null);
		return $result;
	}
}