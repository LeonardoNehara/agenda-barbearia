<?php
namespace src\validators;

class UsuarioValidator
{
    public static function validar(array $dados, bool $isEdicao = false): ?string
    {
        $nome  = trim($dados['nome']  ?? '');
        $login = trim($dados['login'] ?? '');
        $senha = $dados['senha'] ?? null;

        if (!$nome || !$login) {
            return "Campos obrigatórios ausentes.";
        }

        if (strlen($nome) < 3 || strlen($nome) > 100) {
            return "Nome inválido.";
        }

        if (!preg_match('/^[a-zA-Z0-9._]+$/', $login)) {
            return "Login inválido.";
        }

        if (!$isEdicao) {
            if (!$senha) {
                return "Senha é obrigatória.";
            }

            if (strlen($senha) < 8) {
                return "Senha deve ter no mínimo 8 caracteres.";
            }
        }

        if ($isEdicao && !empty($senha) && strlen($senha) < 8) {
            return "Senha deve ter no mínimo 8 caracteres.";
        }

        return null;
    }
}
