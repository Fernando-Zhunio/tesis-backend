@extends('layouts.app')

@section('css')
    <style>
        .card {
            margin-top: 20px;
        }

    </style>
@endsection
@section('scripts')
    <script src="{{ asset('js/event.js') }}"></script>
@endsection
@section('content')
    {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <div>
    @endif --}}
    {{-- <div class="container">
        <div>
            <h2 class="display-4">Gestion de Usuarios</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombres</th>
                        <th>Email</th>
                        <th>Fecha de nacimiento</th>
                        <th>Rol</th>
                        <th>Estudiante?</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->birthday }}</td>
                            <td>{{ $user?->roles[0]->description }}</td>
                            <td>{{ $user->is_student ? 'Si' : 'No' }}</td>
                            <td>
                                @if ($user?->roles[0]->name == 'super-admin')
                                    <form action="{{ route('users.quit.admin', $user->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning">Quitar admin</button>
                                    </form>
                                @else
                                    <form action="{{ route('users.be.admin', $user->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Hacer Admin</button>
                                    </form>
                                @endif
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> --}}
    <users-list-component></users-list-component>
@endsection
