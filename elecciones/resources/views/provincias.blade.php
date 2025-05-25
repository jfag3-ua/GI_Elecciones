@extends('layouts.app')

@section('title', 'Candidatos')

@section('content')
<h2 style="margin-bottom: 3rem;">Seleccione una provincia para ver los candidatos:</h2>

<style>
    .provincia-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1.5rem;
        margin-top: 1rem;
    }

    .provincia-card {
        border: 1px solid #8c0c34;
        border-radius: 8px;
        padding: 1rem;
        text-align: center;
        font-weight: 600;
        color: #8c0c34;
        cursor: pointer;
        transition: background-color 0.15s ease-in-out;
        user-select: none;
    }

    .provincia-card:hover,
    .provincia-card:focus-within {
        background-color: #f9e6f0;
        outline: none;
    }

    .provincia-card a {
        color: inherit;
        text-decoration: none;
        display: block;
        font-size: 1.2rem;
    }
</style>

<div class="provincia-grid">
    @foreach ($provincias as $provincia)
        <div class="provincia-card" tabindex="0">
            <a href="{{ route('candidatos.porProvincia', ['provincia' => $provincia->provincia]) }}">
                {{ $provincia->nomProvincia }}
            </a>
        </div>
    @endforeach
</div>
@endsection
