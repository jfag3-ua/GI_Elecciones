<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Eleccions Valencianes')</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
    <link rel="stylesheet" href="/css/custom.css">
    <style>
        /* CSS personalizado para la paginación */
        /*
        nav a {
            padding: 10px 15px;
            border-radius: 5px;
            margin-right: 8px;
            text-decoration: none;
            font-weight: bold;
            color: #8c0c34;
            background-color: white;
            border: 1px solid #8c0c34;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        nav a:hover {
            background-color: rgb(255, 255, 255);
            color: white;
            border: 1px solid #8c0c34;
        }

        nav a.current {
            background-color: rgb(255, 255, 255);
            color: white;
            border: 1px solid #8c0c34;
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination {
            list-style: none;
            display: flex;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            margin: 0px;
        }

        .pagination a {
            text-decoration: none;
            color: #8c0c34;
            padding: 5px 7px;
            border-radius: 5px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .pagination a:hover {
            background-color: #8c0c34;
            color: white;
        }

        .pagination .disabled a {
            color: #ccc;
            pointer-events: none;
        }

        .pagination .active a {
            background-color: #8c0c34;
            color: white;
            border: 1px solid #8c0c34;
        }

        .pagination-arrow {
            font-size: 1px;
            font-weight: bold;
            color: #8c0c34;
            text-decoration: none;
            padding: 10px;
        }

        .pagination-arrow:hover {
            background-color: #8c0c34;
            color: white;
            border-radius: 5px;
        }

        .pagination .disabled .pagination-arrow {
            color: #ccc;
            pointer-events: none;
        }

        .pagination .disabled {
            pointer-events: none;
        }

        .page-selector {
            margin-left: 15px;
        }

        .page-selector select {
            padding: 5px;
            font-size: 14px;
            margin-left: 10px;
        }*/

    </style>
</head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="FV2EIXXl5h1TbZRdXNoYZ";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
@yield('scripts')
<body>
    <header>
        <nav>
            {{-- Enlace siempre visible --}}
            <a href="{{ route('landing') }}" class="{{ request()->routeIs('landing') ? 'current' : '' }}">Bienvenido</a>
            <a href="{{ route('provincias') }}" class="{{ request()->routeIs('provincias') || request()->routeIs('candidatos.porProvincia') ? 'current' : '' }}">Candidatos</a>

            {{-- Invitados: ni admin ni web --}}
            @guest('admin')
                @guest('web')
                    <a href="{{ route('resultados') }}" class="{{ request()->routeIs('resultados') ? 'current' : '' }}">Resultados</a>
                    <a href="{{ route('predicciones') }}" class="{{ request()->routeIs('predicciones') ? 'current' : '' }}">Predicciones</a>
                    <a href="{{ route('inicio') }}" class="{{ request()->routeIs('inicio') ? 'current' : '' }}">Iniciar sesión</a>
                    <a href="{{ route('registro2.form') }}" class="{{ request()->routeIs('registro2.form') ? 'current' : '' }}">Registrarse</a>
                @endguest
            @endguest

            {{-- Menú para admin (guard admin) --}}
            @auth('admin')
                <a href="{{ route('administracion') }}" class="{{ request()->routeIs('administracion') ? 'current' : '' }}">Administrar</a>
                <a href="{{ route('resultados') }}" class="{{ request()->routeIs('resultados') ? 'current' : '' }}">Resultados</a>
                <a href="{{ route('predicciones') }}" class="{{ request()->routeIs('predicciones') ? 'current' : '' }}">Predicciones</a>
                <a href="{{ route('usuario') }}" class="{{ request()->routeIs('usuario') ? 'current' : '' }}">Usuario</a>
            @endauth

            {{-- Menú para usuario (guard web) --}}
            @auth('web')
                <a href="{{ route('voto') }}" class="{{ request()->routeIs('voto') ? 'current' : '' }}">Votar</a>
                <a href="{{ route('resultados') }}" class="{{ request()->routeIs('resultados') ? 'current' : '' }}">Resultados</a>
                <a href="{{ route('predicciones') }}" class="{{ request()->routeIs('predicciones') ? 'current' : '' }}">Predicciones</a>
                <a href="{{ route('usuario') }}" class="{{ request()->routeIs('usuario') ? 'current' : '' }}">Usuario</a>
            @endauth
            @if(session('tipo_usuario'))
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit">Cerrar sesión</button>
            </form>
            @endif
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
