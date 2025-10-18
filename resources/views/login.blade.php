<?php
session_start();

// Se já estiver logado, redirecionar para o painel
if (isset($_SESSION['admin_id'])) {
    header("Location: admin/dashboard.php");
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'config/database.php';
    
    $usuario = trim($_POST['usuario']);
    $senha = $_POST['senha'];
    
    if (empty($usuario) || empty($senha)) {
        $erro = 'Por favor, preencha todos os campos.';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id, usuario, senha FROM usuarios WHERE usuario = ?");
            $stmt->execute([$usuario]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($senha, $user['senha'])) {
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_usuario'] = $user['usuario'];
                header("Location: admin/dashboard.php");
                exit;
            } else {
                $erro = 'Usuário ou senha incorretos.';
            }
        } catch (PDOException $e) {
            $erro = 'Erro no sistema. Tente novamente.';
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
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>

    <div class="login-container">
        <div class="logo">
            <img src="{{ asset('assets/img/logobranca.png') }}" alt="Logo Remenu" id="top-logo">
</div>
        <div class="login-box">
                <h2>Login</h2>
            </div>
            
            <?php if ($erro): ?>
                <div class="error-message">
                    <i class="bi bi-exclamation-triangle"></i>
                    <?php echo htmlspecialchars($erro); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="input-group">
                    <label for="email">E-mail:</label>
                    <input type="text" id="email" name="email" required 
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['usuario']) : ''; ?>">
                </div>
                
                <div class="input-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                </div>
                
                <button type="submit" class="login-btn">
                    Entrar
                </button>
                <div class="login-links">
                    <a href="#">Esqueci a senha</a>
                            <span>|</span>
                    <a href="#">Criar conta</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>