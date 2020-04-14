<?php
/**
 * Created by PhpStorm.
 * User: KiisChivarino
 * Date: 17.05.19
 * Time: 9:18
 */

namespace App\Main\Models\Services\Validator;

/**
 * Class Parameter
 * Описывает параметр формы
 *
 * @package Office\Service\Validator
 */
class Parameter
{
    /**
     * @var string $name
     * Имя параметра формы
     */
    protected $name;

    /**
     * @var string $title
     * Заголовок параметра формы
     */
    protected $title;

    /**
     * @var mixed $value
     * Значение параметра формы
     */
    protected $value;

    /**
     * @var boolean $checked
     * Статус проверено
     */
    protected $checked;

    /**
     * @var boolean $valid
     * Статус валидный
     */
    protected $valid;

    /**
     * @var boolean $nullable
     * Статус может быть null
     */
    protected $nullable;

    /**
     * @var string $message
     * Пользовательское собщение об ошибке для параметра
     */
    protected $message;

    /**
     * Parameter constructor.
     */
    public function __construct()
    {
        $this->setChecked(false);
        $this->setValid(true);
    }

    /**
     * Получение статуса валидный
     *
     * @return bool
     */
    public function getValid(): bool
    {
        return $this->valid;
    }

    /**
     * Установка статуса валидный
     *
     * @param bool $valid
     *
     * @return $this
     */
    public function setValid(bool $valid): Parameter
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * Получение статуса выбран
     *
     * @return bool
     */
    public function getChecked(): bool
    {
        return $this->checked;
    }

    /**
     * Установка статуса выбран
     *
     * @param bool $checked
     *
     * @return $this
     */
    public function setChecked(bool $checked): Parameter
    {
        $this->checked = $checked;

        return $this;
    }

    /**
     * Получение заголовка параметра
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Установка заголовка параметра (по-русски)
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): Parameter
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Получение имени параметра
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Установка имени параметра (как в форме шаблона)
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): Parameter
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Получение значения
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Установка значения
     *
     * @param $value
     *
     * @return $this
     */
    public function setValue($value): Parameter
    {
        $this->value = (isset($value) && ($value !== null || $value === 0)) ? $value : null;

        return $this;
    }

    /**
     * Получение статуса "может быть null"
     *
     * @return bool
     */
    public function getNullable(): bool
    {
        return $this->nullable;
    }

    /**
     * Установка статуса "может быть null"
     *
     * @param bool $nullable
     *
     * @return $this
     */
    public function setNullable(bool $nullable): Parameter
    {
        $this->nullable = $nullable;

        return $this;
    }

    /**
     * Получение пользовательского сообщения
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Установка пользовательского значения
     *
     * @param string $message
     *
     * @return $this
     */
    public function setMessage(string $message): Parameter
    {
        $this->message = $message;

        return $this;
    }
}
