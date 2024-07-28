<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Clinicas;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $clinicas = Clinicas::get();
        $users = User::select('id','name','id_clinica','email','role')->get();
        return view('admins.users')->with(compact('users','clinicas'));
    }
    public function switchRole(Request $request){
        $id = $request->get('id');
        $role = $request->get('role');
        User::find($id)->update(['role'=>$role]);
        return redirect()->back();
    }
    public function switchClinica(Request $request){
        $id = $request->get('id');
        $clinica = $request->get('id_clinica');
        User::find($id)->update(['id_clinica'=>$clinica]);
        return redirect()->back();
    }

    public function deleteUser($id){

        User::find($id)->delete();

        return redirect()->back()->with('success','El usuario se ha eliminado con éxito.');
    }
}
