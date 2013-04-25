<?php

namespace AdSerf;
use Quick\ActionControllerAbstract as ActionController;


class IndexController extends ActionController {

	/**
	 * Sample data
	 */
	private $data = array(
		'header' => 'some header',
		'value1' => 'some data 1',
		'value2' => 'some data 2',
		'value3' => 'some data 3',
		'value4' => 'some data 4',
		'iterable' => array('one', 'two', 'three')
	);

	/**
	 * output HTML with placeholders
	 */
	public function indexAction() {

		$data = $this->model->Ad->getInfo();
		$this->view->set($data);

	}

	/**
	 * output JSON
	 */
	public function ajaxAction() {

		return $this->data;

	}

	/**
	 * output any other custom string
	 */
	public function customAction() {

		$this->view->set($this->data);

		$output = $this->view->render('foo/bar');
		$this->responce->appendBody($output);

		$output2 = "<p>Some more text here</p>";
		$this->responce->appendBody($output2);

	}

	/**
	 * output any script body
	 */
	public function performAction() {
		$this->view->set(array(
			'' => '',
			'' => '',
		));

		$output = $this->view->render('index/script');
		$this->responce
			->addHeader('Content-Type', 'application/javascript')
			->appendBody($output);

	}

}