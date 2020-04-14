<?php

namespace App\Main\Controllers;

use App\Main\Models\Repositories\DataManager;
use Core\Controller;
use Core\View;

/**
 * Class Home
 * Домашняя страница
 *
 * @package App\Main\Controllers
 */
class Home extends Controller
{
    /**
     * Вывод главной страницы
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function indexAction(): void
    {
        $dm = new DataManager();
        $data = $dm->getBaseData($this->route_params);
        $data['driversPhoneTel'] = $dm->getContacts()['drivers_phone'];
        $data['driversPhone'] = implode('', $dm->getMobilPhone($data['driversPhoneTel']));
        $data['email'] = $dm->getContacts()['mail'];
        $data['address'] = $dm->getContacts()['address'];
        View::renderTemplate(
            'Home/index.html',
            $this->route_params['group'], $data
        );
    }
}