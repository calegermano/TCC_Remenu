<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - {{ config('app.name') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }
        
        .email-header {
            background: linear-gradient(135deg, #D9682B 0%, #55d6b0 100%);
            padding: 40px 20px;
            text-align: center;
            position: relative;
        }
        
        .logo-container {
            margin-bottom: 20px;
        }
        
        .logo-email {
            max-width: 180px;
            height: auto;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }
        
        .email-title {
            color: white;
            font-size: 28px;
            font-weight: 600;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .email-content {
            padding: 40px;
            color: #333;
        }
        
        .greeting {
            color: #D9682B;
            font-size: 22px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .message {
            color: #555;
            line-height: 1.6;
            margin-bottom: 30px;
            font-size: 16px;
        }
        
        .btn-container {
            text-align: center;
            margin: 35px 0;
        }
        
        .btn-reset {
            display: inline-block;
            background: linear-gradient(to right, #55d6b0, #4ac4a0);
            color: white;
            text-decoration: none;
            padding: 16px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(85, 214, 176, 0.3);
            border: none;
        }
        
        .btn-reset:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(85, 214, 176, 0.4);
            background: linear-gradient(to right, #4ac4a0, #3db390);
        }
        
        .warning-box {
            background-color: #fff8f4;
            border-left: 4px solid #D9682B;
            padding: 20px;
            margin: 25px 0;
            border-radius: 8px;
        }
        
        .warning-title {
            color: #D9682B;
            font-weight: 600;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .warning-text {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .expiration {
            color: #D9682B;
            font-weight: 600;
            margin-top: 8px;
        }
        
        .link-backup {
            word-break: break-all;
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            font-size: 14px;
            color: #666;
        }
        
        .email-footer {
            background-color: #f8f9fa;
            padding: 25px;
            text-align: center;
            border-top: 1px solid #e9ecef;
            color: #777;
            font-size: 14px;
        }
        
        .footer-links {
            margin-top: 15px;
        }
        
        .footer-links a {
            color: #55d6b0;
            text-decoration: none;
            margin: 0 10px;
        }
        
        .footer-links a:hover {
            color: #D9682B;
            text-decoration: underline;
        }
        
        @media (max-width: 600px) {
            .email-content {
                padding: 25px;
            }
            
            .email-header {
                padding: 30px 15px;
            }
            
            .btn-reset {
                padding: 14px 30px;
                width: 100%;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="logo-container">
                <img src="{{ $message->embed(public_path('assets/img/logobranca.png')) }}" alt="Logo" class="logo-email">
            </div>
            <h1 class="email-title">Redefinir Senha</h1>
        </div>
        
        <div class="email-content">
            <h2 class="greeting">Olá, {{ $name }}!</h2>
            
            <div class="message">
                <p>Recebemos uma solicitação para redefinir a senha da sua conta no <strong>{{ config('app.name') }}</strong>.</p>
                <p>Clique no botão abaixo para criar uma nova senha:</p>
            </div>
            
            <div class="btn-container">
                <a href="{{ $resetUrl }}" class="btn-reset">Redefinir Minha Senha</a>
            </div>
            
            <div class="warning-box">
                <div class="warning-title">
                    <span>⚠️</span> Importante
                </div>
                <p class="warning-text">
                    Se você não solicitou a redefinição de senha, por favor ignore este email.
                    <span class="expiration">Este link é válido por 60 minutos.</span>
                </p>
            </div>
            
            <p style="margin-bottom: 10px; color: #666; font-size: 14px;">
                Caso o botão não funcione, copie e cole o link abaixo no seu navegador:
            </p>
            <div class="link-backup">
                {{ $resetUrl }}
            </div>
            
            <p style="margin-top: 30px; color: #777; font-style: italic;">
                Atenciosamente,<br>
                <strong>Equipe {{ config('app.name') }}</strong>
            </p>
        </div>
        
        <div class="email-footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.</p>
            <div class="footer-links">
                <a href="{{ url('/') }}">Visitar Site</a> | 
                <a href="{{ url('/suporte') }}">Central de Ajuda</a> | 
                <a href="{{ url('/contato') }}">Contato</a>
            </div>
            <p style="margin-top: 15px; font-size: 12px; color: #999;">
                Esta é uma mensagem automática, por favor não responda este email.
            </p>
        </div>
    </div>
</body>
</html>