<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
/**
 * Class LibrostestController
 * @package App\Http\Controllers
 */
class CitasController extends Controller
{
    public function index(Request $request)
    {
        $today = date('Y-m-d',strtotime(now()));
        $userId = Auth::user()->id;

        if(count($request->all()) >= 1) {
            $fechainicial = $request->get('fechainicial');
            $fechafinal = $request->get('fechafinal');
            $nutriologo = $request->get('doctor');

            $datequery = [];
            $doctorquery ='';
            $masterquery = [''];

            if(!(!$fechainicial && !$fechafinal)){
                if($fechainicial){
                    array_push($datequery, "DATE(c.fecha) >= '".$fechainicial."'");
                }
                if($fechafinal){
                    array_push($datequery, "DATE(c.fecha) <= '".$fechafinal."'");
                }
                $datequery = '('.implode(' AND ', $datequery).')';
                array_push($masterquery,$datequery);
            }

            if($nutriologo){
                $doctorquery  = "(c.id_doctor = '".$nutriologo."')";
                array_push($masterquery,$doctorquery);
            }
            $masterquery = implode(' AND ',$masterquery);

            $citas = DB::table('citas as c')
                ->select('c.*','u.name as doctor','cl.nombre as clinica','cl.direccion as direccion')
                ->join('users as u','u.id','c.id_doctor')
                ->join('clinicas as cl','cl.id','u.id_clinica')
                ->whereRaw("c.id_usuario = '".$userId."'".$masterquery)
                ->get();

        } else {
            $fechainicial = '';
            $fechafinal = '';
            $nutriologo = '';
            
            $citas = DB::table('citas as c')
                ->select('c.*','u.name as doctor','cl.nombre as clinica','cl.direccion as direccion')
                ->join('users as u','u.id','c.id_doctor')
                ->join('clinicas as cl','cl.id','u.id_clinica')
                ->whereRaw("c.id_usuario = '".$userId."'")
                ->get();
        }

        $doctores = DB::table('users as u')
            ->select('u.*')
            ->where('u.role','=','doctor')
            ->get();


        return view('citas.index', compact('citas','today','doctores','fechainicial','fechafinal','nutriologo'));
    }

    public function administradores(Request $request)
    {
        $today = date('Y-m-d',strtotime(now()));

        if(count($request->all()) >= 1) {
            $fechainicial = $request->get('fechainicial');
            $fechafinal = $request->get('fechafinal');
            $nutriologo = $request->get('doctor');

            $datequery = [];
            $doctorquery ='';
            $masterquery = [''];
            
            if(!(!$fechainicial && !$fechafinal)){
                if($fechainicial){
                    array_push($datequery, "DATE(c.fecha) >= '".$fechainicial."'");
                }
                if($fechafinal){
                    array_push($datequery, "DATE(c.fecha) <= '".$fechafinal."'");
                }
                $datequery = '('.implode(' AND ', $datequery).')';
                array_push($masterquery,$datequery);
            }

            if($nutriologo){
                $doctorquery  = "(c.id_doctor = '".$nutriologo."')";
                array_push($masterquery,$doctorquery);
            }
            $masterquery = implode(' AND ',$masterquery);

            $citas = DB::table('citas as c')
                ->select('c.*','u.name as doctor','cl.nombre as clinica','cl.direccion as direccion')
                ->join('users as u','u.id','c.id_doctor')
                ->join('clinicas as cl','cl.id','u.id_clinica')
                ->whereRaw("(c.estado IS NULL OR c.estado != '')".$masterquery)
                ->get();

        } else {
            $fechainicial = '';
            $fechafinal = '';
            $nutriologo = '';
            
            $citas = DB::table('citas as c')
                ->select('c.*','u.name as doctor','cl.nombre as clinica','p.name as paciente','cl.direccion as direccion')
                ->join('users as p','p.id','c.id_usuario')
                ->join('users as u','u.id','c.id_doctor')
                ->join('clinicas as cl','cl.id','u.id_clinica')
                ->whereRaw("(c.estado IS NULL OR c.estado != '')")
                ->get();
        }

        $doctores = DB::table('users as u')
            ->select('u.*')
            ->where('u.role','=','doctor')
            ->get();


        return view('admins.citas.index', compact('citas','today','doctores','fechainicial','fechafinal','nutriologo'));
    }

    public function doctores(Request $request)
    {
        $today = date('Y-m-d',strtotime(now()));
        $userId = Auth::user()->id;

        if(count($request->all()) >= 1) {
            $fechainicial = $request->get('fechainicial');
            $fechafinal = $request->get('fechafinal');
            $pacienteElegido = $request->get('paciente');

            $datequery = [];
            $doctorquery ='';
            $masterquery = [''];

            if(!(!$fechainicial && !$fechafinal)){
                if($fechainicial){
                    array_push($datequery, "DATE(c.fecha) >= '".$fechainicial."'");
                }
                if($fechafinal){
                    array_push($datequery, "DATE(c.fecha) <= '".$fechafinal."'");
                }
                $datequery = '('.implode(' AND ', $datequery).')';
                array_push($masterquery,$datequery);
            }

            if($pacienteElegido){
                $doctorquery  = "(c.id_paciente = '".$pacienteElegido."')";
                array_push($masterquery,$doctorquery);
            }
            $masterquery = implode(' AND ',$masterquery);

            $citas = DB::table('citas as c')
                ->select('c.*','u.name as paciente')
                ->join('users as u','u.id','c.id_usuario')
                ->whereRaw("c.id_doctor = '".$userId."'".$masterquery)
                ->get();

        } else {
            $fechainicial = '';
            $fechafinal = '';
            $pacienteElegido = '';
            
            $citas = DB::table('citas as c')
                ->select('c.*','u.name as paciente')
                ->join('users as u','u.id','c.id_usuario')
                ->whereRaw("c.id_doctor = '".$userId."'")
                ->get();
        }

        $pacientes = DB::table('users as u')
            ->select('u.*')
            ->where('u.role','=','user')
            ->get();


        return view('doctores.citas.index', compact('citas','today','pacientes','fechainicial','fechafinal','pacienteElegido'));
    }

    public function createcita (Request $request){
        $doctor = $request->get('id_doctor');
        $usuario = $request->get('id_user');
        $fecha = $request->get('fecha');
        $nota = $request->get('nota');
        citas::create(
            [
            'id_doctor'=>$doctor,
            'id_usuario'=>$usuario,
            'nota'=>$nota,
            'fecha'=>$fecha,
            ]
        );


        return redirect()->back()->with('success','Cheque el apartado de citas por su ticket.');
    }
    public function updatecita(Request $request){
        $id = $request->get('id');
        $estado=$request->get('estado');

        citas::find($id)->update(['estado' => $estado]);
        return redirect()->back()->with('success','Se ha actualizado el estado del prestamo con exito');
    }
    public function deletecita(Request $request){
        $id = $request->get('id');
        citas::find($id)->delete();

        return redirect()->back()->with('success','se ha eliminado la cita con exito');
    }
}
