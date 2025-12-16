<?php
namespace src\controllers;

use \core\Controller;
use \src\Config;
use src\models\Agendamento;

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

    public function cadastro() {
        $cliente = $_POST["nome_completo"];
        $telefone = $_POST["telefone"];
        $datahora = $_POST["datahora"];
        $barbeiro_id = $_POST["barbeiro_id"];
        $servico_id = $_POST["servico_id"];
        $agendamento = new Agendamento();

        $date = new \DateTime($datahora);
        $now = new \DateTime();
        if ($date < $now) {
            echo json_encode(array( "success" => false, "ret" => "Não é possível agendar em uma data e hora no passado." ));
            die;
        }
        $datahoraFormatada = $date->format('d/m/Y H:i');

        $barbeiroNome = $agendamento->getBarbeiroNome($barbeiro_id);
        $servicoNome = $agendamento->getServicoNome($servico_id);

        $ret = $agendamento->cadastro($cliente, $telefone, $barbeiro_id, $servico_id, $datahora);
        
        if ($ret['sucesso'] == true) {
            $mensagem = "Olá $cliente, seu agendamento foi confirmado!\n" .
                        "Data e Hora: $datahoraFormatada\n" . 
                        "Barbeiro: $barbeiroNome\n" .
                        "Serviço: $servicoNome.\n" .
                        "Obrigado por escolher nossa barbearia!";
        
            echo json_encode(array( "success" => true, "ret" => $ret ));
        } else {
            echo json_encode(array( "success" => false, "ret" => $ret ));
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

    public function editar() {
        $id = $_POST['id'];
        $cliente = $_POST['nome_completo'];
        $telefone = $_POST['telefone'];
        $barbeiro_id = $_POST['barbeiro_id'];
        $servico_id = $_POST['servico_id'];
        $datahora = $_POST['datahora'];

        $agendamento = new Agendamento();
        $result = $agendamento->editar($id, $cliente, $telefone, $barbeiro_id, $servico_id, $datahora);

        if (!$result['sucesso']) {
            echo json_encode(array( "success" => false, "result" => $result ));
            die;
        } else {
            echo json_encode(array( "success" => true, "result" => $result ));
            die;
        }
    }
}
