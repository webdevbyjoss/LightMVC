<?php

namespace Quick;

/**
 * Very simle class autoloader we've created for our small framework
 */
class Autoloader {

	protected $libDir;

	public function __construct($libDir)
	{
		$this->libDir = $libDir;
	}

	/**
	 * Register our own autoloader with spl autoload function
	 */
	public function register()
	{
		spl_autoload_register(array($this, 'autoload'));
	}

	/**
	 * PSR-0 compatible autoloader
	 * Performs conversion from namespaced\class\name to actual/class/location in filesystem
	 *
	 * @param string $class
	 */
	public function autoload($class)
	{
		require_once $this->libDir . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
	}
}