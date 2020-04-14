<?php


namespace App\Main\Controllers;

use App\Main\Models\Repositories\DataManager;
use Core\Controller;
use Core\View;

class Politica extends Controller
{
    /**
     * Вывод страницы Политика конфиденциальности
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function indexAction(): void
    {
        $data = (new DataManager())->getBaseData($this->route_params);
        View::renderTemplate(
            'Politica/index.html',
            $this->route_params['group'], $data
        );
    }
}