<?php


namespace app\core;

/**
 * Class Response
 * @package app\core
 */
class Response
{
    /**
     * Sets HTTP response code
     * @param int $code
     */
    public function setResponseCode(int $code)
    {
        http_response_code($code);
    }
}