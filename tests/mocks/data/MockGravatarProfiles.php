<?php
/**
 * li3_gravatar plugin for Lithium: the most rad php framework.
 *
 * @copyright     Copyright 2011, Michael Hüneburg
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace li3_gravatar\tests\mocks\data;

class MockGravatarProfiles extends \li3_gravatar\models\GravatarProfiles {

	protected static function _request($hash) {
		switch ($hash) {
			case 'bbb485e1b6d0fd450d2fcd117276894f':
				return serialize('User not found');
			break;
			case '08aff750c4586c34375a0ebd987c1a7e';
				return serialize(array('entry' => array(0 => array (
					'id' => '123',
					'hash' => '08aff750c4586c34375a0ebd987c1a7e',
					'requestHash' => '08aff750c4586c34375a0ebd987c1a7e',
					'profileUrl' => 'http://gravatar.com/john',
					'preferredUsername' => 'john',
					'thumbnailUrl' => 'http://0.gravatar.com/avatar/08aff750c4586c34375a0ebd987c1a7e',
					'photos' => array(
				        array(
				          'value' => 'http://0.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50',
				          'type' => 'thumbnail',
				        ),
				        array('value' => 'http://0.gravatar.com/userimage/123/75ad2fafd20dd9302f42b0a02d51e860'),
						array('value' => 'http://0.gravatar.com/userimage/123/9564d785bb3d64c03d26b2de426c4312')
					),
					'profileBackground' => array(
						'color' => '#274f3d', 'position' => 'center', 'repeat' => 'repeat',
						'url' => 'http://0.gravatar.com/bg/123/5859934a6ddce88c19ce6c967f67f773',
					),
					'name' => array(
						'givenName' => 'John', 'familyName' => 'Doe', 'formatted' => 'John Doe'
					),
					'displayName' => 'John Doe',
					'aboutMe' => 'This is me. Old Johnny Boy.',
					'currentLocation' => 'San Francisco, CA 94109, USA',
					'phoneNumbers' => array(
				        array ('type' => 'mobile', 'value' => '123456789')
					),
					'emails' => array(
						array ('primary' => 'true', 'value' => 'john@example.org')
					),
					'ims' => array(
				        array('type' => 'aim', 'value' => 'johndoe'),
				        array('type' => 'skype', 'value' => 'johndoe')
					),
					'accounts' => array(
				        array(
							'domain' => 'facebook.com',
							'display' => 'johndoe',
							'url' => 'http://www.facebook.com/johndoe',
							'username' => 'johndoe',
							'verified' => 'true',
							'shortname' => 'facebook',
				        ),
				        array(
							'domain' => 'twitter.com',
							'display' => '@johndoe',
							'url' => 'http://twitter.com/johndoe',
							'username' => 'johndoe',
							'verified' => 'true',
							'shortname' => 'twitter',
				        )
					),
					'urls' => array(
				        array('value' => 'http://wordpress.com', 'title' => 'WordPress.com'),
				        array('value' => 'http://gravatar.com', 'title' => 'Gravatar')
					),
				))));
			break;
		}
		return false;
	}

}

?>