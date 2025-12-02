<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Barbeiro;

class BarbeiroController extends Controller {
    
    public function index() {
            $this->render('barbeiro', ['base' => Config::BASE_DIR]);
    }
}
