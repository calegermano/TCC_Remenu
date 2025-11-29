<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - Remenu</title>
    <link rel="stylesheet" href="{{ asset('css/cconta.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="cconta-container">
        <div class="cconta-box">
            <h2>Redefinir Senha</h2>

            @if ($errors->any())
                <div class="error-message" style="color: red; margin-bottom: 15px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-grid">
                    <div class="input-group">
                        <label for="email">E-mail:</label>
                        <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" required readonly>
                    </div>

                    <div class="input-group">
                        <label for="password">Nova Senha:</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div class="input-group">
                        <label for="password_confirmation">Confirmar Nova Senha:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>

                <button type="submit" class="cconta-btn">Alterar Senha</button>
            </form>
        </div>
    </div>
</body>
</html>