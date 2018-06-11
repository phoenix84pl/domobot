<?php

class GPIO
{
	public static function tryb($piny, $tryb)
	{
		//funkcja ustawia piny na odpowiedni tryb [in/out/pwm/clock/up/down/tri], moze przyjmowac tablice pinow

		if(!array($piny)) $piny=array($piny);

		foreach($piny as $pin) system("gpio mode $pin $tryb");
	}

	public static function stan($piny, $stan)
	{
		//funkcja ustawia piny na odpowiedni stan [1/0/PWM], moze przyjmowac tablice pinow

		if(!array($piny)) $piny=array($piny);

		foreach($piny as $pin) system("gpio write $pin $stan");
	}
}

?>