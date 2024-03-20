@extends('layouts.master')

@section('content')
    <!-- Bootstrap Validation -->
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <h5 class="card-header">Tambah Data User</h5>
                <div class="card-body">
                    <form action="" method="POST" id="add_data_users" novalidate>
                        <div class="mb-3">
                            <label class="form-label" for="bs-validation-name">Nama </label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nama"
                                required />
                            <div class="invalid-feedback"> </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="bs-validation-name">Username </label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                                required />
                            <div class="invalid-feedback"> </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="bs-validation-name">Email </label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="email"
                                required />
                            <div class="invalid-feedback"> </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="form-repeater-1-3">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="" selected disabled>Pilih Role</option>
                                <option value="super_admin">Super Admin</option>s
                                <option value="pemadam_kompi">Pemadam Kompi</option>
                                <option value="poskoh_damkar">Poskoh Damkar</option>
                            </select>
                            <div class="invalid-feedback"> </div>
                        </div>

                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="Pssword" aria-describedby="password" required />
                                <span class="input-group-text cursor-pointer" id="togglePassword"><i
                                        class="ti ti-eye-off"></i></span>
                            </div>
                            {{-- <div class="invalid-feedback"> </div> --}}
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="/akun"class="btn btn-warning">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            function handleValidationErrors(errors) {
                if (errors && typeof errors === 'object') {
                    Object.keys(errors).forEach(fieldName => {
                        const inputField = document.getElementById(fieldName);
                        inputField.classList.add('is-invalid');
                        inputField.nextElementSibling.textContent = errors[fieldName][0];
                    });

                    // Hapus kelas 'is-invalid' dari elemen formulir yang telah diperbaiki
                    const validFields = document.querySelectorAll('.is-invalid');
                    validFields.forEach(validField => {
                        const fieldName = validField.id;
                        if (!errors[fieldName]) {
                            validField.classList.remove('is-invalid');
                            validField.nextElementSibling.textContent = '';
                        }
                    });
                }
            }

            document.getElementById('add_data_users').addEventListener('submit', async function(event) {
                event.preventDefault();
                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                    const response = await fetch('{{ route('store_users') }}', {
                        method: 'POST',
                        body: new FormData(this),
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                    }).then(response => response.json());

                    if (!response.success) {
                        handleValidationErrors(response.errors);
                    } else if (response.success) {
                        console.log(response);
                        const invalidInputs = document.querySelectorAll('.is-invalid');
                        invalidInputs.forEach(invalidInput => {
                            invalidInput.value = '';
                            invalidInput.classList.remove('is-invalid');
                            const errorNextSibling = invalidInput.nextElementSibling;
                            if (errorNextSibling && errorNextSibling.classList.contains(
                                    'invalid-feedback')) {
                                errorNextSibling.textContent = '';
                            }
                        });
                        window.location.href = '/akun';
                    }
                } catch (error) {
                    console.error('Terjadi kesalahan:', error);
                    throw error;
                }
            });
        </script>
    @endpush
@endsection
