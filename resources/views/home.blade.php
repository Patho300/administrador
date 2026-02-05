<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Sistema de Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px 30px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .navbar h1 {
            font-size: 24px;
        }
        
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
        
        .user-name {
            font-weight: 600;
        }
        
        .user-level {
            font-size: 12px;
            opacity: 0.9;
        }
        
        .btn-logout {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid white;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .btn-logout:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .welcome-card {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .welcome-card h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 32px;
        }
        
        .welcome-card p {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .info-card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .info-card h3 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 18px;
        }
        
        .info-card p {
            color: #666;
            font-size: 14px;
        }
        
        .admin-link {
            margin-top: 30px;
            text-align: center;
        }
        
        .btn-admin {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.2s;
        }
        
        .btn-admin:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>Sistema de Gestión</h1>
        <div class="navbar-right">
            <div class="user-info">
                <span class="user-name">{{ auth()->user()->name }}</span>
                <span class="user-level">{{ auth()->user()->getUserLevelName() }}</span>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">Cerrar Sesión</button>
            </form>
        </div>
    </nav>
    
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        
        <div class="welcome-card">
            <h2>¡Bienvenido, {{ auth()->user()->name }}!</h2>
            <p>Has iniciado sesión exitosamente en el sistema.</p>
            <p>Último acceso: {{ auth()->user()->last_login ? auth()->user()->last_login->format('d/m/Y H:i:s') : 'Primera vez' }}</p>
        </div>
        
        <div class="info-grid">
            <div class="info-card">
                <h3>Tu Perfil</h3>
                <p><strong>Usuario:</strong> {{ auth()->user()->username }}</p>
                <p><strong>Nivel:</strong> {{ auth()->user()->getUserLevelName() }}</p>
                <p><strong>Estado:</strong> {{ auth()->user()->isActive() ? 'Activo' : 'Inactivo' }}</p>
            </div>
            
            <div class="info-card">
                <h3>Información del Sistema</h3>
                <p>Este es un sistema básico de autenticación con tres niveles de usuario.</p>
                <p>Laravel Framework</p>
            </div>
            
            <div class="info-card">
                <h3>Permisos</h3>
                <p>
                    @if(auth()->user()->isAdmin())
                        Tienes acceso completo al sistema, incluyendo la gestión de usuarios y cambio de contraseñas.
                    @else
                        Tu nivel de acceso es {{ auth()->user()->getUserLevelName() }}.
                    @endif
                </p>
            </div>
        </div>
        
        @if(auth()->user()->isAdmin())
        <div class="admin-link">
            <a href="{{ route('users.index') }}" class="btn-admin">Gestionar Usuarios</a>
        </div>
        @endif
    </div>
</body>
</html>
