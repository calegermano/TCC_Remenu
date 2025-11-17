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

            @if ($errors->any())
                <div class="error-message">
                    <i class="bi bi-exclamation-triangle"></i>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            {{-- removi o código puro de php, pois o Laravel AuthController faz esse trabalho --}}
            
            <form method="POST" action="{{ route('login') }}">
                @csrf  {{-- Token CSRF para segurança --}}
                
                <div class="input-group">
                    <label for="email">E-mail:</label>
                    <input type="text" id="email" name="email" required 
                        value="{{ old('email') }}"> {{-- Usando old('email') para manter o valor em caso de erro --}}
                </div>
                
                <div class="input-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                </div>
                
                <button type="submit" class="login-btn">
                    Entrar
                </button>

                <div class="login-links">
                    <a href="{{ asset('/senha')}}">Esqueci a senha</a>
                    <span>|</span>
                    <a href="{{ asset('/conta')}}">Criar conta</a>
                </div>
            </form>
        </div>

    </div>

</body>
</html>
