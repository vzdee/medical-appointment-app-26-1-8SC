<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $roles=Role::all();
        return view('admin.users.create', compact('roles'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'id_number' => 'required|string|min:5|max:20|regex:/^[A-Za-z0-9]+$/|unique:users,id_number',
            'address' => 'required|max:255',
            'phone' => 'required|digits_between:7,15',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id'
        ]);
        $user = User::create($data);
        $user->roles()->attach($data['role_id']);

        //alerta de funcionamiento
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario creado correctamente',
            'text' => 'El usuario ha sido creado corrretamente',
        ]);
        return redirect(route('admin.users.index'))->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles=Role::all();
        //
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
        $data = $request->validate([
            'name' => 'required|string|max:255, name,',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'id_number' => 'required|string|min:5|max:20|regex:/^[A-Za-z0-9]+$/|unique:users,id_number,'.$user->id,
            'address' => 'required|max:255',
            'phone' => 'required|digits_between:7,15',
            'role_id' => 'required|exists:roles,id'
        ]);
        $user->update($data);

        //guardar la contrasena si desea actualizarse
        if($request->filled('password')){
            $user->password = bcrypt($request->password);
            $user->save();
        }

        $user->roles()->sync($data['role_id']);

        //alerta de funcionamiento
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario actualizado correctamente',
            'text' => 'El usuario ha sido actualizado corrretamente',
        ]);
        return redirect() -> route('admin.users.edit', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //

        //evitar que el usuario logueado se borre a si mismo
        if($user->id == Auth::user()->id){
            session()->flash('swal',[
                'icon' => 'error',
                'title' => 'No puedes eliminarte a ti mismo',
                'text' => 'No puedes eliminar tu propio usuario',
            ]);
            abort(403, 'No puedes eliminar tu propio usuario');
            return redirect(route('admin.users.index'));   
        }

        //elimina los roles asociados al usuario antes de eliminarlo
        $user->roles()->detach();
        //elimina al usurio de la bd
        $user->delete();

        session()->flash('swal',[
            'title' => 'Usuario eliminado correctamente',
            'icon' => 'success',
            'text' =>  'El usuario ha sido eliminado corrretamente',
        ]);
        return view('admin.users.index');

    }
}
