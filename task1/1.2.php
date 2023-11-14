<?php

/**
 *
 * Задача 1: лесенка
 * Нужно вывести лесенкой числа от 1 до 100.
 * 1
 * 2 3
 * 4 5 6
 * ...
 */


/**
 * Интерактивное решение задачи с возможностью задать произвольрное значение максимального значения лесенки.
 * Форматированный вывод в консоль
 */


/**
 * Максимальное значение лесенки по умолчанию
 */
$default = 100;

echo "Введите максимальное число для построение лесенки [{$default}]: ";
$handle = fopen("php://stdin", "r");
$input = (int)fgets($handle);
$max = ($input < 1) ? $default : $input;
echo "Строим лесенку с максимальным значением {$max}" . PHP_EOL . PHP_EOL;

main($max);


/**
 * Основная функция по отрисовке лесенки чисел
 * @param int $max Максимальное значение в лесенке
 * @return void
 */
function main(int $max): void
{
    $step = 1;
    while (true) {
        echo implode(' ', getNumbersByStep($step, $max)) . PHP_EOL;
        if (getTriangleNumber($step) >= $max) break;
        $step++;
    }
}

/**
 * Возвращает сумму первых n натуральных чисел
 * @link https://ru.wikipedia.org/wiki/%D0%A2%D1%80%D0%B5%D1%83%D0%B3%D0%BE%D0%BB%D1%8C%D0%BD%D0%BE%D0%B5_%D1%87%D0%B8%D1%81%D0%BB%D0%BE
 * @param int $n Количество первых натуральных чисел
 * @return int
 */
function getTriangleNumber(int $n): int
{
    return $n * ($n + 1) / 2;
}

/**
 * Возвращает отформатированный массив с числами для текущего шага лесенки $step, значения которого не превышают максимального знаачения $max
 * @param int $step Текущий шаг лесенки
 * @param int $max Максимальное значение в лесенке
 * @return int[]
 */
function getNumbersByStep(int $step, int $max): array
{
    $last = getTriangleNumber($step);
    return formatNumbers(
        array_map(
            fn($i) => ($i <= $max) ? $i : 0,
            range($last - $step + 1, $last)
        ), $max
    );
}

/**
 * Форматирует массив чисел для более наглядного отображения в консоли
 * @param int[] $items Массив чисел для форматирования
 * @param int $max Максимальное значение в лесенке
 * @return int[]
 */
function formatNumbers(array $items, int $max): array
{
    //Определяем разрядность числа $max
    $maxDigitPlace = floor(log10($max)) + 1;
    return array_map(function ($i) use ($maxDigitPlace) {
        if ($i === 0) return str_repeat('-', $maxDigitPlace);
        return str_pad($i, $maxDigitPlace, ' ', STR_PAD_LEFT);
    }, $items);
}
