<?php

namespace Core;

use Twig\Environment;
use Twig\Extension\DebugExtension;

/**
 * View
 * PHP version 7.0
 */
class View
{
    /**
     * Отдает файл шаблона
     *
     * @param $view
     * @param array $args
     *
     * @throws \Exception
     */
    public static function render(string $view, string $group, array $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__).'/App/'.$group.'/Views'.$view;

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    /**
     * Отдает файл шаблона Twig
     *
     * @param string $template
     * @param string $group
     * @param array $args
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public static function renderTemplate(string $template, string $group = Router::DEFAULT_ROUT_GROUP, array $args = [])
    {
        static $twig = null;
        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__).'/App/'.$group.'/Views');
            $twig = new Environment(
                $loader,
                [
                    'debug' => true,
                ]
            );
            $twig->addExtension(new DebugExtension());
        }

        echo $twig->render($template, $args);
    }

    /**
     * Отдает json
     *
     * @param array $args
     */
    public static function renderJson(array $args = [])
    {
        header('Content-type: application/json');
        echo json_encode($args);
    }
}