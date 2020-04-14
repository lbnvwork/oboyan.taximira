<?php


namespace App\Main\Models\Repositories;

class DataManager
{
    private const CONTENT = [
        'contacts' => [
            'order_phone' => '84712748494',
            'drivers_phone' => '89096559585',
            'mail' => 'taxi.mira@yandex.ru',
            'address' => 'Курская область, город Курск, Проспект Хрущева 22'
        ],
        'prices' => [
            'freight_order' => '395',
            'loader_order' => [
                'hour' => '250',
                'min_order_time' => '2',
                'next_hour' => '250'
            ]
        ],
        'meta' => [
            [
                'controller' => 'Home',
                'action' => 'index',
                'url' => '',
                'description' => 'Сервис заказа такси «Мира». Заказать такси в Обояни, доставка продуктов. Телефон: 8 (4712) 74-84-94. «Мира» обладает большим опытом в организации пассажирских перевозок, что находит отклик в положительных отзывах клиентов.',
                'name' => 'Сервис заказа такси «Мира». Такси онлайн в Обояни, доставка продуктов.',
                'title' => 'Такси в Обояни',
                'keywords' => 'сервис заказа такси; такси в Обояни; доставка продуктов; дешевое такси в Обояни'
            ],
        ],
        'main-menu'=>[
            [
                'value' => '',
                'caption' => 'Главная'
            ],
            [
                'value' => '#order',
                'caption' => 'Заказ онлайн'
            ],
            [
                'value' => '#services',
                'caption' => 'Услуги'
            ],
            [
                'value' => '#contacts',
                'caption' => 'Контакты'
            ],
        ]
    ];

    public function getWorkPhone($phoneString)
    {
        $pattern = '/8(\d{4})(\d{2})(\d{2})(\d{2})/';
        $replacement = '8 ($1). $2-$3-$4';
        return explode('.', preg_replace($pattern, $replacement, $phoneString));
    }

    public function getMobilPhone($phoneString)
    {
        $pattern = '/8(\d{3})(\d{3})(\d{2})(\d{2})/';
        $replacement = '8 ($1). $2-$3-$4';
        return explode('.', preg_replace($pattern, $replacement, $phoneString));
    }

    public function getMeta(array $routeParams): array
    {
        foreach (self::CONTENT['meta'] as $meta) {
            if ($meta['controller'] == $routeParams['controller'] && $meta['action'] == $routeParams['action']) {
                return $meta;
            }

        }
        return [];
    }

    public function getBaseData(array $routeParams): array
    {
        $orderPhone = $this->getWorkPhone(self::CONTENT['contacts']['order_phone']);
        $driversPhone = $this->getMobilPhone(self::CONTENT['contacts']['drivers_phone']);
        return [
            'orderPhoneTop' => [
                'leftPart' => $orderPhone[0],
                'rightPart' => $orderPhone[1]
            ],
            'orderPhoneBottom' => implode('', $orderPhone),
            'orderPhoneTel' => self::CONTENT['contacts']['order_phone'],
            'meta' => $this->getMeta($routeParams),
            'mainMenu' => self::CONTENT['main-menu']
        ];
    }

    public function __call($name, $arguments
    ) {
        // Замечание: значение $name регистрозависимо.
        $key = substr(strtolower($name), 3);
        if (array_key_exists($key, self::CONTENT)) {
            return self::CONTENT[$key];
        }
        return null;
    }
}