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

            <h2>Cadastre-se</h2>

            @if ($errors->any())
                <div class="error-message">
                    <i class="bi bi-exclamation-triangle"></i>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Exibe mensagens de aviso gerais --}}
            @if (session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            @endif

            {{-- Exibe mensagem de sucesso se o link for reenviado --}}
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <!-- 1. O Formulário de cadastro termina AQUI -->
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-grid">
                    <div class="input-group">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" value="{{ old('nome', $formData['nome'] ?? '') }}" required>
                    </div>

                    <div class="input-group">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $formData['email'] ?? '') }}" required>
                    </div>

                    <div class="input-group">
                        <label for="senha">Senha:</label>
                        <input type="password" id="senha" name="senha" required>
                    </div>

                    <div class="input-group">
                        <label for="confirmar">Confirmar senha:</label>
                        <input type="password" id="confirmar" name="senha_confirmation" required>
                    </div>
                </div>

                <button type="submit" class="cconta-btn">Cadastrar</button>
            </form> 
            <!-- Fim do form principal -->

            <!-- 2. O Bloco de verificação fica FORA do form principal -->
            @if(session('verify_email'))
                <div class="alert alert-warning" style="margin-top: 20px;">
                    <p>Enviamos um link de verificação para: <strong>{{ session('email_registered') }}</strong></p>
                    <p>Verifique seu e-mail e clique no link para ativar sua conta.</p>

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button class="btn btn-primary">Reenviar e-mail</button>
                    </form>
                </div>
            @endif

            <div class="cconta-links">
                <a href="{{ route('senha') }}">Esqueci a senha</a>
                <span>|</span>
                <a href="{{ route('login.form') }}">Já tenho uma conta</a>
            </div>
            
        </div>
    </div>

</body>
</html><!DOCTYPE html>
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

            <h2>Cadastre-se</h2>

            @if ($errors->any())
                <div class="error-message">
                    <i class="bi bi-exclamation-triangle"></i>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-grid">
                    <div class="input-group">
                        <label for="nome">Nome completo:</label>
                        <input type="text" id="nome" name="nome" value="{{ old('nome', $formData['nome'] ?? '') }}" required>
                    </div>

                    <div class="input-group">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $formData['email'] ?? '') }}" required>
                    </div>

                    <div class="input-group">
                        <label for="senha">Senha:</label>
                        <input type="password" id="senha" name="senha" required>
                    </div>

                    <div class="input-group">
                        <label for="confirmar">Confirmar senha:</label>
                        <input type="password" id="confirmar" name="senha_confirmation" required>
                    </div>
                </div>

                <button type="submit" class="cconta-btn">Cadastrar</button>

                <div class="cconta-links">
                    <a href="{{ route('senha') }}">Esqueci a senha</a>
                    <span>|</span>
                    <a href="{{ route('login.form') }}">Já tenho uma conta</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>