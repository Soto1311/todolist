<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarea;


class TareasController extends Controller
{
    /** 
     * index para mostrar todas las tareas
     * save para guardar tareas en bd
     * edit para cargar tarea ya creada
     * update para actualizar una tarea
     * delete para "eliminar " una tarea
     * edit para mostrar formulario de update
    */

    public function index(){
        $tareas = Tarea::select('tareas.tarea', 'tareas.idEstado', 'tareas.id', 'tareas.created_at', 'estados.estado')
                        ->from('tareas')
                        ->join('estados', function($query){
                            $query->on('estados.idEstado', '=', 'tareas.idEstado');
                        })
                        ->where('tareas.deleted', '=', 0)->get();

        return view('tareas.tareas', ['tareas' => $tareas]);
    }


    public function save(Request $request) {
        $request->validate([
            'name' => 'required|min:3',
        ]);

        $tarea = new Tarea;
        $tarea->tarea = $request->name;
        $tarea->idEstado = 1;
        $tarea->deleted = 0;
        $tarea->created_at = time();
        $tarea->updated_at = time();
        $tarea->save();

        return redirect()->route('tareas')->with('success', 'Tarea creada correctamente');
    }

    public function edit($id){
        $tarea = Tarea::find($id);

        return view('tareas.edit', ['tarea' => $tarea]);
    }

    public function update(Request $request, $id){
        $tarea = Tarea::find($id);

        $tarea->tarea = $request->tarea;
        $tarea->idEstado = $request->estados;
        $tarea->save();

        return redirect()->route('tareas')->with('success', 'Tarea actualizada correctamente');
    }

    public function delete($id){
        $tarea = Tarea::find($id);

        $tarea->deleted = time();
        $tarea->save();

        return redirect()->route('tareas')->with('success', 'La tarea se eliminó correctamente');
    }

    public function exportCsv(){
        $fileName = 'Tareas terminadas.csv';
        $tareas = Tarea::select('tareas.tarea', 'tareas.idEstado', 'tareas.id', 'tareas.created_at', 'tareas.updated_at', 'estados.estado', 'tareas.deleted',)
                        ->from('tareas')
                        ->join('estados', function($query){
                            $query->on('estados.idEstado', '=', 'tareas.idEstado');
                        })
                        ->where('estados.estado', '=', "Realizada")->get();

            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );

            $columns = array('Tarea', 'Estado', 'Fecha Creación', 'Fecha Actualización', 'Eliminada');

            $callback = function() use($tareas, $columns) {
                $file = fopen('php://output', 'w');
                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

                fputcsv($file, $columns, ";");

                foreach ($tareas as $tarea) {
                    $row['Tarea']  = $tarea->tarea;
                    $row['Estado']    = $tarea->estado;
                    $row['Fecha Creación']    = $tarea->created_at;
                    $row['Fecha Actualización']  = $tarea->updated_at;
                    if($tarea->deleted == 0){
                        $row['Eliminada']  = "No";
                    }else{
                        $row['Eliminada']  = "Sí";
                    }

                    fputcsv($file, array($row['Tarea'], $row['Estado'], $row['Fecha Creación'], $row['Fecha Actualización'], $row['Eliminada']), ";");
                }

                fclose($file);
            };

        return response()->stream($callback, 200, $headers);
    }
}
