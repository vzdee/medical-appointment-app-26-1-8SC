<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodType;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return view('admin.patients.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.patients.create');
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
    public function show(Patient $patient)
    {
        //
        return view('admin.patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        //colocamos la vista default
        $initialTab = 'datos-personales';
        // definimos campos que pueden tener errores de validación
        $errorGroups = [
            'antecedentes' => ['allergies', 'chronic_conditions', 'surgical_history', 'family_history'],
            'informacion-general' => ['blood_type_id', 'observations'],
            'contacto-emergencia' => ['emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relationship'],
        ];
        //verificamos si existen errores en la sesión (después de una redirección por error de validación)
        $errors = session('errors');
        if ($errors) {
            //verificamos errores de validación y asignamos la pestaña correspondiente del grupo
            foreach ($errorGroups as $tabName => $fields) {
                if ($errors->hasAny($fields)) {
                    $initialTab = $tabName;
                    break; // si encontramos errores en un grupo, asignamos esa pestaña y salimos del loop
                }
            }

        }

        $bloodTypes = BloodType::all();
        return view('admin.patients.edit', compact('patient', 'bloodTypes', 'initialTab', 'errorGroups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        //
        $data = $request->validate([
            'blood_type_id' => 'nullable|exists:blood_types,id',
            'allergies' => 'nullable|string|min:3|max:255',
            'chronic_conditions' => 'nullable|string|min:3|max:255',
            'surgical_history' => 'nullable|string|min:3|max:255',
            'family_history' => 'nullable|string|min:3|max:255',
            'observations' => 'nullable|string|min:3|max:255',
            'emergency_contact_name' => 'nullable|string|min:3|max:255',
            'emergency_contact_phone' => ['nullable', 'string', 'min:10', 'max:12', 'regex:/^[0-9]+$/'],
            'emergency_contact_relationship' => 'nullable|string|min:3|max:50'
        ]);
        $patient->update($data);
        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Éxito!',
            'text' => 'Paciente actualizado exitosamente.',
        ]);
        return redirect()->route('admin.patients.edit', $patient)->with('success', 'Paciente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
