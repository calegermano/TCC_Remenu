<?php
session_start();

if (isset($_SESSION['admin_id'])) {
    header("Location: admin/dashboard.php");
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'config/database.php';
    
    $usuario = trim($_POST['usuario']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    $confirmar = trim($_POST['confirmar']);
    
    if (empty($nome) || empty($email) || empty($senha) || empty($confirmar)) {
        $erro = 'Por favor, preencha todos os campos.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'E-mail inválido.';
    } elseif ($senha !== $confirmar) {
        $erro = 'As senhas não coincidem.';
    } else {
        $query = $conn->prepare("SELECT id FROM admins WHERE email = ?");
        $query->bind_param("s", $email);
        $query->execute();
        $query->store_result();

        if ($query->num_rows > 0) {
            $erro = 'Este e-mail já está cadastrado.';
        } else {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO admins (nome, email, senha) VALUES (?, ?, ?)");
            $insert->bind_param("sss", $nome, $email, $senha_hash);

            if ($insert->execute()) {
                $sucesso = 'Conta criada com sucesso!';
            } else {
                $erro = 'Erro ao criar conta. Tente novamente.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remenu</title>
    <link rel="stylesheet" href="{{ asset('css/cconta.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>

    <div class="cconta-container">
        <div class="logo">
            <img src="{{ asset('assets/img/logobranca.png') }}" alt="Logo Remenu" id="top-logo">
        </div>

        <div class="cconta-box">

            <h2>Recuperar Senha</h2>

            <?php if ($erro): ?>
                <div class="error-message">
                    <i class="bi bi-exclamation-triangle"></i>
                    <?php echo htmlspecialchars($erro); ?>
                </div>
            <?php endif; ?>

<form method="POST" action="">
                <div class="form-grid">
                    <div class="input-group">
                        <label for="nome">Nome completo:</label>
                        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>
                    </div>

                    <div class="input-group">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                    </div>

                    <div class="input-group">
                        <label for="senha">Senha:</label>
                        <input type="password" id="senha" name="senha" required>
                    </div>

                    <div class="input-group">
                        <label for="confirmar">Confirmar senha:</label>
                        <input type="password" id="confirmar" name="confirmar" required>
                    </div>
                </div>

                <button type="submit" class="cconta-btn" >Entrar</button>

                <div class="cconta-links">
                    <a href="{{ asset('/login')}}">Login</a>
                    <span>|</span>
                    <a href="{{ asset('/register')}}">Cadastre-se</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>