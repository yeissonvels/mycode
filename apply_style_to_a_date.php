<?php

/**
 * @author Yeisson Vélez
 * @param $text
 * @return mixed
 *
 * This function find a date and apply it a css style
 */
function applyStyleToDateFormat($text) {
    //$datePatternEs = '/(\d{1,2}\/)(\d{1,2}\/)(\d{2,4})/'; // spanish pattern
    $datePatternEn = '/(\d{2,4}-)(\d{1,2}-)(\d{1,2})/'; // English pattern

    return preg_replace($datePatternEn,
        "<b class='mark-found-date'>$1$2$3</b>", $text);
}

?>
