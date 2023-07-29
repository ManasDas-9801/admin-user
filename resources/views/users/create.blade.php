@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Add User') }}</div>
                    <div class="card-body">
                        <form id="registrationForm" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="first_name" class="form-control mb-2 mt-1"
                                        placeholder="First Name">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="last_name" class="form-control mb-2 mt-1"
                                        placeholder="Last Name">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control mb-2 mt-1" placeholder="Email">
                                </div>
                                <div class="col-md-6">
                                    <input type="password" name="password" class="form-control mb-2 mt-1"
                                        placeholder="Password">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="country" class="form-control mb-2 mt-1"
                                        placeholder="Country">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="state" class="form-control mb-2 mt-1" placeholder="State">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="city" class="form-control mb-2 mt-1" placeholder="City">
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="photo" class="form-control mb-2 mt-1 mb-2 mt-1 p-1">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary text-center">Register</button>
                        </form>

                        <div id="message"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $('#registrationForm').submit(function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            console.log(formData)
            $.ajax({
                url: '/create-user',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    toastr.success(data.message, 'Message');
                    form.reset();
                },
                error: function(error) {
                    // console.error('Error:', error);
                    toastr.error('An error occurred during registration.', 'Error');
                }
            });
        });
    </script>
@endsection
