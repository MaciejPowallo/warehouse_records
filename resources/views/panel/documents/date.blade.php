<?php
	function dni_mies($mies,$rok) {
		$dni = 31;
		while (!checkdate($mies, $dni, $rok)) --$dni;
	return $dni+1;
	}

	function dzien_tyg_nr($mies,$rok) {
		$dzien = date("w", mktime(0,0,0,$mies,0,$rok));
	return $dzien;
	}

	function dzien_tyg($nr) {
		$dzien = array(0 => "Niedziela", "Poniedziałek", "Wtorek", "Środa", "Czwartek", "Piątek", "Sobota");
	return $dzien[$nr];
	}

	function miesiac_pl($mies) {
		$mies_pl = array(1=>"Stycznia", "Lutego", "Marca", "Kwietnia", "Maja", "Czerwca", "Lipca", "Sierpnia", "Września", "Października", "Listopada", "Grudnia");
	return $mies_pl[$mies];
	}

	function miesiace_pl($mies) {
		$mies_pl = array(1=>"Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień");
	return $mies_pl[$mies];
	}
?>