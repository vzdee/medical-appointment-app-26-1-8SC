<?php

namespace App\Livewire\Admin\Appointments;

use Livewire\Component;

use App\Models\Appointment;

class ConsultationManager extends Component
{
    public $appointment;
    public $tab = 'consulta';
    
    // Consulta
    public $diagnosis = '';
    public $treatment = '';
    public $notes = '';

    // Receta
    public $medicines = [];

    // History
    public $showHistory = false;
    public $showMedicalHistory = false;
    public $history = [];

    protected $rules = [
        'diagnosis' => 'required|string',
        'treatment' => 'required|string',
        'notes' => 'required|string',
        'medicines.*.medicine'   => 'required|string',
        'medicines.*.dosage'     => 'required|string',
        'medicines.*.frequency'  => 'required|string',
    ];

    public function mount(Appointment $appointment)
    {
        $this->appointment = $appointment;
        $this->diagnosis = $appointment->diagnosis ?? '';
        $this->treatment = $appointment->treatment ?? '';
        $this->notes = $appointment->notes ?? '';
        
        $this->medicines = $appointment->prescriptions ?? [];
    }

    public function setTab($tabName)
    {
        $this->tab = $tabName;
    }

    public function addMedicine()
    {
        $this->medicines[] = ['medicine' => '', 'dosage' => '', 'frequency' => ''];
    }

    public function removeMedicine($index)
    {
        unset($this->medicines[$index]);
        $this->medicines = array_values($this->medicines);
    }

    public function save()
    {
        $this->validate();

        $this->appointment->diagnosis = $this->diagnosis;
        $this->appointment->treatment = $this->treatment;
        $this->appointment->notes = $this->notes;
        $this->appointment->prescriptions = $this->medicines;

        $this->appointment->save();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Guardado!',
            'text' => 'Datos guardados exitosamente.',
        ]);

        return redirect()->route('admin.appointments.index');
    }

    public function loadHistory()
    {
        $this->history = Appointment::where('patient_id', $this->appointment->patient_id)
            ->where('id', '!=', $this->appointment->id)
            ->orderByDesc('date')
            ->get();
        $this->showHistory = true;
    }

    public function render()
    {
        return view('livewire.admin.appointments.consultation-manager');
    }
}
