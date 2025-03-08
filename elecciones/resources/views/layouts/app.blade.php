<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Elecciones Valencianas')</title> <!-- Título por defecto -->
</head>
<body>
    <header>
        <nav>
            <a href="{{ route('landing') }}">Landing</a> |
            @guest
                <a href="{{ route('inicio') }}">Iniciar sesión</a> |
                <a href="{{ route('registro') }}">Registrarse</a>
            @endguest
            @auth
                <a href="{{ route('voto') }}">Votar</a> |
                <a href="{{ route('encuestas') }}">Encuestas</a> |
                <a href="{{ route('resultados') }}">Resultados</a> |
                <a href="{{ route('administracion') }}">Administrar</a> |
                <a href="{{ route('usuario') }}">Usuario</a> |
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Cerrar sesión</button>
                </form>
            @endauth
        </nav>
    </header>

    <!---
    @if(Auth::check())
        <p>Usuario autenticado</p>
    @else
        <p>No hay usuario autenticado</p>
    @endif
    -->

    <main>
        @yield('content') <!-- Aquí se mostrará el contenido de cada vista específica -->
    </main>
</body>
</html>
