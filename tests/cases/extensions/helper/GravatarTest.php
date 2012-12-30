<?php
/**
 * li3_gravatar plugin for Lithium: the most rad php framework.
 *
 * @copyright     Copyright 2011, Michael Hüneburg
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_gravatar\tests\cases\extensions\helper;

use li3_gravatar\extensions\helper\Gravatar;
use lithium\tests\mocks\action\MockControllerRequest;
use lithium\tests\mocks\template\helper\MockHtmlRenderer;

class GravatarTest extends \lithium\test\Unit {

	public function setUp() {
		$_ENV['HTTPS'] = 'off';
		$this->request = new MockControllerRequest();
		$this->context = new MockHtmlRenderer(array('request' => $this->request));
		$this->helper = new Gravatar(array('context' => &$this->context));
	}

	public function testUrlWithoutOptions() {
		$expected = 'http://gravatar.com/avatar/08aff750c4586c34375a0ebd987c1a7e?s=80&r=g';
		$result = $this->helper->url('john@example.org');
		$this->assertEqual($expected, $result);

		$expected = 'http://gravatar.com/avatar/978a05c7e2e60f547991b0ee47876553?s=80&r=g';
		$result = $this->helper->url('george@example.org');
		$this->assertEqual($expected, $result);

		$result = $this->helper->url('GEORGE@EXAMPLE.ORG');
		$this->assertEqual($expected, $result);

		$result = $this->helper->url(' george@example.org ');
		$this->assertEqual($expected, $result);
	}

	public function testUrlSslWithoutOptions() {
		$_ENV['HTTPS'] = 'on';
		$this->request = new MockControllerRequest();
		$this->context = new MockHtmlRenderer(array('request' => $this->request));
		$this->helper = new Gravatar(array('context' => &$this->context));

		$expected = 'https://secure.gravatar.com/avatar/08aff750c4586c34375a0ebd987c1a7e?s=80&r=g';
		$result = $this->helper->url('john@example.org');
		$this->assertEqual($expected, $result);

		$expected = 'https://secure.gravatar.com/avatar/978a05c7e2e60f547991b0ee47876553?s=80&r=g';
		$result = $this->helper->url('george@example.org');
		$this->assertEqual($expected, $result);
	}

	public function testUrlWithSize() {
		$expected = 'http://gravatar.com/avatar/08aff750c4586c34375a0ebd987c1a7e?s=40&r=g';
		$result = $this->helper->url('john@example.org', array('size' => 40));
		$this->assertEqual($expected, $result);
	}

	public function testUrlWithDefault() {
		$expected = 'http://gravatar.com/avatar/08aff750c4586c34375a0ebd987c1a7e?d=404&s=80&r=g';
		$result = $this->helper->url('john@example.org', array('default' => 404));
		$this->assertEqual($expected, $result);

		$expected = 'http://gravatar.com/avatar/08aff750c4586c34375a0ebd987c1a7e?d=mm&s=80&r=g';
		$result = $this->helper->url('john@example.org', array('default' => 'mm'));
		$this->assertEqual($expected, $result);

		$expected = 'http://gravatar.com/avatar/08aff750c4586c34375a0ebd987c1a7e?d=identicon&s=80&r=g';
		$result = $this->helper->url('john@example.org', array('default' => 'identicon'));
		$this->assertEqual($expected, $result);

		$expected = 'http://gravatar.com/avatar/08aff750c4586c34375a0ebd987c1a7e?d=monsterid&s=80&r=g';
		$result = $this->helper->url('john@example.org', array('default' => 'monsterid'));
		$this->assertEqual($expected, $result);

		$expected = 'http://gravatar.com/avatar/08aff750c4586c34375a0ebd987c1a7e?d=wavatar&s=80&r=g';
		$result = $this->helper->url('john@example.org', array('default' => 'wavatar'));
		$this->assertEqual($expected, $result);

		$expected = 'http://gravatar.com/avatar/08aff750c4586c34375a0ebd987c1a7e?d=retro&s=80&r=g';
		$result = $this->helper->url('john@example.org', array('default' => 'retro'));
		$this->assertEqual($expected, $result);

		$expected = 'http://gravatar.com/avatar/08aff750c4586c34375a0ebd987c1a7e?d=blank&s=80&r=g';
		$result = $this->helper->url('john@example.org', array('default' => 'blank'));
		$this->assertEqual($expected, $result);

		$expected = 'http://gravatar.com/avatar/08aff750c4586c34375a0ebd987c1a7e?d=http%3A%2F%2Fexample.org%2Favatar.png&s=80&r=g';
		$result = $this->helper->url('john@example.org', array('default' => 'http://example.org/avatar.png'));
		$this->assertEqual($expected, $result);

		$host = $this->request->env('HTTP_HOST');
		$scheme = $this->request->env('HTTPS') ? 'https://' : 'http://';
		$default = urlencode("{$scheme}{$host}/img/avatar.png");

		$expected = "http://gravatar.com/avatar/08aff750c4586c34375a0ebd987c1a7e?d={$default}&s=80&r=g";
		$result = $this->helper->url('john@example.org', array('default' => '/img/avatar.png'));
		$this->assertEqual($expected, $result);
	}

	public function testUrlWithRating() {
		$expected = 'http://gravatar.com/avatar/08aff750c4586c34375a0ebd987c1a7e?s=80&r=x';
		$result = $this->helper->url('john@example.org', array('rating' => 'x'));
		$this->assertEqual($expected, $result);

		$expected = 'http://gravatar.com/avatar/08aff750c4586c34375a0ebd987c1a7e?s=80&r=pg';
		$result = $this->helper->url('john@example.org', array('rating' => 'pg'));
		$this->assertEqual($expected, $result);
	}

	public function testImageWithoutAttributes() {
		$result = $this->helper->image('mail@example.org');
		$expected = array('img' => array(
			'src' => 'http://gravatar.com/avatar/5b9c2b225b5c4ff91ffe849209153ecc?s=80&r=g', 'alt' => ''
		));
		$this->assertTags($result, $expected);
	}

	public function testImageWithAttributes() {
		$result = $this->helper->image('mail@example.org', array('alt' => 'Gravatar', 'class' => 'gravatar'));
		$expected = array('img' => array(
			'src' => 'http://gravatar.com/avatar/5b9c2b225b5c4ff91ffe849209153ecc?s=80&r=g',
			'alt' => 'Gravatar', 'class' => 'gravatar'
		));
		$this->assertTags($result, $expected);
	}
}

?>