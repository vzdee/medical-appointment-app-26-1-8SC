<div class="space-y-6">
    <!-- Top Section: Buscar disponibilidad -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-1">Buscar disponibilidad</h2>
        <p class="text-sm text-gray-500 mb-4">Encuentra el horario perfecto para tu cita.</p>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                <input type="date" wire:model.live="searchDate" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hora</label>
                <div class="relative">
                    <select wire:model.live="searchTimeRange" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm appearance-none pr-8">
                        <option value="">Cualquier hora</option>
                        @foreach($allSchedules as $time)
                            <option value="{{ $time }}">{{ date('H:i', strtotime($time)) }} - {{ date('H:i', strtotime('+15 minutes', strtotime($time))) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Especialidad (opcional)</label>
                <div class="relative">
                    <select wire:model.live="searchSpecialty" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm appearance-none">
                        <option value="">Seleccione especialidad</option>
                        @foreach($specialties as $specialty)
                            <option value="{{ $specialty }}">{{ $specialty }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <button type="button" class="w-full px-4 py-2 bg-indigo-500 text-white font-medium rounded-lg hover:bg-indigo-600 transition">
                    Buscar disponibilidad
                </button>
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column: Doctors List -->
        <div class="col-span-1 lg:col-span-2 space-y-4">
            @forelse($filteredDoctors as $doctor)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xl font-bold uppercase">
                            {{ substr($doctor->user->name ?? 'DR', 0, 2) }}
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Dr. {{ $doctor->user->name ?? 'Desconocido' }}</h3>
                            <p class="text-sm text-indigo-600">{{ $doctor->specialty ?? 'General' }}</p>
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-2">Horarios disponibles:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($this->getAvailableTimes($doctor->id) as $time)
                                <button type="button" wire:click="selectTime({{ $doctor->id }}, '{{ $time }}')" 
                                        class="px-6 py-2 rounded-lg text-sm font-medium transition {{ $doctor_id == $doctor->id && $start_time == $time ? 'bg-indigo-600 text-white' : 'bg-indigo-400 text-white hover:bg-indigo-600 transition' }}">
                                    {{ $time }}
                                </button>
                            @endforeach
                            @if(empty($this->getAvailableTimes($doctor->id)))
                                <span class="text-sm text-gray-500">No hay horarios disponibles para esta fecha.</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center text-gray-500">
                    No se encontraron doctores con los criterios de búsqueda.
                </div>
            @endforelse
        </div>

        <!-- Right Column: Resumen de la cita -->
        <div class="col-span-1">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sticky top-6">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Resumen de la cita</h3>
                
                <div class="space-y-4 mb-6">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Doctor:</span>
                        <span class="font-medium text-gray-900">
                            @if($doctor_id)
                                Dr. {{ collect($doctorsList)->firstWhere('id', $doctor_id)->user->name ?? '' }}
                            @else
                                <span class="text-gray-400">Sin seleccionar</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Fecha:</span>
                        <span class="font-medium text-gray-900">{{ $date ? $date : '--' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Horario:</span>
                        <span class="font-medium text-gray-900">
                            @if($start_time && $end_time)
                                {{ $start_time }} - {{ $end_time }}
                            @else
                                --
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Duración:</span>
                        <span class="font-medium text-gray-900">
                            @if($start_time && $end_time)
                                15 minutos
                            @else
                                --
                            @endif
                        </span>
                    </div>
                </div>

                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Paciente</label>
                        <select wire:model="patient_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <option value="">Seleccione un paciente</option>
                            @foreach($patients as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('patient_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        @error('doctor_id') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                        @error('date') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Motivo de la cita</label>
                        <textarea wire:model="notes" rows="3" class="w-full border-indigo-500 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" placeholder="Describa el motivo..."></textarea>
                        @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full px-4 py-3 bg-indigo-500 text-white font-medium rounded-lg hover:bg-indigo-600 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        Confirmar cita
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
