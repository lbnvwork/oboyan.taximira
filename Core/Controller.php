<?php

namespace Core;

/**
 * Base controller
 * PHP version 7.0
 */
abstract class Controller
{

    /**
     * Параметры роута
     *
     * @var array
     */
    protected $route_params = [];

    /**
     * Class constructor
     *
     * @param array $route_params
     *
     * @return void
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    /**
     * Генератор методов Action
     *
     * @param $name
     * @param $args
     *
     * @throws \Exception
     */
    public function __call($name, $args)
    {
        $method = $name.'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array(
                    [
                        $this,
                        $method
                    ], $args
                );
                $this->after();
            }
        } else {
            throw new \Exception("Метод $method не найден в контроллере ".get_class($this));
        }
    }

    /**
     * Выполняется до выполнения action
     *
     * @return void
     */
    protected function before()
    {
    }

    /**
     * Выполняется после выполнения action
     *
     * @return void
     */
    protected function after()
    {
    }
}
