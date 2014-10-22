<?php

namespace MandrillMailer\Tests;

use MandrillMailer\Message;

class MessageTest extends \PHPUnit_Framework_TestCase {
	public function testSetTo() {
		$message = new Message();
		$message->setTo('chris.barr@ntlworld.com');

		$this->assertEquals(1, count($message->getRecipients()));

		$expected = array(
			array(
				'email' => 'chris.barr@ntlworld.com',
				'name' => '',
				'type' => 'to'
			)
		);
		$this->assertEquals($expected, $message->getRecipients());
	}
}
