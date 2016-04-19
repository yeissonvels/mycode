<?php
/**
 * Created by PhpStorm.
 * User: Yeisson Vélez
 * Date: 4/04/16
 * Time: 13:23
 */


/**
 * Class Translator
 *
 * This class provide you the posibility to have differents languages in your site.
 */
class Translator {
    protected $languages;
    protected $lang;

    function __construct() {
        // We save the default language in session and we get it of this way:
        $this->lang = $_SESSION['lang'];

        // We define the languages (for example english as default position 0)
        $this->languages = array(
            'en' => 0,
            'es' => 1,
            'de' => 2
        );
    }

    /**
     * @param $label
     * @param int $substrEnd (if we want cut the text) getTrans('product', 4) = prod
     * @return string
     */
    function getTrans($label, $substrEnd = 0) {
        $dictionary = array(
                'not_privileges' => array(
                "You don't have enough access privileges!",
                'No tiene privilegios suficientes para realizar esta acción!',
                'Du hast nicht genügend rechte um diese Option auszuführen'
            ),
            'hello' => array('Hello', 'Hola', 'Hallo'),
            'search' => array('Search', 'Buscar', 'Suchen'),
            'months' => array(
                1 => array('January', 'Enero', 'Januar'),
                2 => array('February','Febrero', 'Februar'),
                3 => array('March','Marzo', 'März'),
                4 => array('April', 'Abril', 'April'),
                5 => array('May', 'Mayo', 'Mai'),
                6 => array('June', 'Junio', 'Juni'),
                7 => array('July', 'Julio', 'July'),
                8 => array('August', 'Agosto', 'August'),
                9 => array('September', 'Septiembre', 'September'),
                10 => array('October', 'Octubre', 'Oktober'),
                11 => array('November', 'Noviembre', 'November'),
                12 => array('December', 'Diciembre', 'Dezember')
            )
        );

        // It obtains the current language index
        $lang = $this->languages[$this->lang];

        if (is_array($label)) {

            return $dictionary[$label[0]][$label[1]][$lang];

        } else {

            if ($substrEnd > 0) {
                return substr($dictionary[$label][$lang], 0, $substrEnd) . '.';

            } else {
                return $dictionary[$label][$lang];

            }
        }

    }
}

/**
 * How to use it?
 *
 * 1) Define a new class
 * 2) Call the getTrans function with your label as parameter
 *
 */

$myTrans = new Translator();
$hello = $myTrans->getTrans('hello');
echo $hello;

/**
 * Note: You can define an array of arrays for example for the months
 *
 *   'months' => array(
 *       1 => array('January', 'Enero', 'Januar'),
 *       2 => array('February','Febrero', 'Februar'),
 *       3 => array('March','Marzo', 'März'),
 *   )
 *
 * Then you can call your getTrans function so:
*/

$myTrans = new Translator();
$month = $myTrans->getTrans(array('months', 1));
// In this case and with spanish as default it will be showed 'Enero'
echo $month;

