<?php
// Some optimizations and corrections by Mohsen
$PERSIAN_EPOCH = 1948320.5;
$Persian_Weekdays = Array( "یکشنبه", "دوشنبه", "سه‌شنبه", "چهارشنبه",
					"پنجشنبه", "جمعه", "شنبه" );
$PersianMonthNames = Array( 1 => "فروردین", "اردیبهشت", "خرداد", "تیر", "مرداد",
					"شهریور", "مهر", "آبان", "آذر", "دی", "بهمن", "اسفند" );

//  PERSIAN_TO_JD  --  Determine Julian day from Persian date
function persian_to_jd($year, $month, $day)
{
    Global $PERSIAN_EPOCH;
	$epbase = 0;
	$epyear = 0;

    $epbase = $year - (($year >= 0) ? 474 : 473);
    $epyear = 474 + ($epbase % 2820);

    return $day +
            (($month <= 7) ?
                (($month - 1) * 31) :
                ((($month - 1) * 30) + 6)
            ) +
            floor((($epyear * 682) - 110) / 2816) +
            ($epyear - 1) * 365 +
            floor($epbase / 2820) * 1029983 +
            ($PERSIAN_EPOCH - 1);
}

//  JD_TO_PERSIAN  --  Calculate Persian date from Julian day
function jd_to_persian($jd)
{
    $year = 0;
	$month = 0;
	$day = 0;
	$depoch = 0;
	$cycle = 0;
	$cyear = 0;
	$ycycle = 0;
    $aux1 = 0;
	$aux2 = 0;
	$yday = 0;

    $jd = floor($jd - 0.5 ) + 0.5; //solve PHP GregorianToJd incorrect return value :)

    $depoch = $jd - persian_to_jd(475, 1, 1);
    $cycle = floor($depoch / 1029983);
    $cyear = ($depoch % 1029983);
    if ($cyear == 1029982) {
        $ycycle = 2820;
    } else {
        $aux1 = floor($cyear / 366);
        $aux2 = ($cyear % 366);
        $ycycle = floor(((2134 * $aux1) + (2816 * $aux2) + 2815) / 1028522) +
                    $aux1 + 1;
    }
    $year = $ycycle + (2820 * $cycle) + 474;
    if ($year <= 0) {
        $year--;
    }
    $yday = ($jd - persian_to_jd($year, 1, 1)) + 1;
    $month = ($yday <= 186) ? ceil($yday / 31) : ceil(($yday - 6) / 30);
    $day = ($jd - persian_to_jd($year, $month, 1)) + 1;
    return Array($year, $month, $day);
}

// Function by AMIB
function FormatPersianDate( $pdate_array ) {
	
	Global $PersianMonthNames;
	
	$replace_pairs = Array ( "0" => "۰", "1" => "۱", "2" => "۲", "3" => "۳", "4" => "۴",
		"5" => "۵", "6" => "۶", "7" => "۷", "8" => "۸", "9" => "۹" );
	
	return strtr ( $pdate_array[2], $replace_pairs ) . ' ' . 
		$PersianMonthNames [$pdate_array[1]] . ' ' . 
		strtr ( $pdate_array[0] , $replace_pairs );
}
function FormatPersianSmallDate( $pdate_array ) {
	
	Global $PersianMonthNames;
	
	$replace_pairs = Array ( "0" => "۰", "1" => "۱", "2" => "۲", "3" => "۳", "4" => "۴",
		"5" => "۵", "6" => "۶", "7" => "۷", "8" => "۸", "9" => "۹" );
	
	return strtr ( $pdate_array[0], $replace_pairs ) . '/' . 
		strtr ( $pdate_array[1], $replace_pairs )  . '/' . 
		strtr ( $pdate_array[2] , $replace_pairs );
}
?>