<?php

// function alphabet_soup($str) {

// 	$stringParts = str_split($str);
// 	sort($stringParts);
// 	return implode('', $stringParts);
// }

// $result = alphabet_soup("hello world");

// echo $result;

function sort_alphabet($str) {
    $array = array();
    for($i = 0; $i < strlen($str); $i++) {
        $array[] = $str{$i};
    }
    // alternatively $array = str_split($str);
    // forgot about this

    sort($array);
    return implode('', $array);
}

$result = sort_alphabet("hello world");

echo $result;
 






?>
