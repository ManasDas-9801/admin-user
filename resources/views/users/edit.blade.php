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
                                        placeholder="First Name" value="{{ $user->first_name }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="last_name" class="form-control mb-2 mt-1"
                                        placeholder="Last Name" value="{{ $user->last_name }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control mb-2 mt-1" placeholder="Email" value="{{ $user->email }}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="country" class="form-control mb-2 mt-1"
                                        placeholder="Country" value="{{ $user->country }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="state" class="form-control mb-2 mt-1" placeholder="State" value="{{ $user->state }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="city" class="form-control mb-2 mt-1" placeholder="City" value="{{ $user->city }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary text-center">Update</button>
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
                url: '/update-user',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    toastr.success(data.message, 'Message');
                    // form.reset();
                },
                error: function(error) {
                    // console.error('Error:', error);
                    toastr.error('An error occurred during registration.', 'Error');
                }
            });
        });
    </script>
@endsection
