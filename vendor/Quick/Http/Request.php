<?php

namespace Quick\Http;

class Request {

	const AUTO_INIT = true;

	// lets do these variables public
	// so that we can changes them later
	protected $uri;
	protected $method;
	protected $get;
	protected $post;
	protected $cookies;
	protected $request;

	public function __construct($autoInit = false) {
		// allow automatic initialization from globals
		if ($autoInit) {
			$this->initFromGlobals();
		}
	}

	/**
	 * Read the request state from globals
	 */
	public function initFromGlobals() {
		$this->method = $_SERVER['REQUEST_METHOD'];
		$this->get = $_GET;
		$this->post = $_POST;
		$this->cookies = $_COOKIE;
		$this->request = $_REQUEST;

		// in order to have ability to run the framework in sub-directory
		// lets turn URI "subdir/anothersub/controler/action" into "/controler/action"
		$this->uri = str_replace(dirname($_SERVER['SCRIPT_NAME']), '', $_SERVER['REQUEST_URI']);
	}

	/**
	 * Usable and simple interface for request variables
	 */
	public function __get($name) {
		if (isset($this->request[$name])) {
			return $this->request[$name];
		}
	}

	/**
	 * Setters and getters for HTTP URI and HTTP METHOD
	 */
	public function getUri() {
		return $this->uri;
	}

	public function getMethod() {
		return $this->method;
	}

	/**
	 * Returns true if form was submited
	 */
	public function isPost() {
		if ($this->method == 'POST') {
			return true;
		}
		return false;
	}
}