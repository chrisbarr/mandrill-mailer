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

	public function testTo_Many() {
		$message = new Message();
		$message->setTo('user1@example.com');
		$message->setTo('user2@example.com', 'User Two');
		$message->setTo(array('user3@example.com'));
		$message->setTo(array('user4@example.com' => 'User Four'));

		$this->assertEquals(4, count($message->getRecipients()));

		$expected = array(
			array(
				'email' => 'user1@example.com',
				'name' => '',
				'type' => 'to'
			),
			array(
				'email' => 'user2@example.com',
				'name' => 'User Two',
				'type' => 'to'
			),
			array(
				'email' => 'user3@example.com',
				'name' => '',
				'type' => 'to'
			),
			array(
				'email' => 'user4@example.com',
				'name' => 'User Four',
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

	public function testRecipient() {
		$message = new Message();
		$message->setRecipient(array(
			'user1@example.com',
			'user2@example.com' => 'Test User'
		));

		$this->assertEquals(2, count($message->getRecipients()));

		$expected = array(
			array(
				'email' => 'user1@example.com',
				'name' => '',
				'type' => 'to'
			),
			array(
				'email' => 'user2@example.com',
				'name' => 'Test User',
				'type' => 'to'
			)
		);
		$this->assertEquals($expected, $message->getRecipients());
	}

	public function testRecipients() {
		$message = new Message();
		$message->setTo('to@example.com', 'Test User');
		$message->setCC('cc@example.com', 'Test User');
		$message->setBCC('bcc@example.com', 'Test User');

		$this->assertEquals(3, count($message->getRecipients()));

		$expected = array(
			array(
				'email' => 'to@example.com',
				'name' => 'Test User',
				'type' => 'to'
			),
			array(
				'email' => 'cc@example.com',
				'name' => 'Test User',
				'type' => 'cc'
			),
			array(
				'email' => 'bcc@example.com',
				'name' => 'Test User',
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
