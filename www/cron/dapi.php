#!/usr/bin/php
<?php

$czas=time();

require_once(__DIR__.'/../lib/root/precms.php');
require_once(__DIR__.'/../config/dapi.php');
cms_require_modul('db');
cms_require_modul('curl');

function idAktualizuj($id, $o_db)
{
	//funkcja aktualizuje id w bazie
	return $o_db->aktualizuj(array('wartosc'=>htmlspecialchars($id)), "WHERE `klucz`='last'", 'ustawienia');
}

function rozkazWykonaj($id, $o_db)
{
	//funkcja wykonuje rozkaz
	if(($rozkaz=$o_db->wiersz(array('rozkaz', 'parametry'), "WHERE `id`='".htmlspecialchars($id)."'", 'rozkazy'))===FALSE) return false;
	else
	{
		switch($rozkaz['rozkaz'])
		{
			case 'ziz':
			{
				$parametry=json_decode($rozkaz['parametry']);

//				var_dump($parametry);
				$parametry->title=str_replace('"', '\"', $parametry->title);
				$polecenie=empty($parametry->title)?"ziz":"ziz \"{$parametry->title}\"";
//				var_dump($polecenie);
				echo exec($polecenie);

				break;
			}

			case 'glosnosc':
			{
				$parametry=json_decode($rozkaz['parametry']);

//				var_dump($parametry);
				$polecenie="amixer -D pulse sset Master {$parametry->value}%";
				echo exec($polecenie);

				break;
			}

			case 'suspend':
			{
				$parametry=json_decode($rozkaz['parametry']);

					//musi być na prawach root
				$polecenie="pm-suspend";
				echo exec($polecenie);

				break;
			}

			case 'suspend':
			{
				$parametry=json_decode($rozkaz['parametry']);

//				var_dump($parametry);
				$polecenie="pm-suspend";
				echo exec($polecenie);

				break;
			}

			case 'espeak':
			{
				$parametry=json_decode($rozkaz['parametry']);

//				var_dump($parametry);
				$parametry->text=str_replace('"', '\"', $parametry->text);
				$parametry->text=str_replace(" ' ", "'", $parametry->text);	//nie wiedziec czemu google zapisuej apostrofu ze spacjami do naszej (zapewne robi to PGO)
				$polecenie="espeak -ven \"{$parametry->text}\"";
				echo exec($polecenie);

				break;
			}

			case 'lcd':
			{
				$parametry=json_decode($rozkaz['parametry']);

//				var_dump($parametry);
				$parametry->text=str_replace('"', '\"', $parametry->text);
				$parametry->text=str_replace(" ' ", "'", $parametry->text);	//nie wiedziec czemu google zapisuej apostrofu ze spacjami do naszej (zapewne robi to PGO)
				$polecenie="lcd \"Google Assistant:\" \"{$parametry->text}\"";
				echo exec($polecenie);

				break;
			}

			case 'otworzDomofon':
			{
				$polecenie="domofon";
				echo exec($polecenie);

				break;
			}

			default:
				echo "Nieznany rozkaz: {$rozkaz['rozkaz']}.\n";
		}
	}
}

	//wszystko ladnie w petli trwajacej mniej niz minute, by nie nalozyc sie z nastepna...
	//ogolnie pobieramy rozkaz, aktualizujemy status, odwalamy robote, aktualizujemy status i tak w kolko
while(time()-$czas<59)
{
		//pobranie danych musi byc w petli, bo np. last sie zmienia, reszta teortycznie tez moze :/
	if(($last=$o_db->komorka('wartosc', "WHERE `klucz`='last'", 'ustawienia'))===FALSE)
	{
		//jesli nie ma tabeli ustawienia to ja wstaw
		$o_db->bezposrednie("
			CREATE TABLE `ustawienia` (`id` int(11) NOT NULL, `klucz` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL, `wartosc` text COLLATE utf8mb4_unicode_ci NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
			ALTER TABLE `ustawienia`  ADD PRIMARY KEY (`id`),  ADD UNIQUE KEY `klucz` (`klucz`);
			ALTER TABLE `ustawienia` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
			INSERT INTO `ustawienia` (`id`, `klucz`, `wartosc`) VALUES(1, 'last', '0');
		");

		$last=$o_db->komorka('wartosc', "WHERE `klucz`='last'", 'ustawienia');
	}


	$o_curl=new curl();
	$link=DB_URL."?name=".DB_NAME."&secret=".DB_SECRET."&action=requestGet&last={$last}&limit=1";
	$www=$o_curl->wykonaj($link);
	$wynik=(array) json_decode($www);

//	var_dump($link);

	if($wynik['success']===false) echo "Logowanie lipa\n";
	elseif(isset($wynik['data'])) foreach($wynik['data'] as $klucz=>$wartosc)
	{
		var_dump($wynik['data']);

		if($o_db->dodaj_rekord(array('id'=>$wartosc->id, 'czas_rozkaz'=>$wartosc->time, 'czas_pobranie'=>time(), 'rozkaz'=>$wartosc->type, 'parametry'=>$wartosc->param, 'status'=>0), 'rozkazy')===false)
		{
				//jesli blad
			if($o_db->error[0]==23000)
			{
				//jesli duplikat

				echo "Duplikat {$wartosc->id}\n";
				idAktualizuj($wartosc->id, $o_db);
				echo "ERROR: DUPLIKAT\n";
			}
			elseif($o_db->error[0]=="42S02")
			{
				//jesli brak tabeli to ja utworz

				echo "Błąd dodania rozkazu do bazy, bo nie ma tabeli. Tworzę tabelę.\n";

				$o_db->bezposrednie("
					CREATE TABLE `rozkazy` (  `id` int(11) NOT NULL,  `czas_rozkaz` int(11) NOT NULL,  `czas_pobranie` int(11) NOT NULL,  `rozkaz` text COLLATE utf8mb4_unicode_ci NOT NULL,  `parametry` text COLLATE utf8mb4_unicode_ci NOT NULL,  `status` int(11) NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
					ALTER TABLE `rozkazy`  ADD PRIMARY KEY (`id`);
					ALTER TABLE `rozkazy` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
					");

			}
			else
			{
					//nie dodano rozkazu, bo chuj wie co (np. sql injection))
				echo "Błąd dodania rozkazu do bazy. .\n";
				var_dump($o_db->sql, $o_db->error);
				echo "ERROR: CHUJWICOTO np. brak tabeli lub bledna konstrukcja tabeli\n";
				exit();
			}
		}
		else
		{
			if(idAktualizuj($wartosc->id, $o_db)===FALSE)
			{
				//nie zaktualizowalo id w ustawieniach (bedzie probowal sciagnac rozkaz jeszcze raz)
				var_dump($o_db->sql, $o_db->error);
				echo "ERROR: ID w ustawieniach zostalo bez zmian\n";
			}
			else
			{
				//wysyla request aktualizacji statusu na bramie
				$o_curl=new curl();
				$link=DB_URL."?name=".DB_NAME."&secret=".DB_SECRET."&action=requestStatusUpdate&id={$wartosc->id}&status=2";
				$www=$o_curl->wykonaj($link);
				$www=(array) json_decode($www);

				rozkazWykonaj($wartosc->id, $o_db);
				// var_dump($link, $wynik);
				echo "OK\n";
			}
		}
	}
//	exec("espeak -vpl \"kibel kibel kibel\"");
	sleep(1);
	echo "KONIEC\n";

//sudo lcd "" "Temperatura:     $(sudo dht11 t)C" "Wilgotnosc:      $(sudo dht11 h)%"
}
?>