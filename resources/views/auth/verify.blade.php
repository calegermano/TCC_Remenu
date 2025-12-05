<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifique seu Email - {{ config('app.name') }}</title>
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
            background: linear-gradient(135deg, #55d6b0 0%, #D9682B 100%);
            padding: 40px 20px;
            text-align: center;
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
        }
        
        .email-subtitle {
            color: rgba(255,255,255,0.9);
            font-size: 16px;
            margin-top: 10px;
            font-weight: 400;
        }
        
        .email-content {
            padding: 40px;
            color: #333;
        }
        
        .welcome-title {
            color: #55d6b0;
            font-size: 24px;
            margin-bottom: 15px;
            text-align: center;
        }
        
        .user-greeting {
            color: #D9682B;
            font-size: 20px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 500;
        }
        
        .message {
            color: #555;
            line-height: 1.6;
            margin-bottom: 25px;
            text-align: center;
            font-size: 16px;
        }
        
        .btn-container {
            text-align: center;
            margin: 35px 0;
        }
        
        .btn-verify {
            display: inline-block;
            background: linear-gradient(to right, #D9682B, #c55c24);
            color: white;
            text-decoration: none;
            padding: 16px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(217, 104, 43, 0.3);
        }
        
        .btn-verify:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(217, 104, 43, 0.4);
            background: linear-gradient(to right, #c55c24, #b55220);
        }
        
        .steps-container {
            background-color: #f0f9f7;
            border-radius: 10px;
            padding: 25px;
            margin: 30px 0;
            border-left: 4px solid #55d6b0;
        }
        
        .steps-title {
            color: #55d6b0;
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .steps-list {
            padding-left: 20px;
            color: #555;
        }
        
        .steps-list li {
            margin-bottom: 10px;
            line-height: 1.5;
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
        
        .features {
            display: flex;
            justify-content: space-around;
            margin: 30px 0;
            flex-wrap: wrap;
            gap: 20px;
        }
        
        .feature {
            text-align: center;
            flex: 1;
            min-width: 150px;
        }
        
        .feature-icon {
            font-size: 24px;
            color: #55d6b0;
            margin-bottom: 10px;
        }
        
        .feature-text {
            color: #555;
            font-size: 14px;
        }
        
        @media (max-width: 600px) {
            .email-content {
                padding: 25px;
            }
            
            .email-header {
                padding: 30px 15px;
            }
            
            .btn-verify {
                padding: 14px 30px;
                width: 100%;
            }
            
            .features {
                flex-direction: column;
                gap: 15px;
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
            <h1 class="email-title">Bem-vindo ao {{ config('app.name') }}!</h1>
            <p class="email-subtitle">O sabor certo, na hora certa</p>
        </div>
        
        <div class="email-content">
            <h2 class="user-greeting">Olá, {{ $name }}!</h2>
            <h3 class="welcome-title">Verifique seu endereço de email</h3>
            
            <div class="message">
                <p>Obrigado por se cadastrar! Para ativar sua conta e acessar todos os recursos, precisamos confirmar que este é seu email.</p>
            </div>
            
            <div class="btn-container">
                <a href="{{ $verificationUrl }}" class="btn-verify">Confirmar Email</a>
            </div>
            
            <div class="steps-container">
                <div class="steps-title">
                    <span>📋</span> Como ativar sua conta:
                </div>
                <ol class="steps-list">
                    <li>Clique no botão "Confirmar Email" acima</li>
                    <li>Você será redirecionado para nossa plataforma</li>
                    <li>Sua conta será ativada automaticamente</li>
                    <li>Pronto! Faça login e comece a usar</li>
                </ol>
            </div>
            
            <div class="features">
                <div class="feature">
                    <div class="feature-icon">⚡</div>
                    <div class="feature-text">Acesso Rápido</div>
                </div>
                <div class="feature">
                    <div class="feature-icon">🔒</div>
                    <div class="feature-text">Segurança</div>
                </div>
                <div class="feature">
                    <div class="feature-icon">🎯</div>
                    <div class="feature-text">Recursos Exclusivos</div>
                </div>
            </div>
            
            <p style="text-align: center; margin: 20px 0 10px; color: #666; font-size: 14px;">
                Problemas com o botão? Copie este link:
            </p>
            <div class="link-backup">
                {{ $verificationUrl }}
            </div>
            
            <p style="text-align: center; margin-top: 30px; color: #777; font-style: italic;">
                Estamos felizes em tê-lo conosco!<br>
                <strong>Equipe {{ config('app.name') }}</strong>
            </p>
        </div>
        
        <div class="email-footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>