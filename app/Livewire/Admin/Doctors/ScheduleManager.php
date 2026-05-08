<?php

namespace App\Livewire\Admin\Doctors;

use Livewire\Component;
use App\Models\Doctor;
use App\Models\Schedule;

class ScheduleManager extends Component
{
    public Doctor $doctor;
    
    // Almacenará los horarios seleccionados: $selectedSchedules['Lunes']['08:00:00'] = true;
    public $selectedSchedules = [];

    public $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
    public $hours = [];

    public function mount(Doctor $doctor)
    {
        $this->doctor = $doctor;
        $this->generateHours();
        $this->loadExistingSchedules();
    }

    private function generateHours()
    {
        $start = strtotime('08:00:00');
        $end = strtotime('17:00:00');
        
        while ($start < $end) {
            $timeSlot = date('H:i:s', $start);
            $this->hours[] = $timeSlot;
            $start = strtotime('+15 minutes', $start);
        }
    }

    private function loadExistingSchedules()
    {
        // Inicializar el arreglo vacio
        foreach ($this->days as $day) {
            $this->selectedSchedules[$day] = [];
        }

        $schedules = Schedule::where('doctor_id', $this->doctor->id)->get();
        foreach ($schedules as $schedule) {
            $this->selectedSchedules[$schedule->day][$schedule->start_time] = true;
        }
    }

    public function toggleAll($day, $baseHour)
    {
        // $baseHour es como '08:00:00'. Selecciona de 08:00:00 a 08:45:00
        $startStr = strtotime($baseHour);
        // Queremos saber si marcamos o desmarcamos. Si el primero esta marcado, desmarcamos todos.
        $currentState = $this->selectedSchedules[$day][$baseHour] ?? false;
        $newState = !$currentState;

        for ($i = 0; $i < 4; $i++) {
            $timeSlot = date('H:i:s', $startStr + ($i * 15 * 60));
            if (in_array($timeSlot, $this->hours)) {
                $this->selectedSchedules[$day][$timeSlot] = $newState;
            }
        }
    }

    public function save()
    {
        // Limpiar los anteriores
        Schedule::where('doctor_id', $this->doctor->id)->delete();

        $inserts = [];
        $now = now();
        foreach ($this->selectedSchedules as $day => $slots) {
            foreach ($slots as $timeSlot => $isSelected) {
                if ($isSelected) {
                    $endTime = date('H:i:s', strtotime('+15 minutes', strtotime($timeSlot)));
                    $inserts[] = [
                        'doctor_id' => $this->doctor->id,
                        'day' => $day,
                        'start_time' => $timeSlot,
                        'end_time' => $endTime,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
        }

        if (!empty($inserts)) {
            Schedule::insert($inserts);
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Guardado!',
            'text' => 'Los horarios se han guardado exitosamente.',
        ]);

        return redirect()->route('admin.doctors.index');
    }

    public function render()
    {
        return view('livewire.admin.doctors.schedule-manager');
    }
}
