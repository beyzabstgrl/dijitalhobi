@extends('layouts.master')

@section('title', 'Kullanıcı Yönetimi')

@section('content')
    <div class="layout-container">
        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="card mb-4">
        <h2>Kullanıcı Yönetimi</h2>
                    <hr class="my-0" style="width: 96%; margin-left: 1rem;border: 0.5px solid">
                    <div class="card-body">
                        <div id="example_wrapper" class="dataTables_wrapper">

                    <table id="usersTable" class="display nowrap dataTable cell-border" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Ad</th>
                <th>E-posta</th>
                <th>Rol</th>
                <th>İşlemler</th>
            </tr>
            </thead>
        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <script>
        $(document).ready(function () {
            // DataTable'ı başlat
            $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.users.data') }}', // DataTables için veri sağlayan rota
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'role', name: 'role' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });

            // Rol Güncelleme
            $(document).on('change', '.update-role', function () {
                const userId = $(this).data('user-id');
                const role = $(this).val();

                $.ajax({
                    url: `/admin/users/${userId}/update-role`,
                    method: 'POST',
                    data: {
                        role: role,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {
                        Swal.fire('Başarılı!', response.message, 'success');
                    },
                    error: function () {
                        Swal.fire('Hata!', 'Rol güncellenemedi.', 'error');
                    }
                });
            });
        });
    </script>
@endsection

