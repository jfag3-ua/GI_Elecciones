@extends('layouts.app')

@section('title', 'Candidatos')

@section('content')
<h3>Candidatos por provincia:</h3>

<style>
    .provincia-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* Tres columnas */
        gap: 30px;
        margin-top: 20px;
    }

    .provincia-card {
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 15px;
        background-color: #f9f9f9;
        transition: box-shadow 0.3s ease;
    }

    .provincia-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .provincia-card img {
        width: 100%;
        max-width: 1000px;
        height: auto;
        margin-bottom: 10px;
        border-radius: 8px;
    }

    .provincia-card a {
        text-decoration: none;
        font-weight: bold;
        color: #8c0c34;
        display: block;
        font-size: 25px;
    }

    @media (max-width: 1500px) {
        .provincia-grid {
            grid-template-columns: repeat(1, 1fr); /* Móvil: una columna */
        }
    }

    @media (min-width: 801px) and (max-width: 1500px) {
        .provincia-grid {
            grid-template-columns: repeat(2, 1fr); /* Tablets: dos columnas */
        }
    }
</style>

<div class="provincia-grid">
    @foreach ($provincias as $provincia)
        <div class="provincia-card">
            <a href="{{ route('candidatos.porProvincia', ['provincia' => $provincia->provincia]) }}">
            <img src="{{ asset('img/provincias/' . strtolower($provincia->provincia) . '.jpg') }}" alt="Imagen de {{ $provincia->nomProvincia }}">
                {{ $provincia->nomProvincia }}
            </a>
        </div>
    @endforeach
</div>
@endsection


