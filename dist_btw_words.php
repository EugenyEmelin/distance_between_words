<?php
//1
$text1 = "the 1 1 1 the simple one words 5 5 the two words 6 6 the three five 5 6 words the"; 
$word1 = 'words';
$word2 = 'the';
echo "<br>Example 1:<br>";
echo dist_btw_words($text1, $word1, $word2);

//2
$text2 = "day fdsf dsfsdf dd is very good a sunny and tomorrow will be very good too Today dfsf day fsd Today";
$word3 = 'day';
$word4 = 'Today';
echo "<br><br>Example 2:<br>";
echo dist_btw_words($text2, $word3, $word4);

function dist_btw_words($text, $word1, $word2) {
	$test_start = microtime(true);
	//Сформируем из текста массив слов с помощью функции str_word_count()
	$words = str_word_count($text, 1, "АаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя123456789()-=+/.,'&*#@$!%^:;?|><~`{}[]/\"\\№");
	if (in_array($word1, $words) || in_array($word2, $words)) {
		if (in_array($word1, $words)) $keys_w1 = array_keys($words, $word1); #массив ключей первого слова
			else return "Слово $word1 в тексте не найдено";
		if (in_array($word2, $words)) $keys_w2 = array_keys($words, $word2); #массив ключей второго слова
			else return "Слово $word2 в тексте не найдено";
	} else return "Ниодно из слов в тексте не найдено";

	//Расчёт минимальной дистанции между словами
	$last_position_w1 = -1; 
	$last_position_w2 = -1; 
	$min_dist = PHP_INT_MAX;
	for ($i=0, $count = count($words); $i < $count; $i++) { 
		$current_word = $words[$i];
		if ($current_word === $word1) { #если нашли первое слово
			$last_position_w1 = $i; #сохраним его индекс в переменной
			$distance = abs($last_position_w1 - $last_position_w2) - 1; #количество слов между между текущими найденными индексами word1 и word2
			if ($last_position_w2 >= 0 && $distance < $min_dist) { #если к этому моменту найден индекс вторго слова и рассчитаная на данной итерации дистанция меньше самой маленькой на данный момент дистанции
				$min_dist = $distance; #присвоим минимальной дистанции текущее найденное расстояние
			} 
		} elseif ($current_word === $word2) { #если нашли второе слово
			$last_position_w2 = $i; #сохраним его индекс в переменной
			$distance = abs($last_position_w2 - $last_position_w1) - 1; #количество слов между между текущими найденными индексами word2 и word1
			if ($last_position_w1 >= 0 && $distance < $min_dist) { #если к этому моменту найден индекс первого слова и рассчитаная на данной итерации дистанция меньше самой маленькой на данный момент дистанции
				$min_dist = $distance; #присвоим минимальной дистанции текущее найденное расстояние
			} 
		}
	}
	//Расчёт максимальной дистанции между словами
	//Минимальные и максимальные позиции искомых слов в тексте
	$min_pos_w1 = $keys_w1[0];
	$max_pos_w1 = $last_position_w1;
	$min_pos_w2 = $keys_w2[0];
	$max_pos_w2 = $last_position_w2;

	$max_dist_w1w2 = abs($max_pos_w1 - $min_pos_w2) - 1; #максимальное расстояние между первым индексом word2 и последним word1
	$max_dist_w2w1 = abs($max_pos_w2 - $min_pos_w1) - 1; #максимальное расстояние между первым индексом word1 и последним word2
	$max_dist = $max_dist_w1w2 > $max_dist_w2w1 ? $max_dist_w1w2 : $max_dist_w2w1; #большее из этих расстояний и является максимальным расстоянием между словами

	$test_end = (microtime(true) - $test_start)*100000;
	$response = "Минимальное расстояние: $min_dist <br> Максимальное расстояние: $max_dist <br> $test_end <br>";
	return $response;
}	

?>