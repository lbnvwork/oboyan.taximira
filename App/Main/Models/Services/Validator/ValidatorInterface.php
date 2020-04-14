<?php
/**
 * Created by PhpStorm.
 * User: KiisChivarino
 * Date: 16.05.19
 * Time: 16:58
 */

namespace App\Main\Models\Services\Validator;

use Doctrine\ORM\EntityManager;

/**
 * Interface ValidatorInterface
 * Типа интерфейс моего валидатора
 *
 * @package Office\Service\Validator
 */
interface ValidatorInterface
{
    /**
     * ValidatorInterface constructor.
     * Добавляет EntityManager в сервис
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager);

    /**
     * Добавляет объект Request в валидатор
     * Добавляет объект ValidatorMessages в валидатор
     * Выполняет проверку всех параметров валидатора
     * Определяет сообщения по результатам проверки
     *
     * @param array $paramArr
     *
     * @return mixed
     */
    public function check(array $paramArr);

    /**
     * Определяет валидность на основании всех параметров валидатора
     *
     * @return bool
     */
    public function isValid();

    /**
     * Возвращает массив параметров типа Parameter
     *
     * @return mixed
     */
    public function getParameters();

    /**
     * Возвращает объект типа ValidatorMessages
     *
     * @return mixed
     */
    public function getMessages();

    /**
     * Определяет валидность на пустое значение, если метод для параметра не определен
     *
     * @param $name
     * @param $arguments
     *
     * @return bool
     */
    public function __call($name, $arguments);
}
