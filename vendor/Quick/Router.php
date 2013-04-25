<?php

namespace Quick;

/**
 * This class will utilize very simple routing strategy
 *
 * http://mydomain.com/[base path]/[controller]/[action]/[[key]/[value]]/[[key]/[value]]...
 *
 * TODO: add ability to parse regular params like "param1=value1&param2=value2..."
 */
class Router {

	const SEPARATOR = '/';

	public $controller;
	public $action;
	public $params;

	public function __construct($request) {

		// create a local working copy of URI
		$uri = explode(self::SEPARATOR, $request->getUri());

		array_shift($uri); // drop trailing slash in URI

		$this->controller = array_shift($uri) ?: 'index';
		$this->action = array_shift($uri) ?: 'index';

		while ($key = array_shift($uri)) {
			// TODO: make sure we will not have issues here when value is not passed
			$value = array_shift($uri);
			$this->params[$key] = urldecode($value);
		}
	}

}