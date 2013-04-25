<?php

namespace Quick;

/**
 * Framework core class
 * serves as single entry point for all requests to our web application
 *
 * it will lookup appropriate action controller inside /controller directory
 */
class FrontController {

	// app directories structure
	const V_DIR = 'views';
	const VL_DIR = 'layouts';
	const C_DIR = 'controller';
	const A_DIR = 'app';
	const L_DIR = 'vendor';

	// resources
	protected $conf;
	protected $db;

	// internal MVC objects
	protected $controller;
	protected $view;

	// objects to deal with client
	protected $request;
	protected $response;
	protected $router;

	// internal application configuration
	protected $rootDir;
	protected $appDir;
	protected $libDir;

	public function __construct($rootDir, $conf = null) {
		// init application directories structure
		$this->rootDir = $rootDir;
		$this->appDir = $rootDir . '/' . self::A_DIR;
		$this->libDir = $rootDir . '/' . self::L_DIR;

		$this->conf = $conf;
	}

	/**
	 * Core method in this framework
	 *
	 * Consists from the following steps:
	 *
	 * 1. init request/response and other objects used in dispach
	 * 2. init controller
	 * 3. run action
	 * 4. render 2 step view (optional)
	 *
	 * @param string $rootDir
	 * @param array $conf
	 */
	public function run($request, $response) {

		// init routing
		$this->request = $request;
		$this->response = $response;
		$this->router = new Router($request);

		// initialize database abstraction layer
		$this->db = Db::initDb($this->libDir, $this->conf['db']);

		// init view
		$templatesDir = $this->appDir . '/' . self::V_DIR;
		$layoutDir = $this->appDir . '/' . self::VL_DIR;
		$this->view = new View($templatesDir, $layoutDir);
		$this->view->setDefaultTemplate($this->router->controller . '/' . $this->router->action); // views/[controller]/[action].phtml

		// load controller
		$controllerName = ucfirst($this->router->controller) . 'Controller';
		$controllerFile = $this->appDir . '/' . self::C_DIR . '/' . $controllerName . '.php';
		if (!is_readable($controllerFile)) {
			return $this->hadnle404Error('Make sure "' . $this->router->controller . '" controller exists.');
		}
		require_once $controllerFile;
		$controllerClassName = $this->conf['appNamespace'] . '\\' . $controllerName;
		$controller = new $controllerClassName($this->request, $this->response);
		$controller->setView($this->view);
		$controller->setDb($this->db);
		$controller->setRouter($this->router);
		$controller->setModelLocator(new ModelLocator($this->db, $this->appDir, $this->conf['appNamespace']));

		// run controller action, simple naming convention: "indexAction", "infoAction", etc
		$action = $this->router->action . 'Action';
		if (!is_callable(array($controller, $action))) {
			return $this->hadnle404Error('Make sure "' . $action . '" action in "' . $this->router->controller . '" controller exists.');
		}
		try {
			$jsondata = $controller->$action();
		} catch (Exception $e) {
			return $this->handle502Error($e->getMessage());
		}

		// check if we need to perform redirect
		if ($this->response->isRedirect()) {
			$this->response->sendToClient();
		}

		// exit as user handled output rendering on its own
		if (!$this->view->autorender) {
			return $this->response->sendToClient();
		}

		// output JSON if user returned such structure
		if (!empty($jsondata)) {
			return $this->response->addHeader('Content-Type', 'application/json')
						   ->appendBody(json_encode($jsondata))
						   ->sendToClient();
		}

		// build response body from template
		try {
			$body = $this->view->render();
		} catch (Exception $e) {
			return $this->handle502Error($e->getMessage());
		}
		$this->response->appendBody($body)
					   ->sendToClient();
	}

	/**
	 * Handle error pages
	 *
	 * @param string $message
	 */
	protected function hadnle404Error($message) {
		$this->response->statusCode(Http\Response::STATUS_NOT_FOUND)
			 ->appendBody('Not found. ' . $message)
			 ->sendToClient(); // TODO: render fancy template here
	}

	protected function handle502Error($message) {
		$this->response->statusCode(Http\Response::INTERNAL_SERVER_ERROR)
			 ->appendBody('Application Error. ' . $message)
			 ->sendToClient(); // TODO: render fancy template here
	}
}