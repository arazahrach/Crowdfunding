@extends('layouts.app', ['title' => 'Beranda'])

@section('content')
    @include('pages.home.hero')
    @include('pages.home.urgent')
    @include('pages.home.categories')
@endsection
