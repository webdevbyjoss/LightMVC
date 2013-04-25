<?php

namespace AdSerf;

use Quick\Model as Model;

class Ad extends Model {

	/**
	 * Sample data
	 */
	protected $data = array(
		'header' => 'some header',
		'value1' => 'some data 1',
		'value2' => 'some data 2',
		'value3' => 'some data 3',
		'value4' => 'some data 4',
		'iterable' => array('one', 'two', 'three')
	);

	/**
	 * Dummy example method
	 */
	public function getInfo() {
		return $this->data;
	}
}