<?php

namespace MandrillMailer\Tests;

use MandrillMailer\Message;

class MessageTest extends \PHPUnit_Framework_TestCase {
	public function testTo() {
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

	public function testCC() {
		$message = new Message();
		$message->setCC('chris.barr@ntlworld.com');

		$this->assertEquals(1, count($message->getRecipients()));

		$expected = array(
			array(
				'email' => 'chris.barr@ntlworld.com',
				'name' => '',
				'type' => 'cc'
			)
		);
		$this->assertEquals($expected, $message->getRecipients());
	}

	public function testBCC() {
		$message = new Message();
		$message->setBCC('chris.barr@ntlworld.com');

		$this->assertEquals(1, count($message->getRecipients()));

		$expected = array(
			array(
				'email' => 'chris.barr@ntlworld.com',
				'name' => '',
				'type' => 'bcc'
			)
		);
		$this->assertEquals($expected, $message->getRecipients());
	}

	public function testFrom() {
		$message = new Message();
		$message->setFrom('chris.barr@ntlworld.com', 'Chris Barr');

		$expected = array(
			'email' => 'chris.barr@ntlworld.com',
			'name' => 'Chris Barr'
		);
		$this->assertEquals($expected, $message->getFrom());
	}

	public function testSubject() {
		$message = new Message();
		$message->setSubject('Welcome to the Jungle');

		$this->assertEquals('Welcome to the Jungle', $message->getSubject());
	}

	public function testReplyTo() {
		$message = new Message();
		$message->setReplyTo('chris.barr@ntlworld.com');

		$this->assertEquals('chris.barr@ntlworld.com', $message->getReplyTo());
	}

	public function testHtml() {
		$message = new Message();
		$message->setHtml('<h1>Hello world!</h1>');

		$this->assertEquals('<h1>Hello world!</h1>', $message->getHtml());
	}

	public function testText() {
		$message = new Message();
		$message->setText('Hello world!');

		$this->assertEquals('Hello world!', $message->getText());
	}
}
