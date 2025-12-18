<?php
namespace src\validators;

class ServicoValidator
{
    public static function validarCadastro(array $dados): ?string
    {
        $nome = trim($dados['nome'] ?? '');
        $valor = $dados['valor'] ?? null;
        $tempoMinutos = $dados['tempoMinutos'] ?? null;

        if (!$nome || $valor === null || $tempoMinutos === null) {
            return "Nome, valor e tempo são obrigatórios.";
        }

        if (strlen($nome) < 3 || strlen($nome) > 100) {
            return "O nome do serviço deve ter entre 3 e 100 caracteres.";
        }

        if (!preg_match('/^[a-zA-ZÀ-ÿ0-9\s]+$/u', $nome)) {
            return "O nome do serviço contém caracteres inválidos.";
        }

        if (!is_numeric($valor) || $valor <= 0) {
            return "O valor deve ser um número maior que zero.";
        }

        if (!filter_var($tempoMinutos, FILTER_VALIDATE_INT) || $tempoMinutos <= 0) {
            return "O tempo deve ser um número inteiro maior que zero.";
        }

        return null;
    }

    public static function validarEdicao(array $dados): ?string
    {
        if (empty($dados['id']) || !filter_var($dados['id'], FILTER_VALIDATE_INT)) {
            return "ID inválido.";
        }

        return self::validarCadastro($dados);
    }
}
