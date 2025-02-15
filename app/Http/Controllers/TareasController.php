<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\materias;
use App\Models\estatus;
use App\Models\dificultad;
use Illuminate\Http\Request;
use App\Models\tareas;
use Inertia\Inertia;
use Carbon\Carbon;
class TareasController extends Controller
{
    public function Show () {
        
        $user_id = Auth::id();

        $materias = materias::where('user_id', $user_id)->get();
        $estatus_pendiente = estatus::find(1);
        $estatus = estatus::all();

        $tareas = tareas::from('tareas as t1')
        ->leftJoin('materias as t2', 't1.materias_id', '=', 't2.id')
        ->leftJoin('dificultad as t3', 't1.dificultad_id', '=', 't3.id')
        ->leftJoin('estatus as t4', 't1.estatus_id', '=', 't4.id')
        ->select(
            't1.id',
            't1.titulo',
            't1.fechaentrega',
            't1.descripcion',
            't2.name as materia',
            't2.profesor',
            't3.name as dificultad',
            't4.name as estatus',
        )
        ->where('t1.user_id', $user_id)
        ->orderBy('t1.fechaentrega', 'asc')
        ->get();

        foreach($tareas as $item){
            $item->fechaentrega = Carbon::parse($item->fechaentrega)->format('d/m/Y');
            
        }        
        
        return Inertia::render('Dashboard', 
            [
                'tareas' => $tareas,
                'materias' => $materias,
                'estatus_pendiente' => $estatus_pendiente,
                'estatus' => $estatus
            ]
        );
    }   

    public function AddTarea (Request $request) {        
        $user_id = Auth::id();

        $request->validate([
            'titulo' => 'required',
            'fechaentrega' => 'required',
            'materias_id' => 'required',
            'descripcion' => 'required',
        ],[
            'titulo.required' => 'El campo Titulo es obligatorio.',
            'fechaentrega.required' => 'El campo Fecha de entrega es obligatorio.',
            'materias_id.required' => 'El campo Materia es obligatorio.',
            'descripcion.required' => 'El campo Descripcion es obligatorio.',
        ]);

        try {
            tareas::UpdateOrCreate(
                [
                    'id' => $request->id,
                ],
                [
                    'titulo' => $request->titulo,
                    'fechaentrega' => $request->fechaentrega,
                    'descripcion' => $request->descripcion,
                    'materias_id' => $request->materias_id,
                    'dificultad_id' => $request->dificultad_id,                    
                    'estatus_id' => $request->estatus_id,
                    'user_id' => $user_id,
                    
                ]
            );
            return response()->json(['msg' => 'La materia fue creada/actualizada con exito', 'status' => 1]);
        } catch (\Throwable $th) {
            return response()->json(['msg' => 'Ups tuvimos un error intente nuevamente.', 'status' => 0]);
        }
    }   

    public function EditTarea ($id) {
        try {
            
            $tareas = tareas::from('tareas as t1')
            ->leftJoin('materias as t2', 't1.materias_id', '=', 't2.id')
            ->leftJoin('dificultad as t3', 't1.dificultad_id', '=', 't3.id')
            ->leftJoin('estatus as t4', 't1.estatus_id', '=', 't4.id')
            ->select(
                't1.id',
                't1.titulo',
                't1.fechaentrega',
                't1.descripcion',
                't2.id as materia_id',
                't2.profesor',
                't3.id as dificultad_id',
                't3.name as dificultad_name',
                't4.id as estatus_id',
            )
            ->where('t1.id', $id)
            ->get(); 

            return $tareas;

        } catch (\Throwable $th) {
            return response()->json(['msg' => 'Ups tuvimos un error intente nuevamente.', 'status' => 0]);
        } 
    }   

    public function DeleteTarea (Request $request) {

        try {

            $tarea = tareas::find($request->id);
            
            $tarea->delete();
            
            return response()->json(['msg' => 'La tarea se elimino correctamente.', 'status' => 1]);

        } catch (\Throwable $th) {
            
            return response()->json(['msg' => 'Ups tuvimos un error intente nuevamente.', 'status' => 0]);
        }

    }

    public function GetMateria ($id) {
         
        $materias = materias::find($id);
        $dificultad = dificultad::find($materias->dificultad_id);

        return response()->json(['materias' => $materias, 'dificultad' => $dificultad]);
    }
    
}
