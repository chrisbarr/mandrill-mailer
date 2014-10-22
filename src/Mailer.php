<?php

namespace MandrillMailer;

use GuzzleHttp;

class Mailer {
	/** @var string */
	private $apiKey;

	/** @var GuzzleHttp\Client */
	private $guzzle;

	/**
	 * @param string $apiKey Your Mandrill API Key
	 */
	public function __construct($apiKey) {
		$this->apiKey = $apiKey;

		$this->guzzle = new GuzzleHttp\Client(array(
			'base_url' => 'https://mandrillapp.com/api/1.0/'
		));
	}

	/**
	 * Send a Message
	 *
	 * @param Message $message
	 * @return bool
	 * @throws \Exception
	 */
	public function send(Message $message) {
		$endpoint = 'messages/send.json';

		/** @var \GuzzleHttp\Message\ResponseInterface $response */
		$response = $this->guzzle->post($endpoint, array(
			'json' => $this->getMessageArray($message)
		));

		if($response->getStatusCode() != 200) {
			throw new \Exception(sprintf('Returned %d response code', $response->getStatusCode()));
		}

		$results = $response->json();
		foreach($results as $result) {
			if($result['status'] != 'sent') {
				throw new \Exception(sprintf('Message was %s - reason: %s', $result['status'], $result['reject_reason']));
			}
		}

		return true;
	}

	/**
	 * Get the structured array required for Mandrill messages
	 *
	 * @param Message $message
	 * @return string
	 */
	protected function getMessageArray(Message $message) {
		$from = $message->getFrom();

		$array = array(
			'key' => $this->apiKey,
			'message' => array(
				'html' => $message->getHtml(),
				'subject' => $message->getSubject(),
				'from_email' => $from['email'] ? : null,
				'from_name' => $from['name'] ? : null,
				'to' => $message->getRecipients(),
				'headers' => array(
					'Reply-To' => $message->getReplyTo()
				)
			)
		);

		if(!is_null($message->getText())) {
			$array['message']['text'] = $message->getText();
		}

		return $array;
	}
}