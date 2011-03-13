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
		'gravatar_image' => '<img src="{:url}"{:options} />'
	);

	/**
	 * Renders the Gravatar for the given `$email` address.
	 *
	 * @param string $email  
	 * @param array [$options] Optional options. May be any HTML attribute for the image tag and 
	 * 				the following options:
	 *              - default: The default image that will be served if there is no Gravatar
	 *				           associated with `$email`. This can be a full URL to a default 
	 *				           image, an absolute path, `mm`, `identicon`, `monsterid`, `wavatar` 
	 * 				           or `404` (default).
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
		$request = $this->_context->request();
		
		$defaultValues = array(404, 'mm', 'identicon', 'monsterid', 'wavatar');
		if (!in_array($options['default'], $defaultValues) && strpos($options['default'], '://') === false) {
			$host = $request->env('HTTP_HOST');
			$scheme = $request->env('HTTPS') ? 'https://' : 'http://';
			$options['default'] = $scheme . $host . $options['default'];
		}
		
		$email = strtolower(trim($email));
		$hash  = md5($email);
		
		$url  = "http://gravatar.com/avatar/{$hash}";
		$url .= "?d=" . urlencode($options['default']);
		$url .= "&s={$options['size']}";
		$url .= "&r={$options['rating']}";
		unset($options['default'], $options['size'], $options['rating']);

		return $this->_render(__METHOD__, 'gravatar_image', compact('url', 'options'));
	}

}

?>