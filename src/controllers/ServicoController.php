<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Servico;
use src\validators\ServicoValidator;

class ServicoController extends Controller {

    public function index() {
        $this->render('servicos', ['base' => Config::BASE_DIR]);
    }

    public function getServicos() {
        $cad = new Servico();
        $ret = $cad->getServicos();

        if ($ret['sucesso'] == true) {
            echo json_encode(array("success" => true,"ret" => $ret['result']));
            die;
        } else {
            echo json_encode(array("success" => false,"ret" => $ret['result']));
            die;
        }
    }

    public function getServicosAtivos()
    {
        try {
            $cad = new Servico();
            $ret = $cad->getServicosAtivos();

            if (empty($ret) || !isset($ret['sucesso'])) {
                return $this->jsonResponse([
                    "success" => false,
                    "ret" => null,
                    "message" => "Erro ao obter serviços ativos"
                ], 500);
            }

            if ($ret['sucesso'] === false) {
                return $this->jsonResponse([
                    "success" => false,
                    "ret" => $ret['result'] ?? [],
                    "message" => $ret['message'] ?? 'Requisição inválida'
                ], 400);
            }

            return $this->jsonResponse([
                "success" => true,
                "ret" => $ret['result'] ?? [],
                "message" => ""
            ], 200);

        } catch (\Throwable $e) {
            return $this->jsonResponse([
                "success" => false,
                "ret" => null,
                "message" => "Erro interno: " . $e->getMessage()
            ], 500);
        }
    }

    public function cadastro()
    {
        $erro = ServicoValidator::validarCadastro($_POST);

        if ($erro) {
            echo json_encode([
                "success" => false,
                "message" => $erro
            ]);
            die;
        }

        $nome = $_POST["nome"];
        $valor = $_POST["valor"];
        $tempoMinutos = $_POST["tempoMinutos"];

        $cad = new Servico();
        $existe = $cad->verificarServico($nome);

        if ($existe['result']['existeServico'] == 1) {
            echo json_encode([
                "success" => false,
                "message" => "Serviço já cadastrado."
            ], 409);
            die;
        }

        $ret = $cad->cadastro($nome, $valor, $tempoMinutos);

        echo json_encode([
            "success" => $ret['sucesso'],
            "ret" => $ret
        ], 201);
        die;
    }


    public function updateSituacao() {
        $id = $_POST['id'];
        $idsituacao = $_POST['idsituacao'];
        $cad = new Servico();
        $ret = $cad->updateSituacao($id, $idsituacao);

        if ($ret['sucesso'] == false) {
            echo json_encode(array( "success" => false, "ret" => $ret['result']));
            die;
        } else {
            echo json_encode(array( "success" => true, "ret" => $ret['result']));
            die;
        }
    }

    public function editar()
    {
        $erro = ServicoValidator::validarEdicao($_POST);

        if ($erro) {
            echo json_encode([
                "success" => false,
                "message" => $erro
            ]);
            die;
        }

        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $valor = $_POST['valor'];
        $tempoMinutos = $_POST['tempoMinutos'];

        $editar = new Servico();
        $result = $editar->editar($id, $nome, $valor, $tempoMinutos);

        echo json_encode([
            "success" => $result['sucesso'],
            "result" => $result
        ], 201);
        die;
    }
}
