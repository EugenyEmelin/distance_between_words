<?php
//1
$text1 = "the 1 1 1 five 321 the simple one words 5 53213 sadsa the two words 6 sa 6 the wedsad three five 5 6 words"; 
$word1 = 'words';
$word2 = 'five';
echo "<br>Example 1:<br>";
echo dist_btw_words($text1, $word1, $word2);

//2
$text2 = "Today good w 1 23 432 a sunny day and tomorrow will day be very good too  qd sadf gf a day.";
$word3 = 'day';
$word4 = 'Today';
echo "<br><br>Example 2:<br>";
echo dist_btw_words($text2, $word3, $word4);

function dist_btw_words($text, $word1, $word2) {
	//Сформируем из текста массив слов с помощью функции str_word_count()
	$words = str_word_count($text, 1, "АаБбВвГгДдЕеЁёЖжЗзИиЙйКкЛлМмНнОоПпРрСсТтУуФфХхЦцЧчШшЩщЪъЫыЬьЭэЮюЯя123456789"); # 1 во втором аргументе возвращает массив слов, где ключи - индекс слов в тексте начиная с 0. Третий параметр нужен для того, чтобы функция работала с русским текстом
	$last_position_w1 = -1; #временно зададим начальные позиции искомым словам (-1 значит пока не найдены)
	$last_position_w2 = -1; 
	$min_dist = PHP_INT_MAX; #временно присвоим мин. дистанции максимально допустимое значение в php
	//пройдём циклом по всем словам
	for ($i=0, $count = count($words); $i < $count; $i++) { 
		$current_word = $words[$i];
		if ($current_word === $word1) { #если нашли первое слово
			$last_position_w1 = $i; #сохраним его индекс в переменной
			$distance = $last_position_w1 - $last_position_w2 - 1; #количество слов между между текущими найденными индексами word1 и word2
			if ($last_position_w2 >= 0 && $distance < $min_dist) { #если к этому моменту найден индекс вторго слова и рассчитаная на данной итерации дистанция меньше самой маленькой на данный момент дистанции
				$min_dist = $distance; #присвоим минимальной дистанции текущее найденное расстояние
			} 
			if ($last_position_w2 >= 0 && $distance > $min_dist) { #если к этому моменту найден индекс первого слова и текущая найденная дистанция превышает текущую минимальную дистанцию
				$max_dist = $distance; #сохраняем пока эту дистанцию как максимальную
			}
		} elseif ($current_word === $word2) { #если нашли второе слово
			$last_position_w2 = $i; #сохраним его индекс в переменной
			$distance = $last_position_w2 - $last_position_w1 - 1; #количество слов между между текущими найденными индексами word2 и word1
			if ($last_position_w1 >= 0 && $distance < $min_dist) { #если к этому моменту найден индекс первого слова и рассчитаная на данной итерации дистанция меньше самой маленькой на данный момент дистанции
				$min_dist = $distance; #присвоим минимальной дистанции текущее найденное расстояние
			} 
			if ($last_position_w1 >= 0 && $distance > $min_dist) { #если к этому моменту найден индекс первого слова и текущая найденная дистанция превышает текущую минимальную дистанцию
				$max_dist = $distance; #сохраняем пока эту дистанцию как максимальную
			}
		}
	}
	if (($last_position_w1 < 0) && ($last_position_w2 < 0)) { #если после завершения цикла ниодно из слов не найдено
		$response = "Ниодно из слов в тексте не найдено"; 
	} elseif ($last_position_w2 < 0) { #если не найдено второе слово
		$response = "Слово $word2 в тексте не найдено";
	} elseif ($last_position_w1 < 0) { #если не найдено первое слово
		$response = "Слово $word1 в тексте не найдено";
	} else { #если оба слова найдены в тексте
		$max_dist = $max_dist ?? $min_dist; #если после нахождения минимальной дистанции другие дистанции большие минимальной не найдены, то максимальная равна минимальной
		$response = "Минимальное расстояние: $min_dist <br> Максимальное расстояние: $max_dist";	
	}
	return $response;
}
?>