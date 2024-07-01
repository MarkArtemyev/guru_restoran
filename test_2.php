<?php
function highlightWords($text, $array_of_words) {
    $foundWords = [];
    
    foreach ($array_of_words as $word) {
        // Используем границы слова и флаги 'i' и 'u' для корректной работы с UTF-8
        $pattern = '/\b' . preg_quote($word, '/') . '\b/iu';
        $text = preg_replace_callback($pattern, function ($matches) use (&$foundWords) {
            // Приводим слово к нижнему регистру для сравнения
            $lowerWord = mb_strtolower($matches[0], 'UTF-8');
            if (isset($foundWords[$lowerWord])) {
                // Если слово уже найдено, возвращаем его без изменений
                return $matches[0];
            } else {
                // Если слово найдено впервые, выделяем его и сохраняем
                $foundWords[$lowerWord] = true;
                return '[' . $matches[0] . ']';
            }
        }, $text, 1);
    }
    
    return $text;
}

// Пример использования:
$text = 'Мама мыла раму';
$array_of_words = ['ама', 'раму'];
echo highlightWords($text, $array_of_words);
?>
