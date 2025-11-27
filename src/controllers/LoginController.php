<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use \src\models\Login;

class LoginController extends Controller {
    
    public function index() {
        $this->render('login', ['base' => Config::BASE_DIR]);
    }
    
    public function logar() {
        header('Content-Type: application/json; charset=utf-8');

        $dados['login'] = $_POST["login"] ?? null;
        $dados['password'] = $_POST["password"] ?? null;

        if (!$dados['login'] || !$dados['password']) {
            echo json_encode([
                'success' => false,
                'msg' => 'Preencha todos os campos!'
            ]);
            die;
        }

        $acesso = new Login();
        $result = $acesso->logar($dados);      

        if ($result['sucesso'] && md5($dados['password']) === $result['result']['senha']) {

            echo json_encode([
                'success' => true,
                'user' => $result['result'],
                'redirect' => '/'
            ]);

        } else {
            echo json_encode([
                'success' => false,
                'msg' => 'Login ou senha incorretos'
            ]);
        }
        die;

    }

}