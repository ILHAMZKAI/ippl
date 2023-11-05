@extends('layouts.appad', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnavad', ['title' => 'Manajemen Admin'])
    <div class="row mx-4 me-4-1">
        <div class="col-12 mx-1">
            <div class="alert1 alert-light">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Email</th>
                            <th>address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->firstname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->address }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
