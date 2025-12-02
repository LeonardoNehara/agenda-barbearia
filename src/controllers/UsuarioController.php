<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Usuario;

class UsuarioController extends Controller {

    public function index() {
            $this->render('usuario', ['base' => Config::BASE_DIR]);
    }

}
