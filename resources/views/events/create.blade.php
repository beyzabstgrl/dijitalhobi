@extends('layouts.master')

@section('content')
    <div class="container mt-4">
        <h2>Yeni Etkinlik Oluştur</h2>
        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="community_id" class="form-label">Topluluk</label>
                <select id="community_id" name="community_id" class="form-control" required>
                    @foreach (\App\Models\Community::all() as $community)
                        <option value="{{ $community->id }}">{{ $community->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Etkinlik Başlığı</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Açıklama</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="mb-3">
                <label for="event_date" class="form-label">Etkinlik Tarihi</label>
                <input type="datetime-local" class="form-control" id="event_date" name="event_date" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Yer</label>
                <input type="text" class="form-control" id="location" name="location">
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Görsel Yükle</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Kaydet</button>
        </form>
    </div>
@endsection
@section('scripts')
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Başarılı!',
                text: '{{ session('success') }}',
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Hata!',
                text: '{{ session('error') }}',
            });
        </script>
    @endif
@endsection
