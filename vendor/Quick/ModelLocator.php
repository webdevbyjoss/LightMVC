<?php

namespace Quick;

/**
 * Very simple model locator implementation
 * will allow us to instantiate and store objects instances for further use
 */
class ModelLocator {

	const M_DIR = 'model';
	protected $modelDir;
	protected $appNamespace;
	protected $models;
	protected $db;

	public function __construct($db, $appsDir, $appNamespace) {
		$this->modelDir = $appsDir . '/' . self::M_DIR;
		$this->appNamespace = $appNamespace;
		$this->db = $db;
	}

	/**
	 * Help to retrieve model classes
	 */
	public function __get($model) {
		// if model is not initialized - then crate an instance
		if (!isset($this->models[$model])) {
			require_once $this->modelDir . '/' . $model . '.php';
			$modelClass = $this->appNamespace . "\\" . $model;
			$this->models[$model] = new $modelClass($this->db);
		}

		return $this->models[$model];
	}
}