#Задача 1. Понимание существующего кода.
Упростите следующий код сохранив лексикографический порядок возвращаемых строк:
```
function makeMagicStringFromDate() {
	$dateTime = new DateTime("now", new DateTimeZone("GMT"));
	$str = $dateTime->format("YmdHis");
	for ($i = 0; $i < strlen($str); $i++) {
		if (ctype_digit($str[$i])) {
			if ($str[$i] == 0) {
					$str[$i] = 'a';
				} else {
					$str[$i] = 10 - $str[$i];
			}
		}
	}
	return $str;
}
```
	
#Задача 2. Умение писать код.
Без применения frameworks, cms и библиотек напишите собственный сценарий регистрации/авторизации пользователей на сайте (через e-mail). После авторизации, пользователь должен получить инструменты для загрузки пачки фотографий. Фото должны загружаться без перезагрузки страницы. В качестве результата загрузки должны появляться превьюшки, клик по которым должен открывать выбранное фото в полном размере в новой вкладке. При оценке задания будет обращаться внимание на концептуальное качество кода, его чистоту. Озадачиваться вёрсткой необязательно. Результат нужно представить в виде исходного кода и работающего приложения в интернете.