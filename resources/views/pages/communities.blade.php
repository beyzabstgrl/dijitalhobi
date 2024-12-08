@extends('layouts.master')

@section('title', 'Topluluklar')

@section('content')
    <div class="container mt-4">
        <h2>Topluluklar</h2>

        <!-- Topluluk Ekleme Butonu -->
        @if(auth()->check() && auth()->user()->role === 'admin')
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCommunityModal">
                Yeni Topluluk Ekle
            </button>
        @endif>

        <!-- Topluluk Listesi -->
        <div class="row">
            @foreach ($communities as $community)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        @if ($community->image)
                            <img src="{{ asset('storage/' . $community->image) }}" class="card-img-top" alt="{{ $community->name }}">
                        @else
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Varsayılan Görsel">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $community->name }}</h5>
                            <p class="card-text">{{ $community->description }}</p>
                            @if(auth()->check() && auth()->user()->role === 'admin')
                                <button class="btn btn-primary" onclick="openEditModal({{ $community->id }})">Detay</button>
                                <button class="btn btn-danger" onclick="confirmDelete({{ $community->id }})">Sil</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addCommunityModal" tabindex="-1" aria-labelledby="addCommunityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCommunityModalLabel">Yeni Topluluk Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="communityForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Topluluk Adı</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Açıklama</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Görsel Yükle</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                        <button type="submit" class="btn btn-primary">Ekle</button>
                    </div>
                </form>            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="editCommunityModal" tabindex="-1" aria-labelledby="editCommunityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCommunityModalLabel">Topluluk Detayları</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateCommunityForm">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <input type="hidden" id="communityId" name="id">
                        <div class="mb-3">
                            <label for="name" class="form-label">Topluluk Adı</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Açıklama</label>
                            <textarea class="form-control" id="editDescription" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Görsel Yükle</label>
                            <input type="file" class="form-control" id="editImage" name="image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                        <button type="submit" class="btn btn-primary">Güncelle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Ajax Script -->
    <script>
        document.getElementById('communityForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            fetch('{{ route('communities.store') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Başarılı!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'Tamam'
                        }).then(() => {
                            location.reload(); // Sayfayı yenileyerek yeni topluluğu listele
                        });
                    } else {
                        Swal.fire({
                            title: 'Hata!',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'Tamam'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Hata!',
                        text: 'Bir hata oluştu. Lütfen tekrar deneyin.',
                        icon: 'error',
                        confirmButtonText: 'Tamam'
                    });
                    console.error('Hata:', error);
                });

        });

        function openEditModal(id) {
            fetch(`/communities/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    // Modal alanlarını doldur
                    document.getElementById('communityId').value = data.id;
                    document.getElementById('editName').value = data.name;
                    document.getElementById('editDescription').value = data.description;

                    // Modal'ı aç
                    const modal = new bootstrap.Modal(document.getElementById('editCommunityModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Hata:', error);
                    Swal.fire('Hata!', 'Topluluk bilgileri yüklenirken bir hata oluştu.', 'error');
                });
        }

        // Güncelleme işlemi
        document.getElementById('updateCommunityForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const id = document.getElementById('communityId').value;

            fetch(`/communities/${id}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-HTTP-Method-Override': 'POST'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Başarılı!', data.message, 'success').then(() => {
                            location.reload(); // Sayfayı yenile
                        });
                    } else {
                        Swal.fire('Hata!', 'Güncelleme işlemi başarısız.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Hata:', error);
                    Swal.fire('Hata!', 'Bir hata oluştu.', 'error');
                });
        });
        function confirmDelete(id) {
            Swal.fire({
                title: 'Emin misiniz?',
                text: 'Bu topluluk silinecek ve geri alınamayacak!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Evet, sil!',
                cancelButtonText: 'Hayır, iptal et'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/communities/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Silindi!',
                                    data.message,
                                    'success'
                                ).then(() => {
                                    location.reload(); // Sayfayı yenileyerek güncel listeyi göster
                                });
                            } else {
                                Swal.fire(
                                    'Hata!',
                                    'Silme işlemi başarısız.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Hata:', error);
                            Swal.fire(
                                'Hata!',
                                'Bir hata oluştu. Lütfen tekrar deneyin.',
                                'error'
                            );
                        });
                }
            });
        }


    </script>
@endsection
