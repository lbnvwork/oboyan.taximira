<?php

namespace App;

/**
 * Конфигурация приложения
 * PHP version 7.0
 */
class Config
{
    /**
     * Хост БД
     *
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Имя БД
     *
     * @var string
     */
    const DB_NAME = 'tasks';

    /**
     * Пользователь БД
     *
     * @var string
     */
    const DB_USER = 'tasks';

    /**
     * Пароль БД
     *
     * @var string
     */
    const DB_PASSWORD = 'password';

    /**
     * Вывод ошибок
     *
     * @var boolean
     */
    const SHOW_ERRORS = true;

    /**
     * Драйвер БД
     *
     * @var string
     */
    const DRIVER = 'pdo_mysql';

    /**
     * Кодировка
     *
     * @var string
     */
    const CHARSET = 'utf8';
}