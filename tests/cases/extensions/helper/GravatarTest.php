<?php
/**
 * li3_gravatar plugin for Lithium: the most rad php framework.
 *
 * @copyright     Copyright 2010, Michael Hüneburg
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_gravatar\tests\cases\extensions\helper;

use \li3_gravatar\extensions\helper\Gravatar;
use \lithium\tests\mocks\action\MockControllerRequest;
use \lithium\tests\mocks\template\helper\MockHtmlRenderer;

class GravatarTest extends \lithium\test\Unit {
	
	public $helper = null;
	
	public function setUp() {
		$this->request = new MockControllerRequest();
		$this->context = new MockHtmlRenderer(array('request' => $this->request));
		$this->helper = new Gravatar(array('context' => &$this->context));
	}
	
	public function testImageWithoutOptions() {
		$result = $this->helper->image('mail@example.org');
		$expected = array('img' => array(
			'src' => 'http://gravatar.com/avatar/5b9c2b225b5c4ff91ffe849209153ecc?d=404&s=80&r=g', 'alt' => ''
		));
		$this->assertTags($result, $expected);
		
		$result = $this->helper->image('MAIL@EXAMPLE.ORG');
		$this->assertTags($result, $expected);
	}
	
	public function testImageWithOptions() {
		$result = $this->helper->image('mail@example.org', array('size' => 40));
		$expected = array('img' => array(
			'src' => 'http://gravatar.com/avatar/5b9c2b225b5c4ff91ffe849209153ecc?d=404&s=40&r=g', 'alt' => ''
		));
		$this->assertTags($result, $expected);
		
		$result = $this->helper->image('mail@example.org', array('default' => 'identicon'));
		$expected = array('img' => array(
			'src' => 'http://gravatar.com/avatar/5b9c2b225b5c4ff91ffe849209153ecc?d=identicon&s=80&r=g', 'alt' => ''
		));
		$this->assertTags($result, $expected);
		
		$result = $this->helper->image('mail@example.org', array('default' => 'http://example.org/default.jpg'));
		$expected = array('img' => array(
			'src' => 'http://gravatar.com/avatar/5b9c2b225b5c4ff91ffe849209153ecc?d=http%3A%2F%2Fexample.org%2Fdefault.jpg&s=80&r=g', 
			'alt' => ''
		));
		$this->assertTags($result, $expected);
		
		$host = $this->request->env('HTTP_HOST');
		$scheme = $this->request->env('HTTPS') ? 'https://' : 'http://';
		$default = urlencode("{$scheme}{$host}/default.jpg");
		
		$result = $this->helper->image('mail@example.org', array('default' => '/default.jpg'));
		$expected = array('img' => array(
			'src' => "http://gravatar.com/avatar/5b9c2b225b5c4ff91ffe849209153ecc?d={$default}&s=80&r=g", 'alt' => ''
		));
		$this->assertTags($result, $expected);
		
		$result = $this->helper->image('mail@example.org', array('alt' => 'Gravatar', 'class' => 'gravatar'));
		$expected = array('img' => array(
			'src' => 'http://gravatar.com/avatar/5b9c2b225b5c4ff91ffe849209153ecc?d=404&s=80&r=g', 
			'alt' => 'Gravatar', 'class' => 'gravatar'
		));
		$this->assertTags($result, $expected);
	}
	
}

?>