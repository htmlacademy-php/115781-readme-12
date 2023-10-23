<?php

declare(strict_types=1);

require_once 'helpers.php';

$is_auth = rand(0, 1);

$user_name = 'Дмитрий'; // укажите здесь ваше имя

//функция сокращения текста до 300 символов
function trimtext(string $text, int  $limit = 300): string
{
    if (strlen($text) <= $limit) {
        return '<p>' . $text . '</p>';
    } else {
        $words = explode(' ', $text);
        $totalLength = 0;
        $newText = '';
        foreach ($words as $word) {
            $totalLength += strlen($word);
            if ($totalLength > $limit) {
                break;
            }
            $newText .= $word . ' ';
        }
        $newText .= '...';
        return $newText;
    }
}

$posts = [
    [
        "title" => "Цитата",
        "type" => "post-quote",
        "content" => "Мы в жизни любим только раз, а после ищем лишь похожих",
        "username" => "Лариса",
        "avatar" => "userpic-larisa-small.jpg"
    ],
    [
        "title" => "Игра престолов",
        "type" => "post-text",
        "content" => "Не могу дождаться начала финального сезона своего любимого сериала!",
        "username" => "Владик",
        "avatar" => "userpic.jpg"
    ],
    [
        "title" => "Наконец, обработал фотки!",
        "type" => "post-photo",
        "content" => "rock-medium.jpg",
        "username" => "Виктор",
        "avatar" => "userpic-mark.jpg"
    ],
    [
        "title" => "Моя мечта",
        "type" => "post-photo",
        "content" => "coast-medium.jpg",
        "username" => "Лариса",
        "avatar" => "userpic-larisa-small.jpg"
    ],
    [
        "title" => "Лучшие курсы",
        "type" => "post-link",
        "content" => "www.htmlacademy.ru",
        "username" => "Владик",
        "avatar" => "userpic.jpg"
    ]
];

array_walk_recursive($posts, function(&$value) {
    $value = htmlspecialchars($value, ENT_QUOTES);
});

$pageContent = include_template('main.php',
                                        [
                                            'posts' => $posts
                                        ]);

$layout_content = include_template('layout.php',
                                        [
                                            'pageName'=>'Readme',
                                            'user_name' => $user_name,
                                            'pageContent' => $pageContent
                                        ]);

print($layout_content);



