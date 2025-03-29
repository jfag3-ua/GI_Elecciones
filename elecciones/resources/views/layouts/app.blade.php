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
            <a href="{{ route('landing') }}" class="{{ request()->routeIs('landing') ? 'current' : '' }}">Bienvenido</a>

            {{-- Invitados: ni admin ni web --}}
            @guest('admin')
                @guest('web')
                    <a href="{{ route('resultados') }}" class="{{ request()->routeIs('resultados') ? 'current' : '' }}">Resultados</a>
                    <a href="{{ route('encuestas') }}" class="{{ request()->routeIs('encuestas') ? 'current' : '' }}">Encuestas</a>
                    <a href="{{ route('inicio') }}" class="{{ request()->routeIs('inicio') ? 'current' : '' }}">Iniciar sesión</a>
                    <a href="{{ route('registro2.form') }}" class="{{ request()->routeIs('registro2.form') ? 'current' : '' }}">Registrarse</a>
                @endguest
            @endguest

            {{-- Menú para admin (guard admin) --}}
            @auth('admin')
                <a href="{{ route('administracion') }}" class="{{ request()->routeIs('administracion') ? 'current' : '' }}">Administrar</a>
                <a href="{{ route('resultados') }}" class="{{ request()->routeIs('resultados') ? 'current' : '' }}">Resultados</a>
                <a href="{{ route('encuestas') }}" class="{{ request()->routeIs('encuestas') ? 'current' : '' }}">Encuestas</a>
                <a href="{{ route('usuario') }}" class="{{ request()->routeIs('usuario') ? 'current' : '' }}">Usuario</a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Cerrar sesión</button>
                </form>
            @endauth

            {{-- Menú para usuario (guard web) --}}
            @auth('web')
                <a href="{{ route('voto') }}" class="{{ request()->routeIs('voto') ? 'current' : '' }}">Votar</a>
                <a href="{{ route('resultados') }}" class="{{ request()->routeIs('resultados') ? 'current' : '' }}">Resultados</a>
                <a href="{{ route('encuestas') }}" class="{{ request()->routeIs('encuestas') ? 'current' : '' }}">Encuestas</a>
                <a href="{{ route('usuario') }}" class="{{ request()->routeIs('usuario') ? 'current' : '' }}">Usuario</a>
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
