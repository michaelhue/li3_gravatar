<?php
/**
 * li3_gravatar plugin for Lithium: the most rad php framework.
 *
 * @copyright     Copyright 2011, Michael Hüneburg
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_gravatar\models;

/**
 * This model allows you to easily make Gravatar profile requests.
 *
 * Gravatar users may create a public profile with various information including full name, IM accounts,
 * personal links and accounts on other websites like Facebook. This model makes it easy to retrieve this
 * information and use it in your application.
 *
 * Example:
 * 
 * {{{
 * $profile = GravatarProfiles::fetch('john@example.org');
 * }}}
 *
 * The model uses Lithium's `Service` class to make requests to Gravatar. You can configure the class, 
 * for example to use a different socket adapter:
 * 
 * {{{
 * GravatarProfiles::config(array(
 *     'service' => array('socket' => 'Curl')
 * ));
 * }}}
 *
 * @link http://gravatar.com/site/implement/profiles/ Gravatar: Profile Requests
 * @see lithium\net\http\Service
 */
class GravatarProfiles extends \lithium\data\Model {

	protected static $_service;
	
	/**
	 * Class dependencies.
	 *
	 * @var array
	 */
	protected static $_classes = array(
		'service' => 'lithium\net\http\Service'
	);
	
	/**
	 * Meta information.
	 *
	 * @var array
	 */
	protected $_meta = array(
		'connection' => false
	);
	
	/**
	 * Configures this model and the `Service` class.
	 *
	 * @see lithium\data\Model::config()
	 * @param array $config
	 * @return void
	 */
	public static function config(array $config = array()) {
		$defaults = array(
			'service' => array('host' => 'en.gravatar.com')
		);
		$config += $defaults;

		static::_instance('service', $config['service']);
		parent::config($config);
	}
	
	/**
	 * Hashes an email address for usage in a Gravatar request.
	 *
	 * @param string $email Email address.
	 * @return string The hashed email address.
	 */
	public static function hash($email) {
		return md5(strtolower(trim($email)));
	}
	
	/**
	 * Reads a public profile from Gravatar.
	 *
	 * @param string $email Email address.
	 * @return object Returns the profile as an `Entity` object or `false` if the
	 *     request failed.
	 */
	public static function fetch($email) {
		$hash = static::hash($email);

		if ($response = static::_request($hash)) {
			$data = unserialize($response);
		}
		if ($data && is_array($data)) {
			return static::create($data['entry'][0]);
		}
		return false;
	}
	
	/**
	 * Retrieves the profile data from Gravatar.
	 *
	 * @param string $hash The hashed email address.
	 * @return object The response object.
	 */
	protected static function _request($hash) {
		return static::$_service->post("{$hash}.php");
	}

}

?>