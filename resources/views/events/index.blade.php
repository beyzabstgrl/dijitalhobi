@extends('layouts.master')

@section('content')
    <div class="container mt-4">
        <h2>Etkinlikler</h2>
        @if (auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('events.create') }}" class="btn btn-primary mb-3">Yeni Etkinlik Oluştur</a>
        @endif
        <div class="row">
            @if($events->isEmpty())
                <p>Henüz etkinlik eklenmemiş.</p>
            @else
                @foreach ($events as $event)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            @if ($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->title }}">
                            @else
                                <img src="https://via.placeholder.com/150" class="card-img-top" alt="Varsayılan Görsel">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $event->title }}</h5>
                                <p class="card-text">{{ $event->description }}</p>
                                <p><strong>Tarih:</strong> {{ $event->event_date }}</p>
                                <p><strong>Yer:</strong> {{ $event->location }}</p>
                                <p><strong>Topluluk:</strong> {{ $event->community->name }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
