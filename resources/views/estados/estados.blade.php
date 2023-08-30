@extends('welcome')

@section('content')
@csrf
    <div class="container border p-4 mt-4">
        <label for="name" class="form-label">Listado de estados</label>
        <table class="table table-striped table-responsive">
            <thead>
                <tr>
                <th scope="col">Estado</th>
                <th scope="col">Fecha creación</th>
                <th scope="col">Fecha modificación</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($estados as $estado)
                <tr>
                    <td>{{$estado->estado}}</td>
                    <td>{{ \Carbon\Carbon::parse($estado->created)->format('Y-m-d h:i:s') }}</td>
                    <td>{{ \Carbon\Carbon::parse($estado->updated)->format('Y-m-d h:i:s') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection