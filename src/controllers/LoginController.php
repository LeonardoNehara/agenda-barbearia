<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use \src\models\Login;

class LoginController extends Controller {
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public function index() {
        if (isset($_SESSION['usuario'])) {
            header('Location: ' . Config::BASE_DIR . '/inicio');
            exit;
        }

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

            $_SESSION['usuario'] = $result['result']['nome'];
            $_SESSION['usuario_id'] = $result['result']['idusuario'];

            echo json_encode([
                'success' => true,
                'user' => $result['result'],
                'redirect' => Config::BASE_DIR . '/usuario'
            ]);

        } else {
            echo json_encode([
                'success' => false,
                'msg' => 'Login ou senha incorretos'
            ]);
        }
        die;
    }


    public function deslogar(){

        $_SESSION = array();    
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
        $this->render('login', ['base' => Config::BASE_DIR]);
    }
}