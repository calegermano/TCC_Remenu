<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifique seu Email - {{ config('app.name') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #f8f9fa; padding: 20px; }
        .email-container { max-width: 600px; margin: 0 auto; background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 30px rgba(0,0,0,0.08); }
        .email-header { background: linear-gradient(135deg, #55d6b0 0%, #D9682B 100%); padding: 40px 20px; text-align: center; }
        .logo-email { max-width: 180px; height: auto; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1)); }
        .user-greeting { color: #D9682B; font-size: 20px; margin-bottom: 25px; text-align: center; font-weight: 500; }
        .btn-verify { display: inline-block; background: linear-gradient(to right, #D9682B, #c55c24); color: white; text-decoration: none; padding: 16px 40px; border-radius: 50px; font-weight: 600; transition: all 0.3s ease; }
        .email-footer { background-color: #f8f9fa; padding: 25px; text-align: center; border-top: 1px solid #e9ecef; color: #777; }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="{{ $message->embed(public_path('assets/img/logobranca.png')) }}" alt="Logo" class="logo-email">
            <h1 style="color: white; font-size: 28px;">Bem-vindo ao {{ config('app.name') }}!</h1>
        </div>
        
        <div class="email-content" style="padding: 40px;">
            <h2 class="user-greeting">Olá, {{ $nome }}!</h2>
            <p style="text-align: center;">Verifique seu email para ativar sua conta:</p>
            
            <div style="text-align: center; margin: 35px 0;">
                <a href="{{ $verificationUrl }}" class="btn-verify">Confirmar Email</a>
            </div>
            
            <p style="text-align: center; margin-top: 30px; color: #777;">
                Estamos felizes em tê-lo conosco!<br>
                <strong>Equipe {{ config('app.name') }}</strong>
            </p>
        </div>
        
        <div class="email-footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>