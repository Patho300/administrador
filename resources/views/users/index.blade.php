<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
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
        
        .btn-back {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid white;
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }
        
        .btn-back:hover {
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
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 30px;
        }
        
        .card-header h2 {
            font-size: 24px;
        }
        
        .card-body {
            padding: 30px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background: #f8f9fa;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        th {
            font-weight: 600;
            color: #555;
        }
        
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-admin {
            background: #667eea;
            color: white;
        }
        
        .badge-bodega {
            background: #f6ad55;
            color: white;
        }
        
        .badge-user {
            background: #48bb78;
            color: white;
        }
        
        .badge-active {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-inactive {
            background: #f8d7da;
            color: #721c24;
        }
        
        .btn {
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
            border: none;
            transition: opacity 0.3s;
        }
        
        .btn:hover {
            opacity: 0.8;
        }
        
        .btn-primary {
            background: #667eea;
            color: white;
        }
        
        .btn-warning {
            background: #f6ad55;
            color: white;
        }
        
        .btn-danger {
            background: #fc8181;
            color: white;
        }
        
        .actions {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>Gestión de Usuarios</h1>
        <a href="{{ route('home') }}" class="btn-back">← Volver al Home</a>
    </nav>
    
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
        @endif
        
        <div class="card">
            <div class="card-header">
                <h2>Lista de Usuarios</h2>
            </div>
            <div class="card-body">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Nivel</th>
                            <th>Estado</th>
                            <th>Último Acceso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>
                                <span class="badge 
                                    @if($user->user_level == 1) badge-admin
                                    @elseif($user->user_level == 2) badge-bodega
                                    @else badge-user
                                    @endif">
                                    {{ $user->getUserLevelName() }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $user->isActive() ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $user->isActive() ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                {{ $user->last_login ? $user->last_login->format('d/m/Y H:i') : 'Nunca' }}
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('users.edit-password', $user->id) }}" class="btn btn-primary">
                                        Cambiar Contraseña
                                    </a>
                                    
                                    @if($user->id !== auth()->id())
                                    <form action="{{ route('users.toggle-status', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn {{ $user->isActive() ? 'btn-danger' : 'btn-warning' }}">
                                            {{ $user->isActive() ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
