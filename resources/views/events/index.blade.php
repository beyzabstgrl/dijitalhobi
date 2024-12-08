@extends('layouts.master')

@section('content')
    <div class="container mt-4">
        <h2>Etkinlikler</h2>
        @if (auth()->check() && auth()->user()->role === 'admin')
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal">Etkinlik Ekle</button>        @endif
        <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="eventForm">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="eventModalLabel">Yeni Etkinlik Ekle</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Etkinlik Başlığı</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Açıklama</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="event_date" class="form-label">Tarih</label>
                                <input type="date" class="form-control" id="event_date" name="event_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="location" class="form-label">Yer</label>
                                <input type="text" class="form-control" id="location" name="location" required>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Görsel</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            @if ($events->isEmpty())
                <p>Henüz etkinlik eklenmemiş.</p>
            @else
                @foreach ($events as $event)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            @if ($event->image)
                                <img src="{{ asset($event->image) }}" alt="{{ $event->title }}" class="card-img-top">
                            @else
                                <img src="https://via.placeholder.com/150" class="card-img-top" alt="Varsayılan Görsel">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $event->title }}</h5>
                                <p class="card-text">{{ $event->description }}</p>
                                <p><strong>Tarih:</strong> {{ $event->event_date }}</p>
                                <p><strong>Yer:</strong> {{ $event->location }}</p>
                            </div>
                            <!-- Yorum Yap Butonu -->
                            @auth
                                <button class="btn btn-primary mt-2" onclick="openCommentModal({{ $event->id }}, '{{ $event->title }}')">
                                    Yorum Yap
                                </button>
                            @else
                                <p>Yorum yapmak için <a href="{{ route('login') }}">giriş yapın</a>.</p>
                            @endauth
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="commentForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="commentModalLabel">Yorum Yap</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="eventId" name="eventId">
                        <div class="mb-3">
                            <label for="comment" class="form-label">Yorumunuzu Yazın</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                        <button type="submit" class="btn btn-primary">Gönder</button>
                    </div>
                    <input type="hidden" id="eventId" name="eventId">
                </form>


            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script>
        function openCommentModal(eventId, eventTitle) {
            $('#eventId').val(eventId); // Modal içindeki gizli input'a event ID'yi ata
            console.log('Event ID:', eventId);
            $('#commentModalLabel').text(`Yorum Yap: ${eventTitle}`);
            $('#commentModal').modal('show');
        }


        $('#commentForm').on('submit', function (e) {
            e.preventDefault();

            const eventId = $('#eventId').val(); // Gizli input'tan event ID al
            const comment = $('#comment').val(); // Kullanıcının yazdığı yorum

            $.ajax({
                url: `/events/${eventId}/comments`, // Etkinlik ID'yi URL'de kullan
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // CSRF token
                    comment: comment, // Yorum içeriği
                },
                success: function (response) {
                    $('#commentModal').modal('hide');
                    $('#commentForm')[0].reset();
                    Swal.fire('Başarılı!', 'Yorumunuz eklendi.', 'success');
                },
                error: function () {
                    Swal.fire('Hata!', 'Yorum eklenirken bir hata oluştu.', 'error');
                }
            });
        });

        $('#eventForm').on('submit', function (e) {
            e.preventDefault();

            // Form verilerini al
            const formData = new FormData(this);

            $.ajax({
                url: "{{ route('events.store') }}", // Etkinlik ekleme rotası
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        // Başarılı mesaj göster
                        Swal.fire({
                            icon: 'success',
                            title: 'Başarılı!',
                            text: response.message,
                        });

                        // Modalı kapat ve formu sıfırla
                        $('#eventModal').modal('hide');
                        $('#eventForm')[0].reset();

                        // Sayfayı yenile veya listeyi güncelle
                        location.reload(); // Alternatif olarak listeyi manuel güncelleyebilirsiniz
                    } else {
                        // Hata mesajı göster
                        Swal.fire({
                            icon: 'error',
                            title: 'Hata!',
                            text: response.message,
                        });
                    }
                },
                error: function (xhr) {
                    // Sunucu hatası veya doğrulama hatası
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        text: 'Etkinlik eklenirken bir hata oluştu!',
                    });
                }
            });
        });

    </script>
@endsection
