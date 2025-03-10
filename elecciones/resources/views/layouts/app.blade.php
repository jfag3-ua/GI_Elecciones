<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Eleccions Valencianas')</title> <!-- Título por defecto -->
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <link rel="stylesheet" href="/css/custom.css">
</head>
<body>
    <header>
        <nav>
            <a href="{{ route('landing') }}">Bienvenido</a>
            @guest
                <a href="{{ route('inicio') }}">Iniciar sesión</a>
                <a href="{{ route('registro') }}">Registrarse</a>
            @endguest
            @auth
                @if(session()->get('tipo_usuario') === 'user')
                    <a href="{{ route('voto') }}">Votar</a>
                @endif
                <a href="{{ route('encuestas') }}">Encuestas</a>
                <a href="{{ route('resultados') }}">Resultados</a>
                @if(session()->get('tipo_usuario') === 'admin')
                    <a href="{{ route('voto') }}">Votar</a>
                @endif
                <a href="{{ route('administracion') }}">Administrar</a>
                <a href="{{ route('usuario') }}">Usuario</a>
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
<footer>
    <div class="footer-content">
        <p>&copy; TaxFraud. Todos los derechos reservados.</p>
    </div>
</footer>
</html>
