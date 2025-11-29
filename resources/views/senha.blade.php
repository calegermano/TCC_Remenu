<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - Remenu</title>
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

            {{-- Mensagem de sucesso (Link enviado) --}}
            @if (session('status'))
                <div class="alert alert-success" style="margin-bottom: 20px; color: green;">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Mensagens de erro --}}
            @if ($errors->any())
                <div class="error-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-grid">
                    <p style="margin-bottom: 20px; font-size: 0.9rem;">
                        Digite seu e-mail cadastrado e enviaremos um link para você redefinir sua senha.
                    </p>
                    
                    <div class="input-group">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <button type="submit" class="cconta-btn">Enviar Link</button>

                <div class="cconta-links">
                    <a href="{{ route('login.form') }}">Voltar para o Login</a>
                    <span>|</span>
                    <a href="{{ route('register.form') }}">Cadastre-se</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>