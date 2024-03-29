<?php

namespace Quick;

/**
 * Dummy model class
 */
class Model implements \ArrayAccess {

	protected $db;
	protected $container = array();

	public function __construct($db) {
		$this->db = $db;
	}

	public function offsetSet($offset, $value) {
		if (is_null($offset)) {
			$this->container[] = $value;
		} else {
			$this->container[$offset] = $value;
		}
	}

	public function offsetExists($offset) {
		return isset($this->container[$offset]);
	}

	public function offsetUnset($offset) {
		unset($this->container[$offset]);
	}

	public function offsetGet($offset) {
		return isset($this->container[$offset]) ? $this->container[$offset] : null;
	}
}