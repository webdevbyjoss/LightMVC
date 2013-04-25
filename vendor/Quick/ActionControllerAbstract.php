<?php

namespace Quick;

/**
 * Extend all your action controllers from this class
 *
 * this class covers access to view/models/request/responce objects
 */
abstract class ActionControllerAbstract {

	protected $request;
	protected $responce;
	protected $router;
	protected $view;
	protected $db;
	protected $model;

	public function __construct($request, $responce) {
		$this->request = $request;
		$this->responce = $responce;
	}

	public function setView($view) {
		$this->view = $view;
	}

	public function setRouter($router) {
		$this->router = $router;
	}

	public function setDb($db) {
		$this->db = $db;
	}

	public function setModelLocator($ml) {
		$this->model = $ml;
	}
}