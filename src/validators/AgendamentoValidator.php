<?php
namespace src\validators;

class AgendamentoValidator
{
    public static function validar(array $dados, bool $edicao = false): ?string
    {
        $cliente = trim($dados['nome_completo'] ?? '');
        $telefone = trim($dados['telefone'] ?? '');
        $barbeiro_id = $dados['barbeiro_id'] ?? null;
        $servico_id = $dados['servico_id'] ?? null;
        $datahora = $dados['datahora'] ?? null;

        if (!$cliente || !$telefone || !$barbeiro_id || !$servico_id || !$datahora) {
            return "Todos os campos são obrigatórios.";
        }

        if (strlen($cliente) < 3 || strlen($cliente) > 100) {
            return "O nome do cliente deve ter entre 3 e 100 caracteres.";
        }

        $telefoneFormatado = preg_replace('/\D/', '', $telefone);
        if (!preg_match('/^\d{10,11}$/', $telefoneFormatado)) {
            return "Telefone inválido. Use apenas números, com 10 ou 11 dígitos.";
        }

        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $datahora);
        if (!$date) {
            return "Data e hora inválidas.";
        }

        $now = new \DateTime();
        if ($date < $now) {
            return "Não é possível agendar em uma data/hora passada.";
        }

        $hora = (int)$date->format('H');
        if ($hora < 9 || $hora > 20) {
            return "O horário do agendamento deve ser entre 09:00 e 20:00.";
        }

        if ($edicao && empty($dados['id'])) {
            return "ID do agendamento é obrigatório para edição.";
        }

        return null;
    }
}
