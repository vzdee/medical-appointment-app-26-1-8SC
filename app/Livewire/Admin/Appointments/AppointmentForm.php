<?php

namespace App\Livewire\Admin\Appointments;

use Livewire\Component;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Schedule;

class AppointmentForm extends Component
{
    public $appointmentId;
    public $patient_id;
    public $doctor_id;
    public $date;
    public $start_time;
    public $end_time;
    public $status = 'Programado';
    public $notes;

    // Search properties
    public $searchDate;
    public $searchTimeRange = '';
    public $searchSpecialty;

    public $patients = [];
    public $doctorsList = [];
    public $specialties = [];
    public $allSchedules = [];

    protected function rules()
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'doctor_id'  => 'required|exists:doctors,id',
            'date'       => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'status'     => 'required|in:Programado,Completado,Cancelado',
            'notes'      => 'nullable|string',
        ];
    }

    protected function messages()
    {
        return [
            'patient_id.required' => 'Por favor, selecciona un paciente.',
            'doctor_id.required' => 'Debes seleccionar un doctor y un horario disponible en la lista de la izquierda.',
            'date.required' => 'La fecha de la cita es obligatoria.',
            'date.after_or_equal' => 'No puedes programar citas en fechas pasadas.',
            'start_time.required' => 'Es obligatorio elegir un horario.',
            'notes.string' => 'El motivo de la cita debe ser un texto.',
        ];
    }

    public function mount($appointmentId = null)
    {
        $this->patients = Patient::whereHas('user', function ($query) {
            $query->role('Paciente');
        })->with('user')->get()->mapWithKeys(function($p) {
            return [$p->id => $p->user->name ?? 'Desconocido'];
        })->toArray();
        
        $this->doctorsList = Doctor::with('user')->get();
        $this->specialties = $this->doctorsList->pluck('specialty')->filter()->unique()->values()->toArray();

        // Generate all possible schedules for the dropdown (08:00 to 17:00 in 15-min intervals)
        $start = strtotime('08:00:00');
        $end = strtotime('17:00:00');
        $this->allSchedules = [];
        
        while ($start < $end) {
            $this->allSchedules[] = date('H:i:s', $start);
            $start = strtotime('+15 minutes', $start);
        }

        // Default search date to today
        $this->searchDate = date('Y-m-d');

        if ($appointmentId) {
            $appointment = Appointment::findOrFail($appointmentId);
            $this->appointmentId = $appointment->id;
            $this->patient_id   = $appointment->patient_id;
            $this->doctor_id    = $appointment->doctor_id;
            $this->date         = $appointment->date->format('Y-m-d');
            $this->start_time   = date('H:i', strtotime($appointment->start_time));
            $this->end_time     = date('H:i', strtotime($appointment->end_time));
            $this->status       = $appointment->status;
            $this->notes        = $appointment->notes;
            
            // Sync search date with edit date
            $this->searchDate = $this->date;
        }
    }

    public function selectTime($doctorId, $time)
    {
        $this->doctor_id = $doctorId;
        $this->date = $this->searchDate;
        $this->start_time = date('H:i', strtotime($time));
        // Add 15 minutes for end_time
        $this->end_time = date('H:i', strtotime('+15 minutes', strtotime($time)));
    }

    // Generate available times for a doctor based on their schedules and existing appointments
    public function getAvailableTimes($doctorId)
    {
        if (empty($this->searchDate)) return [];

        $dayOfWeek = date('N', strtotime($this->searchDate));
        $days = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
            7 => 'Domingo'
        ];
        $dayName = $days[$dayOfWeek];

        // Get doctor's schedules for this day
        $query = Schedule::where('doctor_id', $doctorId)
                         ->where('day', $dayName);

        if (!empty($this->searchTimeRange)) {
            $query->where('start_time', $this->searchTimeRange);
        }

        $schedules = $query->orderBy('start_time')->pluck('start_time')->toArray();

        // Optionally, filter out times that are already booked
        $bookedTimes = Appointment::where('doctor_id', $doctorId)
            ->whereDate('date', $this->searchDate)
            ->whereIn('status', ['Programado', 'Completado'])
            ->pluck('start_time')
            ->map(function ($time) {
                return date('H:i:s', strtotime($time));
            })
            ->toArray();

        return array_values(array_filter($schedules, function($time) use ($bookedTimes) {
            return !in_array($time, $bookedTimes);
        }));
    }

    public function save()
    {
        $this->validate();

        $data = [
            'patient_id' => $this->patient_id,
            'doctor_id'  => $this->doctor_id,
            'date'       => $this->date,
            'start_time' => $this->start_time,
            'end_time'   => $this->end_time,
            'status'     => $this->status,
            'notes'      => $this->notes,
        ];

        if ($this->appointmentId) {
            Appointment::find($this->appointmentId)->update($data);
        } else {
            Appointment::create($data);
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Éxito!',
            'text' => 'Cita guardada correctamente.',
        ]);

        return redirect()->route('admin.appointments.index');
    }

    public function render()
    {
        $filteredDoctors = collect($this->doctorsList);
        if ($this->searchSpecialty) {
            $filteredDoctors = $filteredDoctors->where('specialty', $this->searchSpecialty);
        }

        // If a specific time is searched, filter doctors to those who have that time available
        if (!empty($this->searchTimeRange)) {
            $filteredDoctors = $filteredDoctors->filter(function($doctor) {
                return !empty($this->getAvailableTimes($doctor->id));
            });
        }

        return view('livewire.admin.appointments.appointment-form', [
            'filteredDoctors' => $filteredDoctors
        ]);
    }
}

