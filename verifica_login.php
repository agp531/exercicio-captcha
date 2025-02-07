<?php
session_start();
require_once 'banco.php';


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }

    if ($_SESSION['login_attempts'] >= 3) {
        if (!isset($_POST['captcha']) || $_POST['captcha'] != $_SESSION['captcha']) {
            $_SESSION['login_attempts']++;
            header("Location: index.html?erro=captcha");
            exit();
        }
    }

    try {
        $pdo = openConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND senha = ?");
        $stmt->execute([$email, $senha]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['login_attempts'] = 0;
            $_SESSION['user_email'] = $email;
            header("Location: bem_vindo.html");
        } else {
            $_SESSION['login_attempts']++;
            header("Location: index.html?erro=credenciais");
        }
    } catch (PDOException $e) {
        header("Location: index.html?erro=conexao");
    }
}
?>