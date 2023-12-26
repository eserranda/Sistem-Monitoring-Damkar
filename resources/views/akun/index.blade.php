@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header header-elements">
            <span class="me-2">Data User</span>

            <div class="card-header-elements ms-auto">
                <a href="{{ route('add_users') }}" class="btn -bottom-3 btn-primary">
                    <span class="tf-icon ti ti-plus ti-xs me-1"></span>Add
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <caption class="ms-4">Data Damkar</caption>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->username }}</td>
                                <td>{{ $row->email }}</td>
                                <td>{{ $row->role }}</td>
                                <td>
                                    <button type="button" class="btn btn-icon btn-outline-secondary"
                                        onclick="hapus({{ $row->id }})">
                                        <span class="ti ti-trash-x text-danger"></span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            function hapus(id) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data akan di hapus permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var csrfToken = $('meta[name="csrf-token"]').attr('content');
                        // var url = '{{ url('delete_users') }}/' + id;
                        var url = '{{ route('delete_users', ['id' => '__id__']) }}';
                        url = url.replace('__id__', id);

                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: csrfToken
                            },
                            success: function(response) {
                                console.log('Response:', response);
                                if (response.status) {
                                    Swal.fire(
                                        'Terhapus!',
                                        'Data Berhasil di Hapus.',
                                        'success'
                                    );
                                    location.reload();
                                } else {
                                    Swal.fire(
                                        'Gagal!',
                                        'Terjadi kesalahan saat menghapus data.',
                                        'error'
                                    );
                                }
                            },
                            error: function(error) {
                                console.log('Gagal menghapus data: ' + error);
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            }
        </script>
    @endpush
@endsection
