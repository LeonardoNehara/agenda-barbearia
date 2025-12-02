<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Servico;

class ServicoController extends Controller {

    public function index() {
        $this->render('servicos', ['base' => Config::BASE_DIR]);
    }
}
