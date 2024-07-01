<?php
function validateUserPost($post) {
    // Допустимые теги и их атрибуты
    $allowedTags = [
        'a' => ['href', 'title'],
        'code' => [],
        'i' => [],
        'strike' => [],
        'strong' => []
    ];

    $tagPattern = '/<\/?([a-z]+)(\s+[a-z]+="[^"]*")*\s*>/i';
    
    $attributePattern = '/\s+([a-z]+)="[^"]*"/i';

    $openTags = [];

    // Проход по всем тегам в посте
    if (preg_match_all($tagPattern, $post, $matches, PREG_OFFSET_CAPTURE)) {
        foreach ($matches[0] as $match) {
            $tag = $match[0];
            $offset = $match[1];
            
            if (preg_match('/<\/?([a-z]+)/i', $tag, $tagNameMatches)) {
                $tagName = strtolower($tagNameMatches[1]);
                
                if (!array_key_exists($tagName, $allowedTags)) {
                    return false;
                }
                
                if (preg_match_all($attributePattern, $tag, $attributeMatches)) {
                    foreach ($attributeMatches[1] as $attributeName) {
                        if (!in_array(strtolower($attributeName), $allowedTags[$tagName])) {
                            return false;
                        }
                    }
                }
                
                if (substr($tag, 1, 1) !== '/') { 
                    $openTags[] = $tagName;
                } else { 
                    $lastTag = array_pop($openTags);
                    if ($lastTag !== $tagName) {
                        return false;
                    }
                }
            }
        }
    }
    
    // Проверка на наличие незакрытых тегов
    return empty($openTags);
}

// Пример использования:
$post = '<a href="https://example.com" title="Example">Example <strong>text</strong></a>';
var_dump(validateUserPost($post)); 