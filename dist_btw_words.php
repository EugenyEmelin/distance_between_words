<?php
//1
$text1 = "the ывыфв 1  the simple one words 5 5 the two words 6 the three five 5 6 words eqeasd the wwords"; 
$word1 = 'words';
$word2 = 'the';
echo "<br>Example 1:<br>";
echo dist_btw_words($text1, $word1, $word2);

//2
$text2 = "day ывыфв fdsf dsfsdf dd is very good a sunny and tomorrow will be very good too Today dfsf fsfsdfds 12 321 day 323 sd 32 fsd Today";
$word3 = 'day';
$word4 = 'Today';
echo "<br><br>Example 2:<br>";
echo dist_btw_words($text2, $word3, $word4);

function dist_btw_words($text, $word1, $word2) {
	$test_start = microtime(true);
	$words = preg_split("/[\s,.;!?()]+/", $text); #разобьём строку по произвольному числу пробелов или знаков препинания
	if (!in_array($word1, $words) && !in_array($word2, $words)) return "The words in the text are not found";
	elseif (!in_array($word1, $words)) return "Word \"$word1\" is not found in the text";
	elseif (!in_array($word2, $words)) return "Word \"$word2\" is not found in the text";

	//Расчёт минимальной дистанции между словами
	$last_position_w1 = -1; 
	$last_position_w2 = -1; 
	$min_dist = PHP_INT_MAX;
	for ($i=0, $count = count($words); $i < $count; $i++) { 
		$current_word = $words[$i];
		if ($current_word === $word1) { #если нашли первое слово
			$first_position_w1 =  $first_position_w1 ?? $i; #в данную переменную сохраним лишь первый найденный индекс $word1
			$last_position_w1 = $i; #сохраним его индекс в переменной
			$distance = $last_position_w1 - $last_position_w2 - 1; #количество слов между текущими найденными индексами word1 и word2
			if ($last_position_w2 >= 0 && $distance < $min_dist) { #если к этому моменту найден индекс вторго слова и рассчитаная на данной итерации дистанция меньше самой маленькой на данный момент дистанции
				$min_dist = $distance; #присвоим минимальной дистанции текущее найденное расстояние
			} 
		} elseif ($current_word === $word2) { #если нашли второе слово
			$first_position_w2 =  $first_position_w2 ?? $i; #в данную переменную сохраним лишь первый найденный индекс $word2
			$last_position_w2 = $i; #сохраним его индекс в переменной
			$distance = $last_position_w2 - $last_position_w1 - 1; #количество слов между текущими найденными индексами word2 и word1
			if ($last_position_w1 >= 0 && $distance < $min_dist) { #если к этому моменту найден индекс первого слова и рассчитаная на данной итерации дистанция меньше самой маленькой на данный момент дистанции
				$min_dist = $distance; #присвоим минимальной дистанции текущее найденное расстояние
			} 
		}
	}
	//Расчёт максимальной дистанции между словами
	$max_dist_w1w2 = $last_position_w1 - $first_position_w2 - 1; #максимальное расстояние между первым индексом word2 и последним word1
	$max_dist_w2w1 =$last_position_w2 - $first_position_w1 - 1; #максимальное расстояние между первым индексом word1 и последним word2
	$max_dist = $max_dist_w1w2 > $max_dist_w2w1 ? $max_dist_w1w2 : $max_dist_w2w1; #большее из этих расстояний и является максимальным расстоянием между словами
	$test_result = (microtime(true) - $test_start)*100000;
	$response = "Минимальное расстояние: $min_dist <br> Максимальное расстояние: $max_dist <br> $test_result";
	return $response;
}	
?>