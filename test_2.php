<?php
function highlightWords($text, $array_of_words) {
    $pattern = '/\b(' . implode('|', array_map('preg_quote', $array_of_words)) . ')\b/ui';
    $replaced = [];
    $result = preg_replace_callback($pattern, function ($matches) use (&$replaced) {
        if (isset($replaced[mb_strtolower($matches[0])])) {
            return $matches[0];
        }
        $replaced[mb_strtolower($matches[0])] = true;
        return '[' . $matches[0] . ']';
    }, $text);

    return $result;
}

$text = "Мама мыла раму и Вася мыла раму";
$array_of_words = ["ама", "раму", "Вася"];

$result = highlightWords($text, $array_of_words);
echo $result;
?>
