<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\dificultad;
use App\Models\materias;
use Inertia\Inertia;



use Illuminate\Http\Request;

class MateriasController extends Controller
{
    public function Show () {

        $dificultad = dificultad::all();

        $user_id = Auth::id();

        $materias = materias::from('materias as t1')
        ->leftJoin('dificultad as t2', 't1.dificultad_id', '=', 't2.id')
        ->select(
            't1.id',
            't1.name as materia', 
            't1.profesor',
            't2.name as dificultad'
        )->where('t1.user_id', $user_id)->get();

        return Inertia::render('Maestros',
            [
                'dificultad' => $dificultad,
                'materias' => $materias,
            ]
        );
    }   

    public function Addmateria (Request $request) {

        
        
        $request->validate([
            'name' => 'required|string|',
            'dificultad' => 'required',
        ],[
            'name.required' => 'El campo Materia es obligatorio.',
            'dificultad.required' => 'El campo Dificultad es obligatorio.',
        ]);

        try {
            $user_id = Auth::id();

            materias::UpdateOrCreate(
                [
                    'id' => $request->id,
                ],
                [
                    'user_id' => $user_id,
                    'name' => $request->name,
                    'profesor' => $request->profesor,
                    'dificultad_id' => $request->dificultad
                ]
            );
            return response()->json(['msg' => 'La materia fue creada/actualizada con exito', 'status' => 1]);
        } catch (\Throwable $th) {
            return response()->json(['msg' => 'Ups tuvimos un error intente nuevamente.', 'status' => 0]);
        }
        
    }

    public function EditMateria ($id) {
        try {
            
            $materia = materias::find($id);            
            return $materia;

        } catch (\Throwable $th) {
            return response()->json(['msg' => 'Ups tuvimos un error intente nuevamente.', 'status' => 0]);
        }                
    }    

    public function DeleteMateria (Request $request) { 
        try {
            
            $materia = materias::find($request->id);
            $materia->delete();

            return response()->json(['msg' => 'La materia se elimino correctamente.', 'status' => 1]);

        } catch (\Throwable $th) {

            return response()->json(['msg' => 'Ups tuvimos un error intente nuevamente.', 'status' => 0]);
        }
        
    }

}
