<?php
/**
 * li3_gravatar plugin for Lithium: the most rad php framework.
 *
 * @copyright     Copyright 2010, Michael Hüneburg
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_gravatar\extensions\helper;

/**
 * Helper to output Gravatars.
 */
class Gravatar extends \lithium\template\Helper {

	/**
	 * String templates used by this helper.
	 *
	 * @var array
	 */
	protected $_strings = array(
		'image' => '<img src="{:url}"{:options} />',
	);

	/**
	 * Renders the Gravatar for the given `$email` address.
	 *
	 * @param string $email  
	 * @param array [$options] Optional options. May be any HTML attribute for the image tag and 
	 * 				the following options:
	 *              - default: The default image that will be served if there is no Gravatar
	 *				           associated with `$email`. This can be an URL to a default image,
	 *				           `mm`, `identicon`, `monsterid`, `wavatar` or `404`.
	 *              - size: Size in pixels of the Gravatar. Defaults to `80`.
	 *              - rating: The required Gravatar rating. This can be `g`, `pg`, `r` or `x`.
	 *				          If the Gravatar does not meet the minimum rating the default
	 * 				          image will be returned. Defaults to `g`.
	 * @return string Returns an image tag displaying the Gravatar.
	 */
	public function image($email, array $options = array()) {
		$defaults = array(
			'default' => 404,
			'size' => 80,
			'rating' => 'g',
			'alt' => ''
		);
		$options += $defaults;
		
		$email = strtolower(trim($email));
		$hash  = md5($email);
		
		$url  = "http://gravatar.com/avatar/{$hash}";
		$url .= "?d=" . urlencode($options['default']);
		$url .= "&s={$options['size']}";
		$url .= "&r={$options['rating']}";
		unset($options['default'], $options['size'], $options['rating']);

		return $this->_render(__METHOD__, 'image', compact('url', 'options'));
	}

}

?>