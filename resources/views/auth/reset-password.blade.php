<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - Remenu</title>
    <link rel="stylesheet" href="{{ asset('css/cconta.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">

    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="cconta-container">
        <!-- Logo centralizada -->
        <div class="logo">
            <img src="{{ asset('assets/img/logobranca.png') }}" alt="Logo Remenu" id="top-logo">
        </div>

        <div class="cconta-box">
            <h2>Redefinir Senha</h2>

            @if ($errors->any())
                <div class="alert alert-danger" style="color: red; margin-bottom: 15px; text-align: center;">
                    <ul style="list-style: none; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Classe form-vertical para garantir um embaixo do outro -->
                <div class="form-vertical">
                    
                    <div class="input-group">
                        <label for="email">E-mail:</label>
                        <!-- Adicionei a classe 'readonly-input' para estilizar diferente -->
                        <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" required readonly class="readonly-input">
                    </div>

                    <div class="input-group">
                        <label for="password">Nova Senha:</label>
                        <input type="password" id="password" name="password" required placeholder="Digite sua nova senha">
                    </div>

                    <div class="input-group">
                        <label for="password_confirmation">Confirmar Nova Senha:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Repita a nova senha">
                    </div>

                </div>

                <button type="submit" class="cconta-btn">Alterar Senha</button>
            </form>
        </div>
    </div>

</body>
</html>