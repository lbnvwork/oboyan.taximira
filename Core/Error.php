<?php

namespace Core;

use App\Config;

/**
 * Error and exception handler
 * PHP version 7.0
 */
class Error
{
    /**
     * Error handler.
     *
     * @param $level
     * @param $message
     * @param $file
     * @param $line
     *
     * @throws \ErrorException
     */
    public static function errorHandler($level, $message, $file, $line)
    {
        if (error_reporting() !== 0) {
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Exception handler
     *
     * @param \Exception $exception
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public static function exceptionHandler(\Exception $exception)
    {
        $code = $exception->getCode();
        http_response_code($code);

        if (Config::SHOW_ERRORS) {
            echo "<h1>Fatal error</h1>";
            echo "<p>Uncaught exception: '".get_class($exception)."'</p>";
            echo "<p>Message: '".$exception->getMessage()."'</p>";
            echo "<p>Stack trace:<pre>".$exception->getTraceAsString()."</pre></p>";
            echo "<p>Thrown in '".$exception->getFile()."' on line ".$exception->getLine()."</p>";
        } else {
            $log = dirname(__DIR__).'/logs/'.date('Y-m-d').'.txt';
            ini_set('error_log', $log);

            $message = "Uncaught exception: '".get_class($exception)."'";
            $message .= " with message '".$exception->getMessage()."'";
            $message .= "\nStack trace: ".$exception->getTraceAsString();
            $message .= "\nThrown in '".$exception->getFile()."' on line ".$exception->getLine();

            error_log($message);

            View::renderTemplate("Errors\\$code.html");
        }
    }
}
