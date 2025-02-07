<?php
    ini_set('display_errors',1);
    ini_set('display_startup_erros',1);
    error_reporting(E_ALL);

    function openConnection() {
        $host = 'laradock-mysql-1';
        $dbname = 'ifpr';
        $username = 'root';
        $password = 'root';
    
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            return $pdo;
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }

    function createTableAndSeed() {
        $pdo = openConnection();
        $sqlCreateTable = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            email VARCHAR(150) UNIQUE NOT NULL,
            senha VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
    
        $sqlSeeder = "INSERT INTO users (nome, email, senha) VALUES
            ('Itamar Nieradka', 'itamar.nieradka@email.com', 'password'),
            ('Maria Oliveira', 'maria.oliveira@email.com', 'senha456'),
            ('Carlos Souza', 'carlos.souza@email.com', 'senha789'),
            ('Ana Lima', 'ana.lima@email.com', 'senha321'),
            ('Pedro Santos', 'pedro.santos@email.com', 'senha654')
        ";

        try {
            $pdo->exec($sqlCreateTable);
            echo "Tabela criada com sucesso!<br>";
    
            $stmt = $pdo->query("SELECT COUNT(*) FROM users");
            if ($stmt->fetchColumn() == 0) {
                $pdo->exec($sqlSeeder);
                echo "Seeder executado com sucesso!";
            } else {
                echo "Seeder já foi executado anteriormente!";
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

    createTableAndSeed();

?>
  