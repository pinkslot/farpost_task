<?php
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

function refactoredMakeMagicStringFromDate() {
	$dateTime = new DateTime("now", new DateTimeZone("GMT"));
	$str = $dateTime->format("YmdHis");
	return preg_replace_callback('/\d/', function ($matches) {
		return $matches[0] == '0' ? 'a' : 10 - intval($matches[0]);
	}, $str);
}


echo makeMagicStringFromDate() . "\n";
echo refactoredMakeMagicStringFromDate() . "\n";
