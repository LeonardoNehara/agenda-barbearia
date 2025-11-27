<?php

namespace src\models;

use \core\Model;
use core\Database;
use PDO;
use Throwable;

class Login extends Model
{
    public function logar($dados)
    {
        try {
            $pdo = Database::getInstance();

            $sql = "SELECT u.idusuario, u.nome, u.senha
                    FROM usuarios u
                    WHERE u.login = :login
                      AND u.idsituacao = 1
                    LIMIT 1";

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':login', $dados['login']);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return [
                    'sucesso' => true,
                    'result' => $result
                ];
            } else {
                return [
                    'sucesso' => false,
                    'result' => null,
                    'msg' => 'Usuário não encontrado ou inativo'
                ];
            }

        } catch (Throwable $error) {
            return [
                'sucesso' => false,
                'result' => null,
                'msg' => 'Falha ao Logar: ' . $error->getMessage()
            ];
        }
    }
}
