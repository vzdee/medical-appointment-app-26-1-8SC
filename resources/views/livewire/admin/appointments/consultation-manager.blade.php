<div>
    <!-- Header Patient Info -->
    <div class="bg-white rounded-t-lg border-b border-gray-200 p-6 flex justify-between items-start">
        <div>
            <h3 class="text-2xl font-bold text-gray-900">{{ $appointment->patient->user->name ?? 'Desconocido' }}</h3>
            <p class="text-sm text-gray-500 mt-1">DNI: {{ $appointment->patient->user->id_number ?? 'N/A' }}</p>
        </div>
        <div class="space-x-2">
            <button wire:click="$set('showMedicalHistory', true)" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <i class="fa-solid fa-file-medical mr-1"></i> Ver Historia
            </button>
            <button wire:click="loadHistory" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <i class="fa-solid fa-clock-rotate-left mr-1"></i> Consultas Anteriores
            </button>
        </div>
    </div>

    <!-- Tabs -->
    <div class="bg-white border-b border-gray-200 px-6">
        <nav class="-mb-px flex space-x-8">
            <button wire:click="setTab('consulta')" 
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $tab === 'consulta' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="fa-solid fa-stethoscope mr-2"></i> Consulta
                @if($errors->hasAny(['diagnosis', 'treatment', 'notes']))
                    <i class="fa-solid fa-circle-exclamation text-red-500 ml-1"></i>
                @endif
            </button>
            <button wire:click="setTab('receta')" 
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $tab === 'receta' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="fa-solid fa-prescription-bottle mr-2"></i> Receta
                @if($errors->hasAny(['medicines.*']))
                    <i class="fa-solid fa-circle-exclamation text-red-500 ml-1"></i>
                @endif
            </button>
        </nav>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-b-lg shadow-sm border border-t-0 border-gray-200 p-6">
        @if($tab === 'consulta')
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Diagnóstico</label>
                    <textarea wire:model="diagnosis" rows="4" class="w-full border-blue-500 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2" placeholder="Describa el diagnóstico del paciente aquí..."></textarea>
                    @error('diagnosis') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tratamiento</label>
                    <textarea wire:model="treatment" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2" placeholder="Describa el tratamiento recomendado aquí..."></textarea>
                    @error('treatment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notas</label>
                    <textarea wire:model="notes" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2" placeholder="Agregue notas adicionales sobre la consulta..."></textarea>
                    @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
        @elseif($tab === 'receta')
            <div class="space-y-4">
                @foreach($medicines as $index => $medicine)
                    <div class="flex items-start space-x-4">
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Medicamento</label>
                            <input type="text" wire:model="medicines.{{ $index }}.medicine" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2" placeholder="Ej. Amoxicilina 500mg">
                            @error('medicines.'.$index.'.medicine') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="w-48">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Dosis</label>
                            <input type="text" wire:model="medicines.{{ $index }}.dosage" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2" placeholder="Ej. 1 cada 8 horas">
                            @error('medicines.'.$index.'.dosage') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Frecuencia / Duración</label>
                            <input type="text" wire:model="medicines.{{ $index }}.frequency" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2" placeholder="Ej. por 7 días">
                            @error('medicines.'.$index.'.frequency') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="pt-6">
                            <button wire:click="removeMedicine({{ $index }})" class="p-2 bg-red-100 text-red-600 rounded hover:bg-red-200" title="Eliminar">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
                
                <div class="pt-4 border-t border-gray-100">
                    <button wire:click="addMedicine" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fa-solid fa-plus mr-1"></i> Añadir Medicamento
                    </button>
                </div>
            </div>
        @endif

        <div class="mt-8 flex justify-end">
            <button wire:click="save" class="px-6 py-2 bg-blue-500 text-white font-medium rounded-lg hover:bg-blue-600 transition flex items-center">
                <i class="fa-solid fa-floppy-disk mr-2"></i> Guardar Consulta
            </button>
        </div>
    </div>

    <!-- History Modal -->
    @if($showHistory)
    <div class="fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl m-4">
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">Historial de Consultas</h3>
                <button wire:click="$set('showHistory', false)" class="text-gray-400 hover:text-gray-500">
                    <i class="fa-solid fa-xmark fa-lg"></i>
                </button>
            </div>
            <div class="p-6 max-h-96 overflow-y-auto">
                @forelse($history as $histApp)
                    <div class="mb-4 pb-4 border-b border-gray-100 last:border-0 last:pb-0 last:mb-0">
                        <div class="flex justify-between mb-2">
                            <span class="font-bold text-blue-600">{{ $histApp->date->format('d/m/Y') }}</span>
                            <span class="text-sm text-gray-500">Dr. {{ $histApp->doctor->user->name ?? 'N/A' }}</span>
                        </div>
                        @if($histApp->diagnosis)
                            <p class="text-sm text-gray-700 mb-1"><strong>Diagnóstico:</strong> {{ $histApp->diagnosis }}</p>
                        @endif
                        @if($histApp->treatment)
                            <p class="text-sm text-gray-700 mb-1"><strong>Tratamiento:</strong> {{ $histApp->treatment }}</p>
                        @endif
                        @if($histApp->notes)
                            <p class="text-sm text-gray-500 italic mt-2">{{ $histApp->notes }}</p>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No hay consultas anteriores registradas.</p>
                @endforelse
            </div>
            <div class="p-6 border-t border-gray-200 flex justify-end">
                <button wire:click="$set('showHistory', false)" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Medical History Modal -->
    @if($showMedicalHistory)
    <div class="fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl m-4">
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900">Historia médica del paciente</h3>
                <button wire:click="$set('showMedicalHistory', false)" class="text-gray-400 hover:text-gray-500">
                    <i class="fa-solid fa-xmark fa-lg"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Tipo de sangre:</p>
                        <p class="text-sm font-bold text-gray-900">{{ $appointment->patient->bloodType->name ?? 'No registrado' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Alergias:</p>
                        <p class="text-sm font-bold text-gray-900">{{ $appointment->patient->allergies ?? 'No registradas' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Enfermedades crónicas:</p>
                        <p class="text-sm font-bold text-gray-900">{{ $appointment->patient->chronic_conditions ?? 'No registradas' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Antecedentes quirúrgicos:</p>
                        <p class="text-sm font-bold text-gray-900">{{ $appointment->patient->surgical_history ?? 'No registrados' }}</p>
                    </div>
                </div>
            </div>
            <div class="p-6 border-t border-gray-100 flex justify-end">
                <a href="{{ route('admin.patients.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                    Ver / Editar Historia Médica
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
