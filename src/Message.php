<?php

namespace MandrillMailer;

class Message {
	/** @var array */
	private $recipients = array();

	/** @var array */
	private $from = array();

	/** @var string */
	private $subject = '';

	/** @var null|string */
	private $replyTo = null;

	/** @var string */
	private $html = '';

	/** @var null|string */
	private $text = null;

	/**
	 * @param string|array $to
	 * @param null|string $name
	 */
	public function setTo($to, $name = null) {
		$this->setRecipient($to, $name, 'to');
	}

	/**
	 * @param string|array $to
	 * @param null|string $name
	 */
	public function setCC($to, $name = null) {
		$this->setRecipient($to, $name, 'cc');
	}

	/**
	 * @param string|array $to
	 * @param null|string $name
	 */
	public function setBCC($to, $name = null) {
		$this->setRecipient($to, $name, 'bcc');
	}

	/**
	 * @param string|array $to
	 * @param null|string $name
	 * @param string $type
	 */
	public function setRecipient($to, $name = null, $type = 'to') {
		if(is_array($to)) {
			foreach($to as $k => $v) {
				if(is_numeric($k)) {
					$this->setTo($v, '', $type);
				}
				else {
					$this->setTo($k, $v, $type);
				}
			}
			return;
		}

		$this->recipients[] = array(
			'email' => $to,
			'name' => $name,
			'type' => $type
		);
	}

	/**
	 * @return array
	 */
	public function getRecipients() {
		return $this->recipients;
	}

	/**
	 * @param string $email
	 * @param null|string $name
	 */
	public function setFrom($email, $name = null){
		$this->from = array(
			'email' => $email,
			'name' => $name
		);
	}

	/**
	 * @return array
	 */
	public function getFrom() {
		return $this->from;
	}

	/**
	 * @param string $subject
	 */
	public function setSubject($subject = '') {
		$this->subject = $subject;
	}

	/**
	 * @return string
	 */
	public function getSubject() {
		return $this->subject;
	}

	/**
	 * @param null|string $replyTo
	 */
	public function setReplyTo($replyTo = null) {
		$this->replyTo = $replyTo;
	}

	/**
	 * @return null|string
	 */
	public function getReplyTo() {
		return $this->replyTo;
	}

	/**
	 * @param string $html
	 */
	public function setHtml($html = '') {
		$this->html = $html;
	}

	/**
	 * @return string
	 */
	public function getHtml() {
		return $this->html;
	}

	/**
	 * @param string|null $text
	 */
	public function setText($text = null) {
		$this->text = $text;
	}

	/**
	 * @return null|string
	 */
	public function getText() {
		return $this->text;
	}
}