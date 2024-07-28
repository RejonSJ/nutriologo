<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Citas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $idUser = Auth::user()->id;
        $today = date('Y-m-d',strtotime(now()));
        switch (Auth::user()->role) {
            case 'admin':
                $citas = DB::table('citas as c')
                    ->select('c.*','u.name as doctor','cl.nombre as clinica','p.name as paciente','cl.direccion as direccion')
                    ->join('users as p','p.id','c.id_usuario')
                    ->join('users as u','u.id','c.id_doctor')
                    ->join('clinicas as cl','cl.id','u.id_clinica')
                    ->get();
            break;
            case 'doctor':
                $citas = DB::table('citas as c')
                    ->select('c.*','u.name as doctor','cl.nombre as clinica','p.name as paciente','cl.direccion as direccion')
                    ->join('users as p','p.id','c.id_usuario')
                    ->join('users as u','u.id','c.id_doctor')
                    ->join('clinicas as cl','cl.id','u.id_clinica')
                    ->where('c.id_doctor','=',$idUser)
                    ->get();
                break;
            default:
                $citas = DB::table('citas as c')
                    ->select('c.*','u.name as doctor','cl.nombre as clinica','p.name as paciente','cl.direccion as direccion')
                    ->join('users as p','p.id','c.id_usuario')
                    ->join('users as u','u.id','c.id_doctor')
                    ->join('clinicas as cl','cl.id','u.id_clinica')
                    ->where('c.id_user','=',$idUser)
                    ->get();
                break;
        }
        date_default_timezone_set('America/Mexico_City');

        return view('home')->with(compact('citas','today'));
    }
}
