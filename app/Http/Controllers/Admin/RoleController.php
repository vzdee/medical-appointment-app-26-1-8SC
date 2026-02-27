<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request -> validate([
            'name' => 'required | unique:roles,name'
        ]);

        // creamos el rol
        Role::create([
            'name' => $request->name
        ]);
        //alerta de funcionamiento
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Rol creado correctamente',
            'text' => 'El rol ha sido creado corrretamente',
        ]);

        //Redireccionamos a la tabla principal de roles
        return redirect(route('admin.roles.index')) -> with('succes', 'Role created succesfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //validar que se inserte correctamente y se excluya de la fila
        $request -> validate(['name' => 'required|unique:roles,name']);

        //si pasa la validación entonces hacemos lo siguiente
        $role -> update(['name' => $request->name]);
        //confirmacion de que se ha actualizado el rol
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Rol actualizado correctamente',
            'text' => 'El rol ha sido actualizado corrretamente',
        ]);
        // redireccionamos a la tabla principal de roles de ditar
        return redirect(route('admin.roles.index', $role));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //borramos el rol
        $role -> delete();

        session() ->flash('swal', [ 
            'icon' => 'success',
            'title' => 'Rol eliminado correctamente',
            'text' => 'El rol ha sido eliminado corrretamente',
        ]);

        //regresar a la pamtalla inicial
        return redirect(route('admin.roles.index'));

    }
}
