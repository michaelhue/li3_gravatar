<?php
/**
 * li3_gravatar plugin for Lithium: the most rad php framework.
 *
 * @copyright     Copyright 2011, Michael Hüneburg
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_gravatar\extensions\helper;

/**
 * This helper allows you to make Gravatar image requests.
 *
 * @link http://gravatar.com/site/implement/images/ Gravatar: Image requests
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
	 * Generates an URL to the Gravatar for `'$email'`.
	 *
	 * @param string $email
	 * @param array $options Optional options. Valid options are:
	 *     - `'default'`: Optional fallback image that will be provided if there is no Gravatar associated
	 *     with `'$email'`. This may be a full URL, an absolute path, `'mm'`, `'identicon'`,
	 *     `'monsterid'`, `'wavatar'`, `'retro'`, `'blank'` or `'404'`.
	 *     - `'size'`: Size of the image in pixels. Defaults to `'80'`.
	 *     - `'rating'`: Required minimum rating of the Gravatar. This may be `'g'`, `'pg'`, `'r'` or
	 *     `'x'`. If the Gravatar does not meet the rating the `'default'` option will be returned.
	 *     Defaults to `'g'`.
	 * @return string Returns an URL to the Gravatar image.
	 */
	public function url($email, array $options = array()) {
		$defaults = array('default' => null, 'size' => 80, 'rating' => 'g');
		$options += $defaults;

		$request = $this->_context->request();
		$defaultValues = array(null, 404, 'mm', 'identicon', 'monsterid', 'wavatar', 'retro', 'blank');
		$hash = md5(strtolower(trim($email)));

		if (!in_array($options['default'], $defaultValues) && strpos($options['default'], '://') === false) {
			$scheme = $request->env('HTTPS') ? 'https://' : 'http://';
			$host = $request->env('HTTP_HOST');
			$options['default'] = $scheme . $host . $options['default'];
		}

		if ($request->env('HTTPS')) {
			$base = 'https://secure.gravatar.com';
		} else {
			$base = 'http://gravatar.com';
		}
		$query = array(
			'd' => $options['default'],
			's' => $options['size'],
			'r' => $options['rating']
		);

		return "{$base}/avatar/{$hash}" . '?' . http_build_query($query);
	}

	/**
	 * Renders the Gravatar for `'$email'`.
	 *
	 * @see li3_gravatar\extensions\helper\Gravatar::url()
	 * @param string $email
	 * @param array $options Optional options.
	 * @return string Returns an image tag displaying the Gravatar.
	 */
	public function image($email, array $options = array()) {
		$defaults = array('default' => null, 'size' => 80, 'rating' => 'g', 'alt' => '');
		$options += $defaults;
		$url = $this->url($email, $options);
		unset($options['default'], $options['size'], $options['rating']);
		return $this->_render(__METHOD__, 'gravatar_image', compact('url', 'options'));
	}

}

?>