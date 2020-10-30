<?php

use app\controllers\Controller;

class GenericController extends Controller {

    function __construct() {
        parent::__construct(...func_get_args());
    }

    // @Overrided function from Controller.

    /* function process(App $app) {
        
    } */
    
}
?>