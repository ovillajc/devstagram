@extends('layouts.app')

@section('titulo')
    Página principal
@endsection

@section('contenido')
    {{-- @forelse ($posts as $post)
        <h1>{{$post->titulo}}</h1>
    @empty
        <p>No hay post</p>
    @endforelse --}}

    {{-- Enviar informacion de una vista a un componente mediante slot --}}
    {{-- <x-listar-post>
        <x-slot:titulo>
            <header>Esto es un header</header>
        </x-slot:titulo>
        <h1>Mostrando posts desde slot</h1>
    </x-listar-post> --}}


    <x-listar-post :posts="$posts" />

@endsection
