<?php


namespace app\core;

/**
 * Class Controller
 *
 * Our base controller class
 *
 * @package app\core
 */
class Controller
{
    public string $layout = 'main';

    public function setLayout(string $layout)
    {
        $this->layout = $layout;
    }

    /**
     * We render the base view with params
     *
     * @param string $view
     * @param array $params
     * @return string|string[]
     */
    public function render($view, $params = [])
    {
        return Application::$app->router->renderView($view, $params);
    }
}