<?php

require_once "gpio.rpi.class.php";

	//numery pinow wPi odpowiadajace diodom
$piny=array('gp'=>8, 'g'=>9, 'gl'=>7, 's'=>0, 'k'=>15, 'dp'=>16, 'd'=>1, 'dl'=>4);

GPIO::tryb($piny, 'OUT');
GPIO::stan($piny, 1);

if(isset($argv[1]))
{
	switch($argv[1])
	{
		case '0': GPIO::stan(array($piny['g'], $piny['gp'], $piny['gl'], $piny['d'], $piny['dl'], $piny['dp']), 0); break;
		case '1': GPIO::stan(array($piny['gp'], $piny['dp']), 0); break;
		case '2': GPIO::stan(array($piny['g'], $piny['gp'], $piny['s'], $piny['d'], $piny['dl']), 0); break;
		case '3': GPIO::stan(array($piny['g'], $piny['gp'], $piny['s'], $piny['d'], $piny['dp']), 0); break;
		case '4': GPIO::stan(array($piny['gl'], $piny['gp'], $piny['s'], $piny['dp']), 0); break;
		case '5': GPIO::stan(array($piny['g'], $piny['gl'], $piny['s'], $piny['d'], $piny['dp']), 0); break;
		case '6': GPIO::stan(array($piny['g'], $piny['gl'], $piny['s'], $piny['dl'], $piny['d'], $piny['dp']), 0); break;
		case '7': GPIO::stan(array($piny['g'], $piny['gp'], $piny['dp']), 0); break;
		case '8': GPIO::stan(array($piny['g'], $piny['gp'], $piny['gl'], $piny['s'], $piny['d'], $piny['dl'], $piny['dp']), 0); break;
		case '9': GPIO::stan(array($piny['g'], $piny['gl'], $piny['s'], $piny['gp'], $piny['d'], $piny['dp']), 0); break;

		case 'A': GPIO::stan(array($piny['g'], $piny['gp'], $piny['gl'], $piny['s'], $piny['dl'], $piny['dp']), 0); break;
		case 'B': GPIO::stan(array($piny['g'], $piny['gp'], $piny['gl'], $piny['s'], $piny['d'], $piny['dl'], $piny['dp']), 0); break;
		case 'C': GPIO::stan(array($piny['g'], $piny['gl'], $piny['dl'], $piny['d']), 0); break;
		case 'D': GPIO::stan(array($piny['g'], $piny['gp'], $piny['gl'], $piny['d'], $piny['dl'], $piny['dp']), 0); break;
		case 'E': GPIO::stan(array($piny['g'], $piny['gl'], $piny['s'], $piny['d'], $piny['dl']), 0); break;
		case 'F': GPIO::stan(array($piny['g'], $piny['gl'], $piny['s'], $piny['dl']), 0); break;
		case 'G': GPIO::stan(array($piny['g'], $piny['gl'], $piny['s'], $piny['dl'], $piny['d'], $piny['dp']), 0); break;
		case 'H': GPIO::stan(array($piny['gp'], $piny['gl'], $piny['s'], $piny['dl'], $piny['dp']), 0); break;
		case 'I': GPIO::stan(array($piny['gp'], $piny['dp']), 0); break;
		case 'J': GPIO::stan(array($piny['gp'], $piny['dp'], $piny['d'], $piny['dl']), 0); break;
		case 'K': GPIO::stan(array($piny['gp'], $piny['gl'], $piny['s'], $piny['dl'], $piny['dp']), 0); break;
		case 'L': GPIO::stan(array($piny['gl'], $piny['dl'], $piny['d']), 0); break;
		case 'M': GPIO::stan(array($piny['g'], $piny['gp'], $piny['gl'], $piny['dl'], $piny['dp']), 0); break;
		case 'N': GPIO::stan(array($piny['g'], $piny['gp'], $piny['gl'], $piny['dl'], $piny['dp']), 0); break;
		case 'O': GPIO::stan(array($piny['g'], $piny['gp'], $piny['gl'], $piny['d'], $piny['dl'], $piny['dp']), 0); break;
		case 'P': GPIO::stan(array($piny['g'], $piny['gl'], $piny['s'], $piny['gp'], $piny['dl']), 0); break;
		case 'R': GPIO::stan(array($piny['g'], $piny['gp'], $piny['gl'], $piny['s'], $piny['dl'], $piny['dp']), 0); break;
		case 'S': GPIO::stan(array($piny['g'], $piny['gl'], $piny['s'], $piny['d'], $piny['dp']), 0); break;
		case 'T': GPIO::stan(array($piny['g'], $piny['gp'], $piny['dp']), 0); break;
		case 'U': case 'V': case 'W': GPIO::stan(array($piny['d'], $piny['gp'], $piny['gl'], $piny['dl'], $piny['dp']), 0); break;
		case 'X': GPIO::stan(array($piny['gp'], $piny['gl'], $piny['s'], $piny['dl'], $piny['dp']), 0); break;
		case 'Y': GPIO::stan(array($piny['gl'], $piny['gp'], $piny['s'], $piny['dl']), 0); break;
		case 'Z': GPIO::stan(array($piny['g'], $piny['gp'], $piny['s'], $piny['d'], $piny['dl']), 0); break;

		case '.': GPIO::stan(array($piny['k']), 0); break;
	}
}

/*

if [ $# -ne 0 ];
then

if [ $1 -eq 0 ];
then
	gpio write $g 0
	gpio write $gp 0
	gpio write $gl 0
	gpio write $d 0
	gpio write $dl 0
	gpio write $dp 0
fi

if [ $1 -eq 1 ];
then
	gpio write $gp 0
	gpio write $dp 0
fi

if [ $1 -eq 2 ];
then
	gpio write $g 0
	gpio write $gp 0
	gpio write $s 0
	gpio write $dl 0
	gpio write $d 0
fi

if [ $1 -eq 3 ];
then
        gpio write $g 0
        gpio write $gp 0
        gpio write $s 0
        gpio write $dp 0
        gpio write $d 0
fi

if [ $1 -eq 4 ];
then
        gpio write $gl 0
        gpio write $gp 0
        gpio write $s 0
        gpio write $dp 0

fi

if [ $1 -eq 5 ];
then
        gpio write $g 0
        gpio write $gl 0
        gpio write $s 0
        gpio write $dp 0
        gpio write $d 0
fi

if [ $1 -eq 6 ];
then
        gpio write $g 0
        gpio write $gl 0
        gpio write $s 0
        gpio write $dl 0
        gpio write $dp 0
        gpio write $d 0
fi


if [ $1 -eq 7 ];
then
	gpio write $g 0
        gpio write $gp 0
        gpio write $dp 0
fi

if [ $1 -eq 8 ];
then
        gpio write $g 0
        gpio write $gp 0
        gpio write $gl 0
	gpio write $s 0
        gpio write $dl 0
        gpio write $dp 0
	gpio write $d 0
fi

if [ $1 -eq 9 ];
then
        gpio write $g 0
        gpio write $gl 0
        gpio write $s 0
        gpio write $gp 0
        gpio write $dp 0
        gpio write $d 0
fi

#if [ $1 -eq "k" ];
#then
#	gpio write $k 0
#fi

fi
exit 0
*/
?>
