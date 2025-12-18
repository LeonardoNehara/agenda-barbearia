<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Usuario;
use src\validators\UsuarioValidator;

class UsuarioController extends Controller {

    public function index() {
            $this->render('usuario', ['base' => Config::BASE_DIR]);
    }

    public function cadastro()
    {
        $erro = UsuarioValidator::validar($_POST);

        if ($erro) {
            $this->jsonResponse([
                "success" => false,
                "message" => $erro
            ], 400);
            return;
        }

        $nome  = trim($_POST['nome']);
        $login = trim($_POST['login']);
        $senha = $_POST['senha'];

        $usuario = new Usuario();

        if ($usuario->loginExiste($login)) {
            $this->jsonResponse([
                "success" => false,
                "message" => "Login já cadastrado."
            ], 409);
            return;
        }

        $dados = [
            'nome'  => $nome,
            'login' => $login,
            'senha' => password_hash($senha, PASSWORD_DEFAULT),
        ];

        try {
            $ret = $usuario->cadastro($dados);

            $this->jsonResponse([
                "success" => true,
                "ret"     => $ret
            ], 201);

        } catch (\Throwable $e) {
            $this->jsonResponse([
                "success" => false,
                "message" => "Erro interno."
            ], 500);
        }
    }

    public function getusuarios()
    {
        try {
            ini_set('display_errors', 0);
            header('Content-Type: application/json; charset=utf-8');

            $list = new Usuario();
            $ret = $list->getusuarios();

            if (empty($ret) || !isset($ret['sucesso'])) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'ret'     => null,
                    'message' => 'Erro ao obter dados dos usuários'
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }

            if ($ret['sucesso'] === false) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'ret'     => $ret['result'] ?? [],
                    'message' => $ret['message'] ?? 'Requisição inválida'
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }

            http_response_code(200);
            echo json_encode([
                'success' => true,
                'ret'     => $ret['result'] ?? [],
                'message' => ''
            ], JSON_UNESCAPED_UNICODE);
            exit;
        } catch (\Throwable $e) {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'ret'     => null,
                'message' => 'Erro interno: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    public function editar()
    {
        $erro = UsuarioValidator::validar($_POST, true);

        if ($erro) {
            $this->jsonResponse([
                "success" => false,
                "message" => $erro
            ], 400);
            return;
        }

        $dados = [
            'idusuario' => filter_var($_POST['idusuario'], FILTER_VALIDATE_INT),
            'nome'      => trim($_POST['nome']),
            'login'     => trim($_POST['login']),
        ];

        if (!empty($_POST['senha'])) {
            $dados['senha'] = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        }

        try {
            $usuario = new Usuario();
            $ret = $usuario->editar($dados);

            $this->jsonResponse([
                "success" => $ret['sucesso'],
                "ret"     => $ret
            ], $ret['sucesso'] ? 200 : 400);

        } catch (\Throwable $e) {
            $this->jsonResponse([
                "success" => false,
                "message" => "Erro interno."
            ], 500);
        }
    }

    public function updateSituacaoUsuario() {
        $id = isset($_POST['idusuario']) ? filter_var($_POST['idusuario'], FILTER_VALIDATE_INT) : null;
        $idsituacao = isset($_POST['idsituacao']) ? filter_var($_POST['idsituacao'], FILTER_VALIDATE_INT) : null;

        if ($id === false || $id === null || $idsituacao === false || $idsituacao === null) {
            $this->jsonResponse(["success" => false, "message" => "Parametros inválidos."], 400);
        }

        try {
            $cad = new Usuario();
            $ret = $cad->updateSituacao($id, $idsituacao);

            if (empty($ret) || !isset($ret['sucesso'])) {
                $this->jsonResponse(["success" => false, "ret" => $ret], 500);
            }

            if (!$ret['sucesso']) {
                $this->jsonResponse(["success" => false, "ret" => $ret], 400);
            } else {
                $this->jsonResponse(["success" => true, "ret" => $ret], 200);
            }
        } catch (\Throwable $e) {
            $this->jsonResponse(["success" => false, "message" => $e->getMessage()], 500);
        }
    }
}
