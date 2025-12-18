<?php
namespace src\validators;

class BarbeiroValidator
{
    public static function validarCadastro(array $dados): ?string
    {
        $nome     = trim($dados['nome'] ?? '');
        $telefone = trim($dados['telefone'] ?? '');

        if (!$nome || !$telefone) {
            return "Nome e telefone são obrigatórios.";
        }

        if (strlen($nome) < 3 || strlen($nome) > 100) {
            return "O nome deve ter entre 3 e 100 caracteres.";
        }

        if (!self::nomeValido($nome)) {
            return "O nome não pode conter números ou caracteres especiais.";
        }

        $telefoneNumeros = preg_replace('/\D/', '', $telefone);

        if (strlen($telefoneNumeros) < 10 || strlen($telefoneNumeros) > 11) {
            return "Telefone inválido.";
        }

        return null;
    }

    public static function validarEdicao(array $dados): ?string
    {
        $id       = $dados['id'] ?? null;
        $nome     = trim($dados['nome'] ?? '');
        $telefone = trim($dados['telefone'] ?? '');

        if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
            return "ID inválido.";
        }

        if (!$nome || !$telefone) {
            return "Nome e telefone são obrigatórios.";
        }

        if (strlen($nome) < 3 || strlen($nome) > 100) {
            return "O nome deve ter entre 3 e 100 caracteres.";
        }

        if (!self::nomeValido($nome)) {
            return "O nome não pode conter números ou caracteres especiais.";
        }

        $telefoneNumeros = preg_replace('/\D/', '', $telefone);

        if (strlen($telefoneNumeros) < 10 || strlen($telefoneNumeros) > 11) {
            return "Telefone inválido.";
        }

        return null;
    }

    private static function nomeValido(string $nome): bool
    {
        return preg_match('/^[A-Za-zÀ-ÿ\s]+$/', $nome);
    }
}
