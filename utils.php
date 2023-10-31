<?php

// Генерация псевдодат для каждого поста
//  Причем для первого элемента массива дата будет из минутного периода, для второго — из часового и так далее.
function get_dates($array)
{
    $id = 0;
    foreach ($array as &$item) {
        $item['id'] = $id;
        $item['date'] = generate_random_date($id);
        $id++;
    }
    return $array;
}

// Дату в формате «дд.мм.гггг чч: мм» для показа внутри атрибута title тега date.

function get_title_date($date)
{
    $date = strtotime($date);
    return date('d.m.Y H:i', $date);
}

// следует правильно склонять название периода в зависимости от числа: 1 минута назад, 10 минут назад, 2 минуты назад.
// Узнать подходящее склонение поможет функция get_noun_plural_form
function format_date($date)
{
    $minutes_in_hour = 60; // Кол-во минут в 1 часе
    $hours_in_day = 24; // Кол-во часов в 1 сутках;
    $days_in_week = 7; // Кол-во дней в 1 неделе;
    $days_in_month = 30; // Кол-во дней в 1 месяце;
    $five_weeks = 35; // 5 недель;

    $post_date = date_create($date);
    $current_date = date_create('now');
    $diff = date_diff($current_date, $post_date); // Разница между current_date и post_date в виде объекта

    $minutes = $diff->i;
    $hours = $diff->h;
    $days = $diff->days;
    $years = $diff->y;

    $result = $date;

    if ($diff->invert === 0) {
        $result = "Дата ещё не наступила!";
    } else {
        if ($years > 0) {
            $result = $years . ' ' . get_noun_plural_form($years, 'год', 'года', 'лет');
        } elseif ($days >= $five_weeks) {
            $months = ceil($days / $days_in_month);
            $result = $months . ' месяц' . get_noun_plural_form($months, '', 'а', 'ев');
        } elseif ($days >= $days_in_week && $days < $five_weeks) {
            $weeks = ceil($days / $days_in_week);
            $result = $weeks . ' недел' . get_noun_plural_form($weeks, 'ю', 'и', 'ь');
        } elseif ($days > 0 && $days <= $days_in_week) {
            $result = $days . ' ' . get_noun_plural_form($days, 'день', 'дня', 'дней');
        } elseif ($hours > 0 && $hours < $hours_in_day) {
            $result = $hours . ' час' . get_noun_plural_form($hours, '', 'а', 'ов');
        } elseif ($minutes > 0 && $minutes < $minutes_in_hour) {
            $result = $minutes . ' минут' . get_noun_plural_form($minutes, 'у', 'ы', '');
        }

        $result .= ' назад';
    }

    return $result;
}
