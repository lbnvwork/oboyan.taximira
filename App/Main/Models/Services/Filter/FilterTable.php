<?php


namespace App\Main\Models\Services\Filter;

/**
 * Class FilterTable
 * Таблица фильтров
 *
 * @package App\Main\Models\Services\Filter
 */
class FilterTable
{
    /** @var string Значение по умолчаню */
    private $defaultValue;

    /** @var array Таблица фильтров (массив объектов Filter) */
    private $filterTable = [];

    /**
     * FilterTable constructor.
     *
     * @param array $filterTable
     * @param string $defaultValue
     *
     * @throws \Exception
     */
    public function __construct(array $filterTable, string $defaultValue)
    {
        $this->setFilterTable($filterTable);
        $this->defaultValue = $defaultValue;
    }

    /** Добавление таблицы фильтров
     *
     * @param array $filterTable
     *
     * @throws \Exception
     */
    public function setFilterTable(array $filterTable): void
    {
        foreach ($filterTable as $value) {
            if (!is_a($value, Filter::class)) {
                throw new \Exception('Массив должен содержать объекты типа '.Filter::class, 500);
            };
            $this->filterTable = $filterTable;
        }
    }

    /** Таблица фильтров для шаблона
     *
     * @return array
     */
    public function getViewFilerTable(): array
    {
        $filterTable = $this->filterTable;
        $resultArray = [];
        foreach ($filterTable as $filterItem) {
            $resultArray[] = [
                'value' => $filterItem->getValue(),
                'title' => $filterItem->getTitle()
            ];
        }

        return $resultArray;
    }

    /**
     * Получение свойства фильтра по числовому значению
     *
     * @param int $value
     *
     * @return string
     */
    public function getPropertyByValue(int $value): string
    {
        /** @var Filter $filter */
        foreach ($this->filterTable as $filter) {
            if ($filter->getValue() == $value) {
                return $filter->getProperty();
            }
        }

        return $this->defaultValue;
    }
}