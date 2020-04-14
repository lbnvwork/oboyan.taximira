<?php

namespace Core;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use PDO;
use App\Config;

/**
 * Абстрактный класс модели
 * PHP version 7.0
 */
abstract class Model
{
    /**
     * Создание объекта EntityManager
     *
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     */
    protected static function getEntityManager(): EntityManager
    {
        require_once ROOT_PATH."/vendor/autoload.php";
        $isDevMode = true;
        $config = Setup::createAnnotationMetadataConfiguration(
            [ROOT_PATH."/App/Models/Entity/"],
            $isDevMode,
            null,
            null,
            false
        );
        $dbParams = [
            'driver' => Config::DRIVER ?? 'pdo_mysql',
            'charset' => Config::CHARSET ?? 'utf8',
            'user' => Config::DB_USER,
            'password' => Config::DB_PASSWORD,
            'dbname' => Config::DB_NAME,
        ];

        return EntityManager::create($dbParams, $config);
    }

    /**
     * Создание PDO соединения
     *
     * @return mixed
     */
    protected static function getDB()
    {
        static $db = null;

        if ($db === null) {
            $dsn = 'mysql:host='.Config::DB_HOST.';dbname='.Config::DB_NAME.';charset=utf8';
            $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);

            // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }

    /**
     * Приведение объекта Entity к массиву
     *
     * @param object|null $entity
     * @param bool $htmlspecialchars
     *
     * @return array
     */
    protected function entityToArray(?object $entity, bool $htmlspecialchars = false): array
    {
        if (!$entity) {
            return [];
        }
        $entityClassName = get_class($entity);
        $propertyNamesOfEntityClass = $this->getPropertyNames($entityClassName);
        $entityArray = [];
        foreach ($propertyNamesOfEntityClass as $propertyName) {
            $getterMethod = 'get'.ucfirst($propertyName);
            $entityArray[$propertyName] =
                $htmlspecialchars ? $entity->$getterMethod() : htmlspecialchars($entity->$getterMethod());
        }

        return $entityArray;
    }

    /**
     * Получение свойств класса Entity (по геттерам)
     *
     * @param string $entityClassName
     *
     * @return array
     */
    protected function getPropertyNames(string $entityClassName): array
    {
        if (!$entityClassName) {
            return [];
        }
        $getterMethods = array_filter(
            get_class_methods($entityClassName), function ($str) {
            return (strpos($str, 'get') === 0);
        }
        );
        $propertiesArray = [];
        foreach ($getterMethods as $method) {
            $propertiesArray[] = lcfirst(str_replace('get', '', $method));
        }

        return $propertiesArray;
    }
}
