<?php

namespace Quick;

/**
 * Simple PHP tempalating engine
 */
class View {

	protected $templatesDir;
	protected $layoutDir;
	protected $template;
	protected $renderer;
	protected $values = array();

	/**
	 * This flag will determine whether we will render template automatically on final stage of dispatch process
	 */
	public $autorender = true;

	/**
	 * Initialize templating engine
	 *
	 * @param string $libDir library location
	 * @param string $tmpDir directory where compiled files and cache are storred
	 */
	public function __construct($templatesDir, $layoutDir = null) {
		$this->templatesDir = $templatesDir;
		$this->layoutDir = $layoutDir;
	}

	/**
	 * Set template variable
	 *
	 * @param string $name
	 * @param string $value
	 */
	public function __set($name, $value) {
		$this->values[$name] = $value;
	}

	/**
	 * Set template variables
	 *
	 * @param string $variables array
	 */
	public function set($variables) {
		$this->values = array_merge($this->values, $variables);
	}

	/**
	 * Sets the default template in [controller]/[action] format
	 *
	 * @param string $template
	 */
	public function setDefaultTemplate($template) {
		$this->template = $template;
	}

	/**
	 * Render template and return it as a string
	 * If no template specified - then default [controller]/[action] approach will be used
	 *
	 * @param string $template value to locale template in templates directory, like "user/login"
	 */
	public function render($template = null, $layout = null) {
		// use default template if nothing was passed
		if (null === $template) {
			$template = $this->template;
		}

		// use default template if nothing was passed
		if (null === $template) {
			$template = $this->template;
		}

		// check template for existance app-namespace/views/[controller]/[action].phtml
		$templateFile = $this->templatesDir . '/' . $template . '.phtml';
		if (!is_readable($templateFile)) {
			throw new \Exception('Make sure "' . $template . '.phtml" template exists.');
		}

		// turn off auto render
		$this->autorender = false;

		// render template
		return $this->_render($templateFile, $this->values);

		// TODO: Add Two step view
		// $this->layoutDir;
	}

	// lightweight templatiser based on default PHP templating
	protected function _render($template, $values) {
		extract($values, EXTR_SKIP && EXTR_REFS);
		ob_start();
		include $template;
		return ob_get_clean();
	}
}