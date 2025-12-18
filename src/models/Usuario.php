<?php

namespace src\models;

use \core\Model;
use core\Database;
use PDO;
use Throwable;

class Usuario extends Model {

    public function cadastro($dados)
    {
        $nome  = isset($dados['nome']) ? trim($dados['nome']) : null;
        $login = isset($dados['login']) ? trim($dados['login']) : null;
        $senha = $dados['senha'] ?? null;

        $nome = $this->formatarNome($nome);

        if (empty($nome) || empty($login) || empty($senha)) {
            return ['sucesso' => false, 'result' => 'Campos obrigatórios ausentes.'];
        }

        try {
            $check = Database::getInstance()
                ->prepare("SELECT COUNT(1) AS total FROM usuario WHERE login = :login");
            $check->execute([':login' => $login]);
            $row = $check->fetch(PDO::FETCH_ASSOC);

            if ($row && intval($row['total']) > 0) {
                return ['sucesso' => false, 'result' => 'Login já cadastrado.'];
            }

            $senhaHashed = password_get_info($senha)['algo']
                ? $senha
                : password_hash($senha, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuario (nome, login, senha, idsituacao)
                    VALUES (:nome, :login, :senha, 1)";

            $stmt = Database::getInstance()->prepare($sql);
            $stmt->execute([
                ':nome'  => $nome,
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
            $sql = "SELECT 
                        u.id, 
                        u.nome, 
                        u.login, 
                        u.idsituacao,
                        CASE 
                            WHEN u.idsituacao = 1 THEN 'Ativo' 
                            ELSE 'Inativo' 
                        END AS descricao
                    FROM usuario u";

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
        $id    = isset($dados['id']) ? intval($dados['id']) : null;
        $nome  = isset($dados['nome']) ? trim($dados['nome']) : null;
        $login = isset($dados['login']) ? trim($dados['login']) : null;
        $senha = $dados['senha'] ?? null;

        if (empty($id) || empty($nome) || empty($login)) {
            return ['sucesso' => false, 'result' => 'Parâmetros inválidos.'];
        }

        try {
            $params = [
                ':id'    => $id,
                ':nome'  => $nome,
                ':login' => $login
            ];

            $setParts = "nome = :nome, login = :login";

            if (!empty($senha)) {
                $senhaHashed = password_get_info($senha)['algo']
                    ? $senha
                    : password_hash($senha, PASSWORD_DEFAULT);

                $setParts .= ", senha = :senha";
                $params[':senha'] = $senhaHashed;
            }

            $sql = "UPDATE usuario SET {$setParts} WHERE id = :id";
            $stmt = Database::getInstance()->prepare($sql);
            $stmt->execute($params);

            return ['sucesso' => true, 'result' => 'Usuário atualizado com sucesso'];
        } catch (Throwable $error) {
            return ['sucesso' => false, 'result' => 'Falha ao atualizar usuário: ' . $error->getMessage()];
        }
    }

    public function updateSituacao($id, $idsituacao)
    {
        $idUsuario  = intval($id);
        $idsituacao = intval($idsituacao);

        if ($idUsuario <= 0) {
            return ['sucesso' => false, 'result' => 'ID inválido.'];
        }

        try {
            $sql = "UPDATE usuario 
                    SET idsituacao = :idsituacao 
                    WHERE id = :id";

            $stmt = Database::getInstance()->prepare($sql);
            $stmt->execute([
                ':idsituacao' => $idsituacao,
                ':id' => $idUsuario
            ]);

            return ['sucesso' => true, 'result' => 'Situação do usuário atualizada com sucesso'];
        } catch (Throwable $error) {
            return ['sucesso' => false, 'result' => 'Falha ao atualizar situação do usuário: ' . $error->getMessage()];
        }
    }

    public function loginExiste($login)
    {
        $sql = "SELECT id FROM usuario WHERE login = :login LIMIT 1";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindValue(':login', $login);
        $stmt->execute();

        return $stmt->fetch();
    }

    private function formatarNome(string $nome): string
    {
        $nome = trim($nome);

        return mb_strtoupper(mb_substr($nome, 0, 1, 'UTF-8'), 'UTF-8')
            . mb_substr($nome, 1, null, 'UTF-8');
    }
}
