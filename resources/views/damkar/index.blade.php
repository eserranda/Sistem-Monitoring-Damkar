@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header header-elements">
            <span class="me-2">Data Posko Damkar</span>

            @if (Auth::check() && Auth::user()->role == 'super_admin')
                <div class="card-header-elements ms-auto">
                    <a href="/add_damkar" class="btn -bottom-3 btn-primary">
                        <span class="tf-icon ti ti-plus ti-xs me-1"></span>Add
                    </a>
                </div>
            @endif
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <caption class="ms-4">Data Damkar</caption>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Posko</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Alamat</th>
                            <th>Maps</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->nama }}</td>
                                <td>{{ $row->latitude }}</td>
                                <td>{{ $row->longitude }}</td>
                                <td>{{ $row->alamat }}</td>
                                <td>
                                    <button type="button" class="btn btn-icon btn-outline-secondary">
                                        <span class="ti ti-map-2 text-info"></span>
                                    </button>
                                    @if (Auth::check() && Auth::user()->role == 'super_admin')
                                        <a href="/edit_damkar/{{ $row->id }}"
                                            class="btn btn-icon btn-outline-secondary">
                                            <span class="ti ti-edit text-warning"></span>
                                        </a>

                                        <button type="button" class="btn btn-icon btn-outline-secondary"
                                            onclick="hapus({{ $row->id }})">
                                            <span class="ti ti-trash-x text-danger"></span>
                                        </button>
                                    @endif
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
                    text: 'Data akan dihapus permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var csrfToken = $('meta[name="csrf-token"]').attr('content');
                        var url = '{{ url('damkar_delete') }}/' + id;
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
                                        'Data berhasil dihapus.',
                                        'success'
                                    );
                                    location.reload();
                                } else {
                                    Swal.fire(
                                        'Gagal!',
                                        'Terjadi kesalahan saat menghapus Data.',
                                        'error'
                                    );
                                }
                            },
                            error: function(error) {
                                console.log('Gagal menghapus Data: ' + error);
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat menghapus Data.',
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
