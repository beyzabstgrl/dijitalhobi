@extends('layouts.master')

@section('title', 'Ana Sayfa')

@section('content')
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>Hobi Platformuna Hoş Geldiniz!</h1>
            <p>Topluluklara katılın, etkinlikler düzenleyin ve bilgi paylaşın.</p>

            @auth
                <a href="/dashboard" class="btn btn-primary">Dashboard</a>
            @else
                <a href="/login" class="btn btn-primary">Giriş Yap</a>
                <a href="/register" class="btn btn-secondary">Kayıt Ol</a>
            @endauth
        </div>
    </div>
@endsection
