@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header header-elements">
            <span class="me-2">Data Sensor</span>

            <div class="card-header-elements ms-auto">
                <a href="/add_sensor" class="btn -bottom-3 btn-primary">
                    <span class="tf-icon ti ti-plus ti-xs me-1"></span>Add
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <caption class="ms-4">Sensor Terdaftar</caption>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Sensor</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Tempat Sensor</th>
                            <th>Alamat</th>
                            <th>Maps</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->kode_sensor }}</td>
                                <td>{{ $row->latitude }}</td>
                                <td>{{ $row->longitude }}</td>
                                <td>{{ $row->tempat_sensor }}</td>
                                <td>{{ $row->alamat }}</td>
                                {{-- <td><a href="{{ $row->maps }}" target="_blank">Maps</a></td> --}}
                                <td>
                                    <button type="button" class="btn btn-icon btn-outline-secondary">
                                        <span class="ti ti-map-2 text-info"></span>
                                    </button>

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
                    text: 'Jadwal pelajaran akan dihapus permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var csrfToken = $('meta[name="csrf-token"]').attr('content');
                        var url = '{{ url('sensor_delete') }}/' + id;
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
                                        'Jadwal pelajaran berhasil dihapus.',
                                        'success'
                                    );
                                    location.reload();
                                } else {
                                    Swal.fire(
                                        'Gagal!',
                                        'Terjadi kesalahan saat menghapus Jadwal pelajaran.',
                                        'error'
                                    );
                                }
                            },
                            error: function(error) {
                                console.log('Gagal menghapus Jadwal pelajaran: ' + error);
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat menghapus Jadwal pelajaran.',
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
