@extends('welcome')

@section('content')
    <div class="container border p-4 mt-4">
        <div class="row mx-auto">
            <form action="{{ route('savetarea') }}" method="POST">
                @csrf
                    
                <div class="mb-3 col">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    @if (session('success'))
                            <h6 class="alert alert-success">{{ session('success') }}</h6>
                    @endif
                    <label for="name" class="form-label">Titulo de la tarea</label>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="tituloAyuda">
                    <div id="tituloAyuda" class="form-text">Especifica el titulo de la tarea.</div>
                </div>
                <button type="submit" class="btn btn-primary">Crear nueva tarea</button>
            </form>
            
            

            <div>
                <a class="btn btn-warning" href="{{ route('exportcsv') }}">Tareas terminadas</a>
                <table class="table table-striped table-responsive">
                    <thead>
                        <tr>
                        <th scope="col">Tarea</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Fecha creación</th>
                        <th scope="col">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tareas as $tarea)
                        <tr>
                            <td><a href="{{ route('edittarea', ['id' => $tarea->id]) }}">{{ $tarea->tarea }}</a></td>
                            <td>{{$tarea->estado}}</td>
                            <td>{{$tarea->created_at}}</td>
                            <td>
                                <form action="{{ route('deleteTarea', [$tarea->id]) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @endsection
<script type="text/javascript">
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    window.addEventListener("load",function(){
        $.ajax({
            type:'POST',
            url: "{{ route('estados') }}",
            success:function(data) {
                data.forEach(function(opcion) {
                    let select = document.getElementById("estados");
                    var opt = document.createElement("option");
                    opt.value= opcion["idEstado"];
                    opt.innerHTML = opcion["estado"]; // whatever property it has

                    // then append it to the select element
                    select.appendChild(opt);

                })
            }
        });
        
    });
</script>
