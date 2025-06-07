<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Restablecer Contraseña - JSM Connect</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif;
            line-height: 1.6;
            color: #334155;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 20px;
            min-height: 100vh;
        }
        
        .email-wrapper {
            max-width: 650px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            position: relative;
        }
        
        .email-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #104CFF, #0940e6, #0733cc, #F59E0B);
        }
        
        .header {
            background: linear-gradient(135deg, #104CFF 0%, #0940e6 100%);
            color: white;
            padding: 60px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: repeating-linear-gradient(
                45deg,
                rgba(255,255,255,0.03),
                rgba(255,255,255,0.03) 1px,
                transparent 1px,
                transparent 30px
            );
            animation: float 20s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(1deg); }
        }
        
        .logo-container {
            background: rgba(255, 255, 255, 0.15);
            width: 80px;
            height: 80px;
            border-radius: 20px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 1;
        }
        
        .logo-container::before {
            content: '🔐';
            font-size: 36px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }
        
        .header h1 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .header .subtitle {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 400;
            position: relative;
            z-index: 1;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        
        .content {
            padding: 50px 40px;
            background: #ffffff;
        }
        
        .greeting {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 16px;
            color: #1e293b;
            background: linear-gradient(135deg, #104CFF, #0940e6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .message {
            font-size: 17px;
            margin-bottom: 32px;
            line-height: 1.7;
            color: #475569;
        }
        
        .message strong {
            color: #1e293b;
            font-weight: 600;
        }
        
        .button-container {
            text-align: center;
            margin: 50px 0;
        }
        
        .reset-button {
            display: inline-block;
            background: linear-gradient(135deg, #104CFF 0%, #0940e6 100%);
            color: white;
            text-decoration: none;
            padding: 18px 40px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 25px rgba(16, 76, 255, 0.3);
            position: relative;
            overflow: hidden;
            border: none;
            cursor: pointer;
        }
        
        .reset-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .reset-button:hover::before {
            left: 100%;
        }
        
        .reset-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(16, 76, 255, 0.4);
        }
        
        .button-text {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .expiry-notice {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 2px solid #f59e0b;
            border-radius: 16px;
            padding: 20px;
            margin: 30px 0;
            color: #92400e;
            font-size: 15px;
            text-align: center;
            font-weight: 500;
        }
        
        .expiry-notice::before {
            content: '⏰';
            font-size: 20px;
            margin-right: 8px;
        }
        
        .security-info {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 2px solid #0ea5e9;
            border-radius: 16px;
            padding: 20px;
            margin: 30px 0;
            color: #0c4a6e;
            font-size: 14px;
        }
        
        .security-info h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #0c4a6e;
        }
        
        .security-info ul {
            list-style: none;
            padding: 0;
        }
        
        .security-info li {
            padding: 4px 0;
            position: relative;
            padding-left: 20px;
        }
        
        .security-info li::before {
            content: '🔒';
            position: absolute;
            left: 0;
            font-size: 12px;
        }
        
        .footer {
            background: #f8fafc;
            padding: 40px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        
        .footer .company-info {
            margin-bottom: 20px;
        }
        
        .footer .company-name {
            font-size: 18px;
            font-weight: 700;
            color: #104CFF;
            margin-bottom: 8px;
        }
        
        .footer .company-tagline {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 20px;
        }
        
        .footer .contact-info {
            font-size: 13px;
            color: #64748b;
            line-height: 1.5;
        }
        
        .footer .contact-info a {
            color: #104CFF;
            text-decoration: none;
        }
        
        .footer .contact-info a:hover {
            text-decoration: underline;
        }
        
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e2e8f0, transparent);
            margin: 30px 0;
        }
        
        .alternative-link {
            background: #f8fafc;
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 20px;
            margin: 30px 0;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
        
        .alternative-link p {
            margin-bottom: 10px;
            font-weight: 500;
        }
        
        .alternative-link code {
            background: #e5e7eb;
            padding: 4px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            word-break: break-all;
            display: inline-block;
            margin-top: 8px;
        }
        
        /* Responsive Design */
        @media only screen and (max-width: 600px) {
            body {
                padding: 20px 10px;
            }
            
            .email-wrapper {
                border-radius: 16px;
            }
            
            .header, .content, .footer {
                padding: 30px 20px;
            }
            
            .header h1 {
                font-size: 28px;
            }
            
            .greeting {
                font-size: 20px;
            }
            
            .message {
                font-size: 16px;
            }
            
            .reset-button {
                padding: 16px 32px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <div class="logo-container"></div>
            <h1>JSM Connect</h1>
            <p class="subtitle">Restablecimiento de Contraseña</p>
        </div>
        
        <div class="content">
            <div class="greeting">
                ¡Hola {{ $user->nombre }}!
            </div>
            
            <div class="message">
                Hemos recibido una solicitud para <strong>restablecer la contraseña</strong> de tu cuenta en JSM Connect.
                <br><br>
                Si fuiste tú quien solicitó este cambio, haz clic en el botón de abajo para crear una nueva contraseña segura:
            </div>
            
            <div class="button-container">
                <a href="{{ $actionUrl }}" class="reset-button">
                    <span class="button-text">
                        🔑 Restablecer mi Contraseña
                    </span>
                </a>
            </div>
            
            <div class="expiry-notice">
                Este enlace expirará en <strong>{{ $expireTime }} minutos</strong> por seguridad.
            </div>
            
            <div class="security-info">
                <h3>🛡️ Información de Seguridad</h3>
                <ul>
                    <li>Si no solicitaste este cambio, ignora este email</li>
                    <li>Tu contraseña actual no ha sido modificada</li>
                    <li>Este enlace solo funciona una vez</li>
                    <li>Usa una contraseña segura con al menos 8 caracteres</li>
                </ul>
            </div>
            
            <div class="divider"></div>
            
            <div class="alternative-link">
                <p><strong>¿El botón no funciona?</strong></p>
                <p>Copia y pega este enlace en tu navegador:</p>
                <code>{{ $actionUrl }}</code>
            </div>
        </div>
        
        <div class="footer">
            <div class="company-info">
                <div class="company-name">JSM Connect</div>
                <div class="company-tagline">Conectando profesionales, creando oportunidades</div>
            </div>
            
            <div class="contact-info">
                Si tienes alguna pregunta o necesitas ayuda, contáctanos en:<br>
                <a href="mailto:soporte@jsmconnect.com">soporte@jsmconnect.com</a>
                <br><br>
                Este es un email automático, por favor no respondas a esta dirección.
                <br>
                © {{ date('Y') }} JSM Connect. Todos los derechos reservados.
            </div>
        </div>
    </div>
</body>
</html> 