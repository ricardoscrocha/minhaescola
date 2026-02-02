<?php

namespace MF\Controller;

abstract class Action
{

	protected $view;

	public function __construct()
	{
		$this->view = new \stdClass();
	}

	protected function render($view, $layout , $directory = '')
	{
		$this->view->page = $view;
		$this->view->directory = $directory;

		$viewPath = dirname(__DIR__, 2) . "/App/Views/layouts/" . $layout . ".php";

		if (file_exists($viewPath)) {
			require_once $viewPath;
		} else {
			$this->content();
		}
	}

	protected function content()
	{
		$class = explode('\\', get_class($this));
		$control = preg_split('/(?=[A-Z])/', $class[2]);
		$directory = $this->view->directory != '' ? $this->view->directory : lcfirst($control[1]);

		$viewPath = dirname(__DIR__, 2) . "/App/Views/" . $directory . "/" . $this->view->page . '.php';

		require_once $viewPath;
	}
}
