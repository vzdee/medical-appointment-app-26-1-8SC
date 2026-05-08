<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Auto-crear perfil de doctor para los usuarios que tienen el rol pero no el perfil
        $doctorUsers = \App\Models\User::role('Doctor')->doesntHave('doctor')->get();
        foreach ($doctorUsers as $user) {
            $user->doctor()->create();
        }

        $doctors = \App\Models\Doctor::whereHas('user', function($q) {
            $q->role('Doctor');
        })->with('user')->paginate(10);
        
        return view('admin.doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(\App\Models\Doctor $doctor)
    {
        return view('admin.doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \App\Models\Doctor $doctor)
    {
        $data = $request->validate([
            'specialty' => 'nullable|string|max:255',
        ]);

        $doctor->update($data);

        return redirect()->route('admin.doctors.index')->with('swal', [
            'icon' => 'success',
            'title' => '¡Actualizado!',
            'text' => 'La especialidad del doctor se ha actualizado correctamente.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function schedules(\App\Models\Doctor $doctor)
    {
        return view('admin.doctors.schedules', compact('doctor'));
    }
}
