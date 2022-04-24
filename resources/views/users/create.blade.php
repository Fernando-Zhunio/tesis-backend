@extends('layouts.app')

@section('css')
    <style>
        .card {
            margin-top: 20px;
        }

    </style>
@endsection

@section('content')
    <create-user-component></create-user-component>
@endsection

@section('scripts')
    <div class="container">
        <h2>Creando usuario</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <div>
        @endif
        <form method="post" action="{{ route('users.store') }}">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" value="{{ old('name') }}" id="name" name="name" />
                </div>
                <div class="form-group  col-md-6">
                    <label for="name">Fecha de nacimiento</label>
                    <input value="{{ old('birthday') }}" type="date" class="form-control" name="birthday" />
                </div>
                <div class="col-md-6 center justify-content-start">
                    <div class="form-check">
                        <input {{ old('is_student') ? 'checked="checked"' : '' }} value="1" class="form-check-input"
                            type="checkbox" id="flexCheckDefault" name="is_student" />
                        <label class="form-check-label" for="flexCheckDefault">
                            Es estudiante?
                        </label>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="email" value="{{ old('email') }}" class="form-control" id="email" name="email" />
                </div>
                <div class="form-group  col-md-6">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" />
                </div>
                <div class="form-group  col-md-6">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" />
                </div>
            </div>
            <button type="submit" class="my-3 btn btn-primary">Crear usuario</button>
        </form>
    </div>
    </div>
@endsection
