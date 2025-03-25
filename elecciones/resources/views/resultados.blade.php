@extends('layouts.app')

@section('title', 'Resultados')

@section('content')
    <h2>Resultados</h2>
    <table border="1">
        <tr>
            @foreach ($data[0] as $key => $value)
                <th>{{ $key }}</th>
            @endforeach
        </tr>
        @foreach ($data as $row)
            <tr>
                @foreach ($row as $value)
                    <td>
                        @if(is_array($value))
                            {{ json_encode($value) }}  {{-- Imprimir los diccionarios como JSON --}}
                        @else
                            {{ $value }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>
@endsection
