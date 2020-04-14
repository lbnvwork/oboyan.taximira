<?php

namespace Core;

/**
 * Router
 * PHP version 7.0
 */
class Router
{
    //Название дирректории, в которой находятся файлы приложения
    private const APP_PATH = 'App';

    //Название поддиректории приложения по умолчанию (то же, что группы роутов по умолчанию)
    public const DEFAULT_ROUT_GROUP = 'Main';
    /**
     * Массив роутов (таблица роутов)
     *
     * @var array
     */
    protected $routes = [];

    /**
     * Массив параметров роута
     *
     * @var array
     */
    protected $params = [];

    /**
     * Добавление роута в таблицу роутов
     *
     * @param $route
     * @param array $params
     */
    public function add(string $route, array $params = []): void
    {
        // Экранирование слэшей
        $route = preg_replace('/\//', '\\/', $route);

        // Преобразование переменных
        $route = preg_replace('/{([a-z]+)}/', '(?P<\1>[a-z-]+)', $route);

        // Преобразование переменных по регулярному выражению: {id:\d+}
        $route = preg_replace('/{([a-z]+):([^}]+)}/', '(?P<\1>\2)', $route);

        // Добавление разделителей начала и конца и флага без учета регистра
        $route = '/^'.$route.'$/i';

        //begin определение группы для роута
        if (!array_key_exists('group', $params)) {
            $params['group'] = self::DEFAULT_ROUT_GROUP;
        }
        //end определение группы для роута

        $this->routes[$route] = $params;
    }

    /**
     * Получение таблицы роутов
     *
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Проверка url на соответствие роуту из таблицы роутов, установка параметров
     *
     * @param string $url
     *
     * @return boolean
     */
    public function match(string $url): bool
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                // Get named capture group values
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * Проверка HTTP-метода на соответствие роуту из таблицы роутов
     *
     * @return bool
     */
    public function matchMethod(): bool
    {
        return in_array($_SERVER['REQUEST_METHOD'], $this->getRouteMethods());
    }

    /**
     * Получение параметров текущего роута
     *
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Получение массива HTTP-методов роута
     *
     * @return array
     */
    public function getRouteMethods(): array
    {
        if (isset($this->params['method'])) {
            if (is_string($this->params['method'])) {
                return [$this->params['method']];
            } elseif (is_array($this->params['method'])) {
                return $this->params['method'];
            }
        }

        return ['GET'];
    }

    /**
     * Запускает роут, создает объект контроллера и выполняет action
     *
     * @param $url
     *
     * @throws \Exception
     */
    public function dispatch(string $url)
    {
        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url) && $this->matchMethod()) {
            $controller = $this->getNamespace(
                    self::APP_PATH.'\\'.ucfirst($this->params['group']).'\\'.'Controllers\\'
                ).$this->convertToStudlyCaps($this->params['controller']);

            if (class_exists($controller)) {
                $controller_object = new $controller($this->params);
                $action = $this->convertToCamelCase($this->params['action']);
                if (preg_match('/action$/i', $action) == 0) {
                    $controller_object->$action();
                } else {
                    throw new \Exception(
                        "Метод $action в контроллере $controller не может быть вызван напрямую 
                    - удалите Action суффикс для вызова этого метода"
                    );
                }
            } else {
                throw new \Exception("Класс контроллера $controller не найден");
            }
        } else {
            throw new \Exception('Страница не найдена', 404);
        }
    }

    /**
     * Преобразование строки с дефисами в StudlyCaps: post-authors => PostAuthors
     *
     * @param string $string
     *
     * @return string
     */
    protected function convertToStudlyCaps(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Преобразование строки с дефисами в camelCase: add-new => addNew
     *
     * @param string $string
     *
     * @return string
     */
    protected function convertToCamelCase(string $string): string
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    /**
     * Удаление переменных строки запроса из URL:
     *   URL                           $_SERVER['QUERY_STRING']  Route
     *   -------------------------------------------------------------------
     *   localhost                     ''                        ''
     *   localhost/?                   ''                        ''
     *   localhost/?page=1             page=1                    ''
     *   localhost/posts?page=1        posts&page=1              posts
     *   localhost/posts/index         posts/index               posts/index
     *   localhost/posts/index?page=1  posts/index&page=1        posts/index
     *
     * @param string $url
     *
     * @return string
     */
    protected function removeQueryStringVariables(string $url): string
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        return $url;
    }

    /**
     * Получение namespace для класса конроллера.
     *
     * @param string $namespace
     *
     * @return string
     */
    protected function getNamespace(string $namespace): string
    {
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'].'\\';
        }

        return $namespace;
    }
}
