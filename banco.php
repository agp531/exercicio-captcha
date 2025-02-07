<?php
    ini_set('display_errors',1);
    ini_set('display_startup_erros',1);
    error_reporting(E_ALL);

    function openConnection()
    {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=ifpr', 'root', 'bancodedados');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Error'. $e->getMessage();
        }

        return $pdo;
    }

    function userSeeder()
    {
        $pdo = openConnection();

        $sql = "INSERT INTO ifpr.users (id, nome, email, senha) VALUES
            (1, 'João Silva', 'joao.silva@email.com', 'senha123'),
            (2, 'Maria Oliveira', 'maria.oliveira@email.com', 'senha456'),
            (3, 'Carlos Souza', 'carlos.souza@email.com', 'senha789'),
            (4, 'Ana Lima', 'ana.lima@email.com', 'senha321'),
            (5, 'Pedro Santos', 'pedro.santos@email.com', 'senha654')";

        try {
            $pdo->exec($sql);
            echo "Usuários inseridos com sucesso!";
        } catch (PDOException $e) {
            echo "Erro ao inserir usuários: " . $e->getMessage();
        }
    }

?>
  