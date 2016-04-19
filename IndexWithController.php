<?php
/**
 * Created by PhpStorm.
 * User: yvelez
 * Date: 18/02/16
 * Time: 16:53
 *
 * This class give you the possibility to manage your web page access using the MVC pattern
 * This is the default configuration: yourproject/?controller=yourController&opt=yourOption
 * localhost/myproject/?controller=user&opt=new_user
 */

abstract class App {
    // to get request
    static function initGetController() {
        if (isset($_GET['controller'])) {
            $controller = ucfirst($_GET['controller']) . 'Controller';

            if (class_exists($controller)) {
                $controller = new $controller();

                if (isset($_GET['opt']) && !isset($_POST['opt'])) {
                    $method = $_GET['opt'];
                    if (method_exists($controller, $method)) {
                        $controller->$method();
                    } else {
                        die('The method does not exist ' . "'$method' ");
                    }
                }
            } else {
                die('The controller does not exist ' . "'$controller' ");
            }
        }
    }

    // to post request
    static function initPostController() {
        if (isset($_POST['controller'])) {
            $controller = ucfirst($_POST['controller']) . 'Controller';

            if (class_exists($controller)) {
                $controller = new $controller();

                if (isset($_POST['opt'])) {
                    $method = $_POST['opt'];

                    if (method_exists($controller, $method)) {
                        $controller->$method();
                        $showAfter = $_POST['show'];
                        // if we need to show anything else after a controller call
                        if ($showAfter != 'none') {
                            $controller->$showAfter();
                        }
                    } else {
                        die('The method does not exist ' . "'$method' ");
                    }

                }
            } else {
                die('The controller does not exist ' . "'$controller' ");
            }
        }
    }
}
