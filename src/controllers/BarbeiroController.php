<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Barbeiro;
use src\validators\BarbeiroValidator;

class BarbeiroController extends Controller {

    public function index() {
        $this->render('barbeiro', ['base' => Config::BASE_DIR]);
    }

    public function cadastro() {
        try {
            $erro = BarbeiroValidator::validarCadastro($_POST);

            if ($erro) {
                $this->jsonResponse([
                    "success" => false,
                    "ret"     => null,
                    "message" => $erro
                ], 400);
                return;
            }

            $nome     = trim($_POST['nome']);
            $telefone = trim($_POST['telefone']);

            $cad = new Barbeiro();

            $existe = $cad->verificarTelefone($telefone);
            if (!empty($existe['result']['existeTelefone']) && $existe['result']['existeTelefone'] == 1) {
                $this->jsonResponse(["success" => false, "ret" => $existe, "message" => "Telefone já cadastrado."], 409);
            }

            $ret = $cad->cadastro($nome, $telefone);

            if (empty($ret) || !isset($ret['sucesso'])) {
                $this->jsonResponse(["success" => false, "ret" => $ret, "message" => "Erro ao cadastrar barbeiro"], 500);
            }

            if ($ret['sucesso'] === true) {
                $this->jsonResponse(["success" => true, "ret" => $ret, "message" => $ret['result'] ?? ''], 201);
            } else {
                $this->jsonResponse(["success" => false, "ret" => $ret, "message" => $ret['message'] ?? 'Falha no cadastro'], 400);
            }

        } catch (\Throwable $e) {
            $this->jsonResponse(["success" => false, "ret" => null, "message" => "Erro interno: " . $e->getMessage()], 500);
        }
    }

    public function getBarbeiros()
    {
        try {
            ini_set('display_errors', 0);
            header('Content-Type: application/json; charset=utf-8');

            $cad = new Barbeiro();
            $ret = $cad->getBarbeiros();

            if (empty($ret) || !isset($ret['sucesso'])) {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'ret'     => null,
                    'message' => 'Erro ao obter barbeiros'
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

    public function getBarbeirosAtivos() {
        try {
            $cad = new Barbeiro();
            $ret = $cad->getBarbeirosAtivos();

            if (empty($ret) || !isset($ret['sucesso'])) {
                $this->jsonResponse(["success" => false, "ret" => null, "message" => "Erro ao obter barbeiros ativos"], 500);
            }

            if ($ret['sucesso'] === false) {
                $this->jsonResponse(["success" => false, "ret" => $ret['result'] ?? [], "message" => $ret['message'] ?? 'Requisição inválida'], 400);
            }

            $this->jsonResponse(["success" => true, "ret" => $ret['result'] ?? [], "message" => ""], 200);
        } catch (\Throwable $e) {
            $this->jsonResponse(["success" => false, "ret" => null, "message" => "Erro interno: " . $e->getMessage()], 500);
        }
    }

    public function editar() {
        try {
            $erro = BarbeiroValidator::validarEdicao($_POST);

            if ($erro) {
                $this->jsonResponse([
                    "success" => false,
                    "ret"     => null,
                    "message" => $erro
                ], 400);
                return;
            }

            $id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : null;
            $nome = isset($_POST['nome']) ? trim($_POST['nome']) : null;
            $telefone = isset($_POST['telefone']) ? trim($_POST['telefone']) : null;

            if ($id === false || $id === null) {
                $this->jsonResponse(["success" => false, "ret" => null, "message" => "ID inválido."], 400);
            }

            $editar = new Barbeiro();
            
            $existe = $editar->verificarTelefoneEdicao($telefone, $id);
            if (
                $existe['sucesso'] === true &&
                !empty($existe['result']['existeTelefone']) &&
                $existe['result']['existeTelefone'] == 1
            ) {
                $this->jsonResponse([
                    "success" => false,
                    "ret"     => null,
                    "message" => "Telefone já cadastrado para outro barbeiro."
                ], 409);
            }
            $result = $editar->editar($id, $nome, $telefone);

            if (empty($result) || !isset($result['sucesso'])) {
                $this->jsonResponse(["success" => false, "ret" => $result, "message" => "Erro ao editar barbeiro"], 500);
            }

            if ($result['sucesso'] === false) {
                $this->jsonResponse(["success" => false, "ret" => $result, "message" => $result['message'] ?? 'Falha ao editar'], 400);
            } else {
                $this->jsonResponse(["success" => true, "ret" => $result, "message" => $result['result'] ?? ''], 200);
            }
        } catch (\Throwable $e) {
            $this->jsonResponse(["success" => false, "ret" => null, "message" => "Erro interno: " . $e->getMessage()], 500);
        }
    }

    public function updateSituacaoBarbeiro() {
        try {
            $id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : null;
            $idsituacao = isset($_POST['idsituacao']) ? filter_var($_POST['idsituacao'], FILTER_VALIDATE_INT) : null;

            if ($id === false || $id === null || $idsituacao === false || $idsituacao === null) {
                $this->jsonResponse(["success" => false, "ret" => null, "message" => "Parâmetros inválidos."], 400);
            }

            $cad = new Barbeiro();
            $ret = $cad->updateSituacao($id, $idsituacao);

            if (empty($ret) || !isset($ret['sucesso'])) {
                $this->jsonResponse(["success" => false, "ret" => $ret, "message" => "Erro ao atualizar situação"], 500);
            }

            if ($ret['sucesso'] === false) {
                $this->jsonResponse(["success" => false, "ret" => $ret, "message" => $ret['message'] ?? 'Falha ao atualizar'], 400);
            } else {
                $this->jsonResponse(["success" => true, "ret" => $ret, "message" => $ret['result'] ?? ''], 200);
            }
        } catch (\Throwable $e) {
            $this->jsonResponse(["success" => false, "ret" => null, "message" => "Erro interno: " . $e->getMessage()], 500);
        }
    }

}
