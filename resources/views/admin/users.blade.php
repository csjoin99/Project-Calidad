@extends('layouts.admindashboard')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Usuarios</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="card container-xl">
                <div class="table-responsive">
                    <div class="card-body table-wrapper">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Telefono</th>
                                    <th>DNI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td>{{$user->firstname}} {{$user->lastname}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->telefono}}</td>
                                    <td>{{$user->dni}}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">
                                        <strong>No hay usuarios registrados</strong>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>        
            </div>
        </div>
    </div>
@endsection
