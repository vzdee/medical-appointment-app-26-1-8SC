<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient.user', 'doctor.user'])
            ->orderByDesc('date')
            ->orderByDesc('start_time')
            ->paginate(15);
        
        return view('admin.appointments.index', compact('appointments'));
    }

    public function create()
    {
        return view('admin.appointments.create');
    }

    public function store(Request $request)
    {
        // Handled by Livewire
    }

    public function show(string $id)
    {
        $appointment = Appointment::with(['patient.user', 'patient.bloodType', 'doctor.user'])->findOrFail($id);
        return view('admin.appointments.show', compact('appointment'));
    }

    public function edit(string $id)
    {
        $appointment = Appointment::findOrFail($id);
        return view('admin.appointments.edit', compact('appointment'));
    }

    public function update(Request $request, string $id)
    {
        // Handled by Livewire
    }

    public function destroy(string $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('admin.appointments.index')->with('swal', [
            'icon' => 'success',
            'title' => '¡Eliminada!',
            'text' => 'La cita ha sido eliminada correctamente.',
        ]);
    }
}
