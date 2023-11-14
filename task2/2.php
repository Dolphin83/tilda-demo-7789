<?php

/**
 * Задача 2: массивы
 * Нужно заполнить массив 5 на 7 случайными уникальными числами от 1 до 1000.
 * Вывести получившийся массив и суммы по строкам и по столбцам.
 */

interface Randomable
{
    public function random();
}

class RandomUniqueGenerator implements Randomable
{
    private array $storage = [];

    public int $size;

    public function __construct(
        public readonly int $min,
        public readonly int $max,
    )
    {
        if ($max < $min) {
            throw new RangeException("Максимум диапазона {$max} меньше минимума диапазона {$min}");
        }
    }

    public function random(): int
    {
        do {
            $num = random_int($this->min, $this->max);
        } while (array_key_exists($num, $this->storage));

        $this->storage[$num] = null;
        return $num;
    }

    public function setSize(int $size): void
    {
        if ($this->max - $this->min + 1 < $size) {
            throw new RangeException("Диапазон чисел {$this->min} - {$this->max} мал для созднания {$size} уникальных чисел.");
        }

        $this->size = $size;
    }
}

class Matrix
{
    private array $data = [];
    private array $sumByRows = [];
    private array $sumByColumns = [];

    public function __construct(
        public readonly int        $columns,
        public readonly int        $rows,
        public readonly Randomable $generator,
    )
    {
        $generator->setSize($rows * $columns);
        $this->sumByColumns = array_fill(0, $this->columns, 0);

        for ($row = 0; $row < $this->rows; ++$row) {
            for ($column = 0; $column < $this->columns; ++$column) {
                $randomUniqueValue = $generator->random();
                $this->data[$row][$column] = $randomUniqueValue;
                $this->sumByColumns[$column] += $randomUniqueValue;
            }
            $this->sumByRows[$row] = array_sum($this->data[$row]);
        }
    }

    /**
     * Вывод матрицы и значений сумм чисел по строкам и столбцам в консоль
     * @return void
     */
    public function print(): void
    {
        $pad = floor(log10($this->generator->max * max($this->columns, $this->rows))) + 2;
        $data = $this->data;
        $data[] = $this->sumByColumns;
        foreach (array_keys($data) as $y) {
            $line = array_merge($data[$y], ['', $this->sumByRows[$y] ?? '']);

            if ($y === array_key_last($data)) echo PHP_EOL . PHP_EOL;
            echo implode(' ', array_map(fn($i) => str_pad($i, $pad, ' ', STR_PAD_LEFT), $line)) . PHP_EOL;
        }
    }
}

/**
 * Запуск программы
 */

$columns = 5;
$rows = 7;
$min = 1;
$max = 1000;

(new Matrix($columns, $rows, (new RandomUniqueGenerator($min, $max))))->print();