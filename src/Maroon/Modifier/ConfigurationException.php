<?php

namespace Maroon\Modifier;

class ConfigurationException extends \Exception
{
    public $key;

    public function __construct($key, $message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->key = $key;
    }
}