<?php

namespace App\Main\Models\Services\Filter;

/**
 * Class Filter
 * Создание объектов фильтра
 *
 * @package App\Main\Models\Services\Filter
 */
class Filter
{
    /** @var string Соответствует свойству entity */
    private $property;

    /** @var string Заголовок фильтра для вывода в шаблоне */
    private $title;

    /** @var int Числовое значение фильтра для вывода в шаблоне */
    private $value;

    /**
     * Filter constructor.
     *
     * @param int $value
     * @param string $property
     * @param string $title
     */
    public function __construct(int $value, string $property, string $title)
    {
        $this->property = $property;
        $this->value = $value;
        $this->title = $title;
    }

    /**
     * Получение свойства фильтра
     *
     * @return string
     */
    public function getProperty(): string
    {
        return $this->property;
    }

    /**
     * Получение значения фильтра
     *
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Получение заголовка фильтра
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}