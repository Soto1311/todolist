@extends('welcome')

@section('content')
    <div class="container w-25 border p-4 mt-4">
    <div class="row mx-auto">
        <form action="{{ route('updatetarea', ['id' => $tarea->id]) }}" method="POST">
            @method('PUT')
            @csrf
                
            <div class="mb-3 col">
                <label for="name" class="form-label">Titulo de la tarea</label>
                <input type="text" class="form-control" id="tarea" name="tarea" value="{{ $tarea->tarea }}" aria-describedby="tituloAyuda">
                <input type="hidden" disable class="form-control" id="idEstado" name="idEstado" value="{{ $tarea->idEstado }}" aria-describedby="tituloAyuda">
                <div id="tituloAyuda" class="form-text">Actualizar titulo de la tarea.</div>
            </div>
            <div class="mb-3 col">
                <select class="form-select" id="estados" name="estados" aria-label="Estado de la tarea"></select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar tarea</button>
        </form>

    </div>
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
                    idEstado = document.getElementById("idEstado");
                    data.forEach(function(opcion) {
                        let select = document.getElementById("estados");
                        var opt = document.createElement("option");
                        opt.value= opcion["idEstado"];
                        opt.innerHTML = opcion["estado"]; // whatever property it has
                        if(idEstado.value == opcion["idEstado"]){
                            opt.selected = true;
                        }
                        // then append it to the select element
                        select.appendChild(opt);

                    })
                }
            });
            
        });
    </script>
@endsection
