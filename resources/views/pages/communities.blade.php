@extends('layouts.master')

@section('title', 'Topluluklar')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2>Topluluklar</h2>
            <div class="card-deck">
                <!-- Örnek topluluk kartları -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Kitap Kulübü</h5>
                        <p class="card-text">Kitapseverlerin buluştuğu topluluk. Yeni kitaplar keşfedin!</p>
                        <a href="#" class="btn btn-primary">Detaylar</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Yürüyüş Grubu</h5>
                        <p class="card-text">Sağlıklı yaşam için düzenli yürüyüş etkinlikleri.</p>
                        <a href="#" class="btn btn-primary">Detaylar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
