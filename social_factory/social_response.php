<?php

namespace SocialFactory;

/**
 * Class Response
 * @package SocialFactory
 */
class SocialResponse
{

	public $type;
	public $id;
	public $avatar;
	public $metadata;
	public $email;
	public $token;

	/**
	 * @param string $type The type of social network's data we are returning
	 * @param int $id The social ID of the network
	 * @param string $avatar The URL of the avatar
	 * @param array $metadata The response as array
	 * @param null $email In case we get the email, we return it too
	 */
	public function __construct($type, $id, $avatar, $metadata, $email = null, $token = null)
	{
		$this->type = $type;
		$this->id = $id;
		$this->avatar = $avatar;
		$this->metadata = $metadata;
		$this->email = $email;
		$this->token = $token;
	}

}