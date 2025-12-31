<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Agendamento;
use src\validators\AgendamentoValidator;

class AgendamentoController extends Controller {

    public function index() {
        $this->render('agendamento', ['base' => Config::BASE_DIR]);
    }

    public function getAgendamentos() {
        $barbeiro_id = isset($_GET['barbeiro']) ? $_GET['barbeiro'] : null;
        $agendamento = new Agendamento();
        $ret = $agendamento->getAgendamentos($barbeiro_id);

        if ($ret['sucesso'] == true) {
            echo json_encode(["success" => true, "ret" => $ret['result']]);
        } else {
            echo json_encode(["success" => false, "ret" => $ret['result']]);
        }
        die;
    } 

    public function cadastro()
    {
        $dados = $_POST;

        $erro = AgendamentoValidator::validar($dados);
        if ($erro) {
            echo json_encode(["success" => false, "ret" => $erro]);
            die;
        }

        $agendamento = new Agendamento();

        $ret = $agendamento->cadastro(
            $dados['nome_completo'],
            $dados['telefone'],
            $dados['barbeiro_id'],
            $dados['servico_id'],
            $dados['datahora']
        );

        if ($ret['sucesso']) {
            echo json_encode(["success" => true, "ret" => $ret]);
        } else {
            echo json_encode(["success" => false, "ret" => $ret]);
        }
        die;
    }

    public function getBarbeiroNome($barbeiro_id) {
        $agendamento = new Agendamento();
        return $agendamento->getBarbeiroNome($barbeiro_id);
    }
    
    public function getServicoNome($servico_id) {
        $agendamento = new Agendamento();
        return $agendamento->getServicoNome($servico_id);
    }


    public function updateSituacaoAgendamento() {
        $id = $_POST['id'];
        $situacao = $_POST['situacao'];
        $agendamento = new Agendamento();
        $ret = $agendamento->updateSituacao($id, $situacao);

        if ($ret['sucesso'] == false) {
            echo json_encode(array( "success" => false, "ret" => $ret['result'] ));
            die;
        } else {
            echo json_encode(array( "success" => true, "ret" => $ret['result'] ));
            die;
        }
    }

    public function editar()
    {
        $dados = $_POST;

        $erro = AgendamentoValidator::validar($dados, true);
        if ($erro) {
            echo json_encode(["success" => false, "ret" => $erro]);
            die;
        }

        $agendamento = new Agendamento();

        $result = $agendamento->editar(
            $dados['id'],
            $dados['nome_completo'],
            $dados['telefone'],
            $dados['barbeiro_id'],
            $dados['servico_id'],
            $dados['datahora']
        );

        if ($result['sucesso']) {
            echo json_encode(["success" => true, "result" => $result]);
        } else {
            echo json_encode(["success" => false, "result" => $result]);
        }
        die;
    }
}
