<?php
namespace App\Http\Controllers\Admins;

use App\Models\Clinicas;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class IdiomastestController
 * @package App\Http\Controllers
 */
    class ClinicasController extends Controller
    {
        public function index()
        {
            $clinicas = DB::table('clinicas as c')
                ->selectRaw('c.*, COUNT(u.id) as doctores')
                ->leftJoin('users as u', 'u.id_clinica', '=', 'c.id')
                ->groupBy(
                    'c.id',
                    'c.nombre',
                    'c.direccion',
                    'c.updated_at',
                    'c.created_at'
                )
                ->get();

            return view('admins.clinicas.index', compact('clinicas'));
        }
        
        public function createclinicas(Request $request){
            $nombre = $request->get('nombre');
            $direccion = $request->get('direccion');

            Clinicas::create(['nombre' => $nombre, 'direccion' => $direccion]);

            return redirect()->back()->with('success','La clinica se ha creado con exito');
        }
        public function updateclinicas(Request $request){
            $id = $request->get('id');
            $nombre = $request->get('nombre');
            $direccion = $request->get('direccion');

            Clinicas::find($id)->update(['nombre' => $nombre, 'direccion' => $direccion]);

            return redirect()->back()->with('success','La clinica se ha actualizado con exito');
        }
        public function deleteclinicas($id){

            Clinicas::find($id)->delete();
    
            return redirect()->back()->with('success','La clinica se ha eliminado con exito');
        }
    }
    
?>