<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - {{ config('app.name') }}</title>
    <style>
        /* Estilos completos do email (conforme fornecido anteriormente) */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #f8f9fa; padding: 20px; }
        .email-container { max-width: 600px; margin: 0 auto; background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 8px 30px rgba(0,0,0,0.08); }
        .email-header { background: linear-gradient(135deg, #D9682B 0%, #55d6b0 100%); padding: 40px 20px; text-align: center; }
        .logo-email { max-width: 180px; height: auto; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1)); }
        .email-title { color: white; font-size: 28px; font-weight: 600; margin: 0; }
        .email-content { padding: 40px; color: #333; }
        .greeting { color: #D9682B; font-size: 22px; margin-bottom: 20px; font-weight: 500; }
        .btn-reset { display: inline-block; background: linear-gradient(to right, #55d6b0, #4ac4a0); color: white; text-decoration: none; padding: 16px 40px; border-radius: 50px; font-weight: 600; transition: all 0.3s ease; }
        .email-footer { background-color: #f8f9fa; padding: 25px; text-align: center; border-top: 1px solid #e9ecef; color: #777; }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="{{ $message->embed(public_path('assets/img/logobranca.png')) }}" alt="Logo" class="logo-email">
            <h1 class="email-title">Redefinir Senha</h1>
        </div>
        
        <div class="email-content">
            <h2 class="greeting">Olá, {{ $nome }}!</h2>
            <p>Recebemos uma solicitação para redefinir sua senha.</p>
            
            <div style="text-align: center; margin: 35px 0;">
                <a href="{{ $resetUrl }}" class="btn-reset">Redefinir Minha Senha</a>
            </div>
            
            <p style="margin-top: 30px; color: #777;">
                Atenciosamente,<br>
                <strong>Equipe {{ config('app.name') }}</strong>
            </p>
        </div>
        
        <div class="email-footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>