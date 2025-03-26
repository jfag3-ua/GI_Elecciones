<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Eleccions Valencianas')</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <link rel="stylesheet" href="/css/custom.css">
</head>
<body>
    <header>
        <nav>
            {{-- Enlace siempre visible --}}
            <a href="{{ route('landing') }}">Bienvenido</a>

            {{-- Invitados: ni admin ni web --}}
            @guest('admin')
                @guest('web')
                    <a href="{{ route('inicio') }}">Iniciar sesión</a>
                    <a href="{{ route('registro2.form') }}">Registrarse</a>
                @endguest
            @endguest

            {{-- Menú para admin (guard admin) --}}
            @auth('admin')
                <a href="{{ route('administracion') }}">Administrar</a>
                <a href="{{ route('encuestas') }}">Encuestas</a>
                <a href="{{ route('resultados') }}">Resultados</a>
                <a href="{{ route('usuario') }}">Usuario</a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Cerrar sesión</button>
                </form>
            @endauth

            {{-- Menú para usuario (guard web) --}}
            @auth('web')
                <a href="{{ route('voto') }}">Votar</a>
                <a href="{{ route('encuestas') }}">Encuestas</a>
                <a href="{{ route('resultados') }}">Resultados</a>
                <a href="{{ route('usuario') }}">Usuario</a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Cerrar sesión</button>
                </form>
            @endauth
        </nav>
    </header>
    <main>
        @yield('content') <!-- Aquí se mostrará el contenido de cada vista específica -->
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; TaxFraud. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
