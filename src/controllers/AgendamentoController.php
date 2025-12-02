<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\AgendamentoModel;

class AgendamentoController extends Controller {

    public function index() {
        $this->render('agendamento', ['base' => Config::BASE_DIR]);
    }
}
