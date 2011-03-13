<?php

namespace li3_gravatar\tests\cases\models;

use li3_gravatar\tests\mocks\data\MockGravatarProfiles;

class GravatarProfilesTest extends \lithium\test\Unit {

	public function testHash() {
		$expected = '5b9c2b225b5c4ff91ffe849209153ecc';
		$result = MockGravatarProfiles::hash('mail@example.org');
		$this->assertEqual($expected, $result);
	
		$result = MockGravatarProfiles::hash('MAIL@EXAMPLE.ORG');
		$this->assertEqual($expected, $result);
		
		$result = MockGravatarProfiles::hash(' mail@example.org ');
		$this->assertEqual($expected, $result);
	}
	
	public function testFind() {
		$result = MockGravatarProfiles::find('invalid@example.org');
		$this->assertFalse($result);
	
		$result = MockGravatarProfiles::find('john@example.org');
		$this->assertTrue($result instanceof \lithium\data\Entity);
		$this->assertEqual('123', $result->id);
		$this->assertEqual('08aff750c4586c34375a0ebd987c1a7e', $result->hash);
	}

}

?>