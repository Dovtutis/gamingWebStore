<?php


namespace app\core;

/**
 * Class Request which will handle our requests, request methods and redirects.
 * @package app\core
 */

class Request
{
    /**
     * Gets user requested page in string format from $_SERVER URI
     *
     * [REQUEST_URI] => /final/item?id=1
     * extracts /item
     *
     * @return string
     */
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';

        $questionPosition = strpos($path, '?');
        if ($questionPosition !== false) :
            $path = substr($path, 0, $questionPosition);
        endif;

        if (strlen($path) > 1) :
            $path = rtrim($path, '/');
        endif;

        return $path;
    }

    /**
     * Returns http request method - GET or POST
     *
     * @return string
     */
    public function method(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Returns true if server method is GET
     *
     * @return bool
     */
    public function isGet() :bool
    {
        return $this->method() === 'get';
    }

    /**
     * Returns true if server method is POST
     *
     * @return bool
     */
    public function isPost() :bool
    {
        return $this->method() === 'post';
    }

    /**
     * Sanitizes POST and GET arrays by using HTML special chars
     *
     * @return array
     */
    public function getBody()
    {
        $body = [];

        if ($this->isPost()) :
            foreach ($_POST as $key => $value) :
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            endforeach;
        endif;

        if ($this->isGet()) :
            foreach ($_GET as $key => $value) :
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            endforeach;
        endif;

        return $body;
    }

    /**
     * Redirects to another location
     *
     * @param string $whereTo;
     */
    public function redirect ($whereTo)
    {
        header("Location: $whereTo");
    }
}