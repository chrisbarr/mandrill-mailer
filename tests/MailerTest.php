<?php

namespace MandrillMailer\Tests;

use MandrillMailer\Mailer;

class MailerTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @return \PHPUnit_Framework_MockObject_MockObject|\GuzzleHttp\Client
	 */
	protected function getMockClient() {
		return $this->getMockBuilder('GuzzleHttp\Client')
			->disableOriginalConstructor()
			->getMock();
	}

	/**
	 * @param array $config
	 * @return \PHPUnit_Framework_MockObject_MockObject
	 */
	protected function getMockMessage($config = array()) {
		$message = $this->getMock('MandrillMailer\Message');
		$message->expects($this->once())->method('getFrom')->will($this->returnValue($config['from']));
		$message->expects($this->once())->method('getHtml')->will($this->returnValue($config['html']));
		$message->expects($this->once())->method('getSubject')->will($this->returnValue($config['subject']));
		$message->expects($this->once())->method('getRecipients')->will($this->returnValue($config['recipients']));
		$message->expects($this->once())->method('getReplyTo')->will($this->returnValue($config['reply-to']));
		$message->expects($this->any())->method('getText')->will($this->returnValue($config['text']));
		return $message;
	}

	/**
	 * @return \PHPUnit_Framework_MockObject_MockObject
	 */
	protected function getMockResponse() {
		return $this->getMockForAbstractClass('GuzzleHttp\Message\ResponseInterface');
	}

	public function testGuzzleClient() {
		$client = $this->getMockClient();

		$mailer = new Mailer('1a2b3c');
		$mailer->setGuzzleClient($client);

		$this->assertSame($client, $mailer->getGuzzleClient());
	}

	public function testSend() {
		$messageConfig = array(
			'html' => '<h1>Hello world!</h1>',
			'subject' => 'Unit test subject',
			'from' => array('email' => 'chris.barr@ntlworld.com', 'name' => 'Chris Barr'),
			'recipients' => array(
				array('email' => 'to@example.com', 'name' => 'To', 'type' => 'to'),
				array('email' => 'cc@example.com', 'name' => 'CC', 'type' => 'cc')
			),
			'reply-to' => 'reply-to@example.com',
			'text' => 'Hello world!'
		);
		$expectedMessageParams = array(
			'key' => '1a2b3c',
			'message' => array(
				'html' => '<h1>Hello world!</h1>',
				'subject' => 'Unit test subject',
				'from_email' => 'chris.barr@ntlworld.com',
				'from_name' => 'Chris Barr',
				'to' => array(
					array('email' => 'to@example.com', 'name' => 'To', 'type' => 'to'),
					array('email' => 'cc@example.com', 'name' => 'CC', 'type' => 'cc')
				),
				'headers' => array(
					'Reply-To' => 'reply-to@example.com'
				),
				'text' => 'Hello world!'
			)
		);

		$message = $this->getMockMessage($messageConfig);

		$response = $this->getMockResponse();
		$response->expects($this->any())
			->method('getStatusCode')
			->will($this->returnValue(200));
		$response->expects($this->any())
			->method('json')
			->will($this->returnValue(array(
				array(
					'status' => 'sent'
				)
			)));

		$client = $this->getMockClient();
		$client->expects($this->once())
			->method('post')
			->with(
				$this->equalTo('messages/send.json'),
				$this->equalTo(array('json' => $expectedMessageParams))
			)
			->will($this->returnValue($response));

		$mailer = new Mailer('1a2b3c');
		$mailer->setGuzzleClient($client);

		$this->assertTrue($mailer->send($message));
	}

	public function testSend_BadStatusCode() {
		$this->setExpectedException('Exception', 'Returned 401 response code');

		$message = $this->getMockMessage();

		$response = $this->getMockResponse();
		$response->expects($this->any())
			->method('getStatusCode')
			->will($this->returnValue(401));
		$response->expects($this->never())
			->method('json');

		$client = $this->getMockClient();
		$client->expects($this->once())
			->method('post')
			->will($this->returnValue($response));

		$mailer = new Mailer('1a2b3c');
		$mailer->setGuzzleClient($client);

		$mailer->send($message);
	}

	public function testSend_MessageRejected() {
		$this->setExpectedException('Exception', 'Message was rejected - reason: invalid-sender');

		$message = $this->getMockMessage();

		$response = $this->getMockResponse();
		$response->expects($this->any())
			->method('getStatusCode')
			->will($this->returnValue(200));
		$response->expects($this->any())
			->method('json')
			->will($this->returnValue(array(
				array(
					'status' => 'rejected',
					'reject_reason' => 'invalid-sender'
				)
			)));

		$client = $this->getMockClient();
		$client->expects($this->once())
			->method('post')
			->will($this->returnValue($response));

		$mailer = new Mailer('1a2b3c');
		$mailer->setGuzzleClient($client);

		$mailer->send($message);
	}

	public function testSend_MessagesRejected() {
		$this->setExpectedException('Exception', 'Message was rejected - reason: invalid-sender');

		$message = $this->getMockMessage();

		$response = $this->getMockResponse();
		$response->expects($this->any())
			->method('getStatusCode')
			->will($this->returnValue(200));
		$response->expects($this->any())
			->method('json')
			->will($this->returnValue(array(
				array(
					'status' => 'sent'
				),
				array(
					'status' => 'rejected',
					'reject_reason' => 'invalid-sender'
				),
				array(
					'status' => 'sent'
				)
			)));

		$client = $this->getMockClient();
		$client->expects($this->once())
			->method('post')
			->will($this->returnValue($response));

		$mailer = new Mailer('1a2b3c');
		$mailer->setGuzzleClient($client);

		$mailer->send($message);
	}

	public function testGetGuzzleClient() {
		$mailer = new Mailer('1a2b3c');

		$client = $mailer->getGuzzleClient();
		$this->assertInstanceOf('GuzzleHttp\Client', $client);
	}
}