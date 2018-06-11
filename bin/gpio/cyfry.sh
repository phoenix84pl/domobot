#Podajemy numery PINów ktore odpowiadaja za konkretne LED.
#UWAGA! Energie podpinamy na środku, a masami sterujemy dioda. W rezulatacie 0 wlacza diode a 1 wylacza

gp=8
g=9
gl=7
s=0

k=15
dp=16
d=1
dl=4

gpio mode $g out
gpio mode $gp out
gpio mode $gl out
gpio mode $s out
gpio mode $k out
gpio mode $dp out
gpio mode $d out
gpio mode $dl out

gpio write $g 1
gpio write $gp 1
gpio write $gl 1
gpio write $s 1
gpio write $k 1
gpio write $dp 1
gpio write $d 1
gpio write $dl 1

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
