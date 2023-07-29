@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Add User') }}</div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Country</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th>Photo</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->first_name }}</td>
                                        <td>{{ $user->last_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->country }}</td>
                                        <td>{{ $user->state }}</td>
                                        <td>{{ $user->city }}</td>
                                        <td>
                                            @if ($user->photo)
                                                <img src="{{ asset('images/'.$user->photo) }}" alt="User Photo" height="50">
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-{{ $user->is_active == '1' ? 'success' : 'danger' }}"
                                                onclick="toggleActive({{ $user->id }})">
                                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="deleteUser({{ $user->id }})">Delete</button>
                                        </td>
                                        <td>
                                            <a class="btn btn-warning btn-sm"
                                              href="{{ route('edit.user', $user->id) }}">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="deleteForm" action="" method="post" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
    <script>
        function deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                var form = document.getElementById('deleteForm');
                form.action = '/users/' + id;
                form.submit();
            }
        }
    </script>
    <script>
        function toggleActive(id) {
            $.ajax({
                url: '/toggle-active',
                method: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    // Update the button text and class
                    var button = $('[onclick="toggleActive(' + id + ')"]');
                    button.text(data.is_active ? 'Active' : 'Inactive');
                    button.removeClass('btn-success btn-danger');
                    button.addClass(data.is_active ? 'btn-success' : 'btn-danger');
                    toastr.success('User Status Changed');
                },
                error: function(error) {
                    console.error('Error:', error);
                    toastr.error('An error occurred while updating status.', 'Error');
                }
            });
        }
    </script>
@endsection
