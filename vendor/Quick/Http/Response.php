<?php

namespace Quick\Http;

class Response {

	const STATUS_NOT_FOUND = 404;
	const STATUS_ACCESS_DENIED = 403;
	const INTERNAL_SERVER_ERROR = 502;

	protected $headers = null;
	protected $body = '';
	protected $status = null; // we will not touch HTTP statuses by defaut
	protected $doRedirect = false;

	public function __construct() {
		// TODO: set some initial headers
	}

	/**
	 * Add header to responce
	 * @param name $header
	 * @param value $value
	 */
	public function addHeader($header, $value) {
		$this->headers[$header] = $value;
		return $this;
	}

	/**
	 * Add body content to existant responce
	 * @param string $text
	 */
	public function appendBody($text) {
		$this->body .= $text;
		return $this;
	}

	public function statusCode($status) {
		// TODO: do some validation
		$this->status = $status;
		return $this;
	}

	public function sendToClient() {
		// set the custom status if available
		if (null !== $this->status) {
			header(' ', true, $this->status);
		}

		// output headers
		if (!empty($this->headers)) {
			foreach ($this->headers as $header => $value) {
				header("$header: $value");
			}
		}

		// output body
		if (!$this->doRedirect) {
			echo $this->body;
		}
	}

	/**
	 * Redirect user to URI or external URL
	 *
	 * @param string $url
	 */
	public function redirect($url) {
		$this->doRedirect = true;
		$this->addHeader('Location', $url);
	}

	/**
	 * Returns true if action controller requires to perform redirect
	 */
	public function isRedirect() {
		return $this->doRedirect;
	}
}