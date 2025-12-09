<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Usuario;

class UsuarioController extends Controller {

    public function index() {
            $this->render('usuario', ['base' => Config::BASE_DIR]);
    }

    public function cadastro() {
        $nome  = isset($_POST['nome'])  ? trim($_POST['nome'])  : null;
        $login = isset($_POST['login']) ? trim($_POST['login']) : null;
        $senha = isset($_POST['senha']) ? $_POST['senha'] : null;

        if (empty($nome) || empty($login) || empty($senha)) {
            $this->jsonResponse(["success" => false, "message" => "Campos obrigatórios ausentes."], 400);
        }

        $hashedSenha = password_hash($senha, PASSWORD_DEFAULT);

        $dados = [
            'nome'  => $nome,
            'login' => $login,
            'senha' => $hashedSenha,
        ];

        try {
            $cad = new Usuario();
            $ret = $cad->cadastro($dados);

            if (!empty($ret['sucesso'])) {
                $this->jsonResponse(["success" => true, "ret" => $ret], 201);
            } else {
                $this->jsonResponse(["success" => false, "ret" => $ret], 400);
            }
        } catch (\Throwable $e) {
            $this->jsonResponse(["success" => false, "message" => $e->getMessage()], 500);
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

    public function editar() {
        $idusuario = isset($_POST['idusuario']) ? filter_var($_POST['idusuario'], FILTER_VALIDATE_INT) : null;
        $login     = isset($_POST['login']) ? trim($_POST['login']) : null;
        $nome      = isset($_POST['nome']) ? trim($_POST['nome']) : null;
        $senha     = isset($_POST['senha']) ? $_POST['senha'] : null;

        if ($idusuario === false || $idusuario === null) {
            $this->jsonResponse(["success" => false, "message" => "idusuario inválido."], 400);
        }

        $dados = [
            'idusuario' => $idusuario,
            'login'     => $login,
            'nome'      => $nome,
        ];

        if (!empty($senha)) {
            $dados['senha'] = password_hash($senha, PASSWORD_DEFAULT);
        }

        try {
            $editar = new Usuario();
            $result = $editar->editar($dados);

            if (empty($result) || !isset($result['sucesso'])) {
                $this->jsonResponse(["success" => false, "result" => $result], 500);
            }

            if (!$result['sucesso']) {
                $this->jsonResponse(["success" => false, "result" => $result], 400);
            } else {
                $this->jsonResponse(["success" => true, "result" => $result], 200);
            }
        } catch (\Throwable $e) {
            $this->jsonResponse(["success" => false, "message" => $e->getMessage()], 500);
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
