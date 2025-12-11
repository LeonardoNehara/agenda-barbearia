<?php

namespace src\models;

use \core\Model;
use core\Database;
use PDO;
use Throwable;

class Usuario extends Model {
    
    public function cadastro($dados)
    {
        $nome = isset($dados['nome']) ? trim($dados['nome']) : null;
        $login = isset($dados['login']) ? trim($dados['login']) : null;
        $senha = isset($dados['senha']) ? $dados['senha'] : null;

        if (empty($nome) || empty($login) || empty($senha)) {
            return ['sucesso' => false, 'result' => 'Campos obrigatórios ausentes.'];
        }

        try {
            $check = Database::getInstance()->prepare("SELECT COUNT(1) as total FROM usuarios WHERE login = :login");
            $check->execute([':login' => $login]);
            $row = $check->fetch(PDO::FETCH_ASSOC);
            if ($row && intval($row['total']) > 0) {
                return ['sucesso' => false, 'result' => 'Login já cadastrado.'];
            }

            if (!password_get_info($senha)['algo']) {
                $senhaHashed = password_hash($senha, PASSWORD_DEFAULT);
            } else {
                $senhaHashed = $senha;
            }

            $sql = "INSERT INTO usuarios (nome, login, senha, idsituacao)
                    VALUES (:nome, :login, :senha, 1)";

            $stmt = Database::getInstance()->prepare($sql);
            $stmt->execute([
                ':nome' => $nome,
                ':login' => $login,
                ':senha' => $senhaHashed
            ]);

            return ['sucesso' => true, 'result' => 'Usuário cadastrado com sucesso'];
        } catch (Throwable $error) {
            return ['sucesso' => false, 'result' => 'Falha ao cadastrar: ' . $error->getMessage()];
        }
    }

    public function getusuarios()
    {
        try {
            $sql = "SELECT u.idusuario, u.nome, u.login, u.idsituacao,
                        CASE WHEN u.idsituacao = 1 THEN 'Ativo' ELSE 'Inativo' END AS descricao
                    FROM usuarios u";
            $stmt = Database::getInstance()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return ['sucesso' => true, 'result' => $result];
        } catch (Throwable $error) {
            return ['sucesso' => false, 'result' => 'Falha ao buscar usuários: ' . $error->getMessage()];
        }
    }

    public function editar($dados)
    {
        $idusuario = isset($dados['idusuario']) ? intval($dados['idusuario']) : null;
        $nome = isset($dados['nome']) ? trim($dados['nome']) : null;
        $login = isset($dados['login']) ? trim($dados['login']) : null;
        $senha = isset($dados['senha']) ? $dados['senha'] : null; // pode estar vazio -> não altera

        if (empty($idusuario) || empty($nome) || empty($login)) {
            return ['sucesso' => false, 'result' => 'Parâmetros inválidos.'];
        }

        try {
            $params = [':idusuario' => $idusuario, ':nome' => $nome, ':login' => $login];
            $setParts = "nome = :nome, login = :login";

            if (!empty($senha)) {
                // Hash se necessário
                if (!password_get_info($senha)['algo']) {
                    $senhaHashed = password_hash($senha, PASSWORD_DEFAULT);
                } else {
                    $senhaHashed = $senha;
                }
                $setParts .= ", senha = :senha";
                $params[':senha'] = $senhaHashed;
            }

            $sql = "UPDATE usuarios SET {$setParts} WHERE idusuario = :idusuario";
            $stmt = Database::getInstance()->prepare($sql);
            $stmt->execute($params);

            return ['sucesso' => true, 'result' => 'Usuário atualizado com sucesso'];
        } catch (Throwable $error) {
            return ['sucesso' => false, 'result' => 'Falha ao atualizar usuário: ' . $error->getMessage()];
        }
    }

    public function updateSituacao($id, $idsituacao)
    {
        $idusuario = intval($id);
        $idsitu = intval($idsituacao);

        if ($idusuario <= 0) {
            return ['sucesso' => false, 'result' => 'idusuario inválido.'];
        }

        try {
            $sql = "UPDATE usuarios SET idsituacao = :idsituacao WHERE idusuario = :idusuario";
            $stmt = Database::getInstance()->prepare($sql);
            $stmt->execute([
                ':idsituacao' => $idsitu,
                ':idusuario' => $idusuario
            ]);

            return ['sucesso' => true, 'result' => 'Situação do usuário atualizada com sucesso'];
        } catch (Throwable $error) {
            return ['sucesso' => false, 'result' => 'Falha ao atualizar situação do usuário: ' . $error->getMessage()];
        }
    }

}
