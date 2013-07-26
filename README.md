<h1>Silex-SocialFactory</h1>

Social authentication classes to use with Silex. You could use it with any framework of code, but you will have to change the session provider.

Even it's ment to act as a <i>factory</i>, I've added methods as <i>createTwitter</i> so I can hardcode the return type and this way use the autocomplete functionallity of IDEs.

<h2>Dependencies</h2>

For <b>Twitter</b> we use Abraham's OAuth class: https://github.com/abraham/twitteroauth/

For <b>Facebook</b> we use Facebook's official class: https://github.com/facebook/facebook-php-sdk/

<h2>Examples</h2>

Login function returns the social ID of the user. Auth functions returns ReturnObject which is an unified format for the basic info: social ID, email (if given), avatar and the metadata as an array.

<h3>Twitter</h3>
<h4>Login</h4>

```php
	$twitterObject = Factory::createTwitter($app);
	$twitterObject->setConsumerKey($twitterData['key']);
	$twitterObject->setConsumerSecret($twitterData['secret']);
	$twitterObject->setCallbackURL($config['application.host'] . 'login/twitter/auth/');

	$redirectUrl = $twitterObject->login();
```

<h4>Auth</h4>

```php
	$twitterObject = Factory::createTwitter($app);
	$twitterObject->setConsumerKey($twitterData['key']);
	$twitterObject->setConsumerSecret($twitterData['secret']);
	$twitterObject->setOAuthToken($oAuthToken);
	$twitterObject->setOAuthVerifier($oAuthVerifier);

	$result = $twitterObject->auth();
```

<h3>Facebook</h3>
<h4>Login</h4>
Returns the social ID of the user.

```php
	$facebookObject = Factory::createFacebook($this->_app);
	$facebookObject
		->setAppId($config['social.login.facebook.appid'])
		->setSecret($config['social.login.facebook.secret']);

	$result = $facebookObject->login();
```

<h4>Auth</h4>
Returns the data of the user.

```php
	$facebookObject = Factory::createFacebook($this->_app);
	$facebookObject
		->setAppId($config['social.login.facebook.appid'])
		->setSecret($config['social.login.facebook.secret']);

	$result = $facebookObject->auth();
```