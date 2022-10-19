<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Franquicia;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Rules\Password;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('franquicias', 'roles')->get();
        return view('Security.Users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $franquicias = Franquicia::all();
        $roles = Role::all();
        return view('Security.Users.create', [
            'franquicias' => $franquicias,
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        Validator::make($request->all(), [
            'clave' => ['required', 'string', new Password, 'confirmed'],
        ])->validate();

        try {
            DB::beginTransaction();

            $user = new User();
            $user->name = $request->nombre;
            $user->username = $request->usuario;
            $user->password = Hash::make($request->clave);
            $user->save();

            $user->franquicias()->sync($request->franquicias);
            $user->roles()->sync($request->rol);

            $log = new Log();
            $log->accion = "Crear nuevo usuario ".$user->username.' ('.$user->id.')';
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('usuarios.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $usuario)
    {
        $franquicias = Franquicia::all();
        $roles = Role::all();
        return view('Security.Users.edit', [
            'franquicias' => $franquicias,
            'roles' => $roles,
            'user' => $usuario,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $usuario)
    {
        Validator::make($request->all(), [
            'usuario' => 'required|unique:users,username,'.$usuario->id,
        ])->validate();

        try {
            DB::beginTransaction();

            $usuario->name = $request->nombre;
            $usuario->username = $request->usuario;
            $usuario->save();

            $usuario->franquicias()->sync($request->franquicias);
            $usuario->roles()->sync($request->rol);

            $log = new Log();
            $log->accion = "Editar usuario ".$usuario->name.' ('.$usuario->id.')';
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('usuarios.index');

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
