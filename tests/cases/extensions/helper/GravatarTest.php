<?php
/**
 * li3_gravatar plugin for Lithium: the most rad php framework.
 *
 * @copyright     Copyright 2010, Michael Hüneburg
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_gravatar\tests\cases\extensions\helper;

use \li3_gravatar\extensions\helper\Gravatar;
use \lithium\tests\mocks\template\helper\MockHtmlRenderer;

class GravatarTest extends \lithium\test\Unit {
	
	public $helper = null;
	
	public function setUp() {
		$this->context = new MockHtmlRenderer();
		$this->helper = new Gravatar(array('context' => &$this->context));
	}
	
	public function testImageWithoutOptions() {
		$expected = '<img src="http://gravatar.com/avatar/5b9c2b225b5c4ff91ffe849209153ecc?d=404&s=80&r=g" alt="" />';
		$result = $this->helper->image('mail@example.org');
		$this->assertEqual($expected, $result);
		
		$result = $this->helper->image('MAIL@EXAMPLE.ORG');
		$this->assertEqual($expected, $result);
	}
	
	public function testImageWithOptions() {
		$expected = '<img src="http://gravatar.com/avatar/5b9c2b225b5c4ff91ffe849209153ecc?d=404&s=40&r=g" alt="" />';
		$result = $this->helper->image('mail@example.org', array('size' => 40));
		$this->assertEqual($expected, $result);
		
		$expected = '<img src="http://gravatar.com/avatar/5b9c2b225b5c4ff91ffe849209153ecc?d=identicon&s=80&r=g" alt="" />';
		$result = $this->helper->image('mail@example.org', array('default' => 'identicon'));
		$this->assertEqual($expected, $result);
		
		$expected = '<img src="http://gravatar.com/avatar/5b9c2b225b5c4ff91ffe849209153ecc?d=http%3A%2F%2Fexample.org%2Fdefault.jpg&s=80&r=g" alt="" />';
		$result = $this->helper->image('mail@example.org', array('default' => 'http://example.org/default.jpg'));
		$this->assertEqual($expected, $result);
		
		$expected = '<img src="http://gravatar.com/avatar/5b9c2b225b5c4ff91ffe849209153ecc?d=404&s=80&r=g" alt="Gravatar" class="gravatar" />';
		$result = $this->helper->image('mail@example.org', array('alt' => 'Gravatar', 'class' => 'gravatar'));
		$this->assertEqual($expected, $result);
	}
	
}

?>