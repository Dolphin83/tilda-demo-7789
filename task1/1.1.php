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
 * Формальное решение задачи
 */

$max = 100;
$step = 1;
while (true) {
    $last = $step * ($step + 1) / 2;
    echo implode(' ', array_filter(range($last - $step + 1, $last), fn($i) => $i <= $max)) . PHP_EOL;
    if ($last >= $max) break;
    $step++;
}
