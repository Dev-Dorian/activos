<?php

namespace App\Http\Controllers;
use App\User;
//use App\Persona;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $users = User::join('roles','users.idrol','=','roles.id')
            ->select('users.id','users.nombre',
            //'users.tipo_documento',
            //'users.num_documento',
            //'users.direccion',
            //'users.telefono',
            'users.email','users.usuario','users.password',
            'users.condicion','users.idrol','roles.nombre as rol')
            ->orderBy('users.id', 'desc')->paginate(3);
        }
        else{
            $users = User::join('roles','users.idrol','=','roles.id')
            ->select('users.id','users.nombre',
            //'users.tipo_documento',
            //'users.num_documento',
            //'users.direccion',
            //'users.telefono',
            'users.email','users.usuario','users.password',
            'users.condicion','users.idrol','roles.nombre as rol')            
            ->where('users.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('users.id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $users->total(),
                'current_page' => $users->currentPage(),
                'per_page'     => $users->perPage(),
                'last_page'    => $users->lastPage(),
                'from'         => $users->firstItem(),
                'to'           => $users->lastItem(),
            ],
            'users' => $users
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction();
            $user = new User();
            $user->nombre = $request->nombre;
            //$user->tipo_documento = $request->tipo_documento;
            //$user->num_documento = $request->num_documento;
            //$user->direccion = $request->direccion;
            //$user->telefono = $request->telefono;
            $user->email = $request->email;
            // Donde se envia el usaurio y contraseña encriptado
            $user->usuario = $request->usuario;
            $user->password = bcrypt($request->password);
            $user->condicion = '1';
            $user->idrol = $request->idrol;          
            $user->id = $user->id;

            $user->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }

        
        
    }

    public function registrarse(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        
        //try{
            //DB::beginTransaction();
            $user = new User();
            $user->nombre = $request->nombre;
            $user->email = $request->email;
            // Donde se envia el usaurio y contraseña encriptado
            $user->usuario = $request->usuario;
            $user->password = bcrypt($request->password);
            $user->condicion = '1';
            $user->idrol = '2';        
            $user->id = $user->id;

            $user->save();

            return view('auth.register');

            //DB::commit();

        //} catch (Exception $e){
         //   DB::rollBack();
        //}

        
        
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction();

            //Buscar primero el proveedor a modificar
            $user = User::findOrFail($request->id);

            //$persona = Persona::findOrFail($user->id);

            $user->nombre = $request->nombre;
            //$user->tipo_documento = $request->tipo_documento;
            //$user->num_documento = $request->num_documento;
            //$user->direccion = $request->direccion;
            //$user->telefono = $request->telefono;
            $user->email = $request->email;
            
            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password);
            $user->condicion = '1';
            $user->idrol = $request->idrol;
            $user->save();


            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }

    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '0';
        $user->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '1';
        $user->save();
    }


}
