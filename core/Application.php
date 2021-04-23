<?php


namespace app\core;

/**
 * Class Application
 *
 * This is main application
 *
 * @package app\core
 */
class Application
{
    /**
     * Instance of Router class
     * We will need routing in all our application. So we will have it as a property;
     * @var Router
     */
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;
    public Controller $controller;
    public Session $session;
    public Database $db;

    public function __construct($rootPath, $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->session = new Session();

        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
    }

    public function run()
    {
        echo $this->router->resolve();
    }

    /**
     * Returns controller
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * Sets controller
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }
}