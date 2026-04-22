<x-admin-layout title="Pacientes" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Pacientes',
        'href' => route('admin.patients.index'),
    ],
    [
        'name' => 'Editar',
    ],
]">

    <form action="{{ route('admin.patients.update', $patient->id) }}" method="POST">
        @csrf
        @method('PUT')
        <x-wire-card class="mb-8">
            <div class="lg:flex lg:items-center lg:justify-between ">
                <div class="flex items-center gap-2">
                    <img src="{{ $patient->user->profile_photo_url }}" alt="{{ $patient->user->name }}"
                        class="h-20 w-20 rounded-full object-cover object-center">
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $patient->user->name }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-1 mt-6 lg:mb-0">
                    <x-wire-button outline gray href="{{ route('admin.patients.index') }}">Volver</x-wire-button>
                    <x-wire-button type="submit">
                        <i class="fa-solid fa-check"></i>
                        Guardar Cambios
                    </x-wire-button>
                </div>
            </div>
        </x-wire-card>

        {{-- NAV TABS --}}

        <x-wire-card>
            <div x-data="{ tab: 'datos-personales' }">
                {{-- Menú de pestanhas --}}
                <div class="border-b border-gray-200">
                    {{-- datos personales --}}
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-body text-gray-500">
                        <li class="me-2">
                            <a href="#" x-on:click="tab = 'datos-personales'"
                                :class="{
                                    'text-blue-600 border-blue-600 active': tab === 'datos-personales',
                                    'border-transparent hover:text-blue-600 hover:border-gray-300': tab !== 'datos-personales'
                                }"
                                class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group transition-colors duration-200"
                                :aria-current="tab === 'datos-personales' ? 'page' : undefined">
                                <i class="fa-solid fa-user me-2"></i>
                                Datos Personales
                            </a>
                        </li>
                        {{-- Tab 2 Antecedentes --}}
                        <li class="me-2">
                            <a href="#" x-on:click="tab = 'antecedentes'"
                                :class="{
                                    'text-blue-600 border-blue-600 active': tab === 'antecedentes',
                                    'border-transparent hover:text-blue-600 hover:border-gray-300': tab !== 'antecedentes'
                                }"
                                class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group transition-colors duration-200"
                                :aria-current="tab === 'antecedentes' ? 'page' : undefined">
                                <i class="fa-solid fa-file-lines me-2"></i>
                                Antecedentes
                            </a>
                        </li>
                        {{-- Tab 3 Informacion General --}}
                        <li class="me-2">
                            <a href="#" x-on:click="tab = 'informacion-general'"
                                :class="{
                                    'text-blue-600 border-blue-600 active': tab === 'informacion-general',
                                    'border-transparent hover:text-blue-600 hover:border-gray-300': tab !== 'informacion-general'
                                }"
                                class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group transition-colors duration-200"
                                :aria-current="tab === 'informacion-general' ? 'page' : undefined">
                                <i class="fa-solid fa-info me-2"></i>
                                Información General
                            </a>
                        </li>
                        {{-- Tab 4 Contacto Emergencia --}}
                        <li class="me-2">
                            <a href="#" x-on:click="tab = 'contacto-emergencia'"
                                :class="{
                                    'text-blue-600 border-blue-600 active': tab === 'contacto-emergencia',
                                    'border-transparent hover:text-blue-600 hover:border-gray-300': tab !== 'contacto-emergencia'
                                }"
                                class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group transition-colors duration-200"
                                :aria-current="tab === 'contacto-emergencia' ? 'page' : undefined">
                                <i class="fa-solid fa-heart me-2"></i>
                                Contacto Emergencia
                            </a>
                        </li>
                    </ul>
                </div>
                {{-- Contenido de los tabls --}}
                <div class="px-4 mt-4">
                    {{-- Contenido Tab 1: Datos Personales --}}
                    <div class="" x-show="tab === 'datos-personales'">
                        <div class="bg-blue-100 border-l-4 border-blue-500 mb-6 p-4 rounded-r-lg shadow-sm">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                {{-- lado izquierdo --}}
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <i class="fa-solid fa-user-gear text-blue-500 text-xl me-2 mt-1"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-bold text-blue-800"> Edición de cuenta de usuario</h3>
                                        <div class="mt-1 text-sm text-blue-600">
                                            <p>La<strong> Información de Usuario</strong>(Nombre, Email y Contraseña)
                                                debe gestionarse desde la cuenta del usuario asociada:</p>
                                        </div>
                                    </div>
                                </div>
                                {{-- Lado derecho --}}
                                <div class="flex-shrink-0">
                                    <x-wire-button primary sm href="{{ route('admin.users.edit', $patient->user) }}"
                                        target="_blank">
                                        Editar Usuario
                                        <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
                                    </x-wire-button>
                                </div>
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-2 gap-4">
                            <div>
                                <span class="text-gray-500 font-semibold ml-1">Telefono:</span>
                                <span class="text-gray-900 font-semibold ml-1">{{ $patient->user->phone }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 font-semibold ml-1">Email:</span>
                                <span class="text-gray-900 font-semibold ml-1">{{ $patient->user->email }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 font-semibold ml-1">Dirección:</span>
                                <span class="text-gray-900 font-semibold ml-1">{{ $patient->user->address }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Contenido Tab 2: Antecedentes --}}
                    <div x-show="tab === 'antecedentes'" style="display: none">
                        <div class="grid lg:grid-cols-2 gap-4">
                            <div>
                                <x-wire-textarea label="Alergias conocidas" name="allergies">
                                    {{ old('allergies', $patient->allergies) }}
                                </x-wire-textarea>
                            </div>
                            <div>
                                <x-wire-textarea label="Enfermedades cronicas" name="chronic_conditions">
                                    {{ old('chronic_conditions', $patient->chronic_conditions) }}
                                </x-wire-textarea>
                            </div>
                            <div>
                                <x-wire-textarea label="Historial Quirúrgico" name="surgical_history">
                                    {{ old('surgical_history', $patient->surgical_history) }}
                                </x-wire-textarea>
                            </div>
                            <div>
                                <x-wire-textarea label="Alergias familiares" name="family_allergies">
                                    {{ old('family_allergies', $patient->family_allergies) }}
                                </x-wire-textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Contenido Tab 3: Información General --}}
                    <div x-show="tab === 'informacion-general'" style="display: none">
                        <div class="grid lg:grid-cols-2 gap-4">
                            <x-wire-native-select label="Tipo de Sangre" class="mb-4" name="blood_type_id">
                                @foreach ($bloodTypes as $bloodType)
                                    <option value="{{ $bloodType->id }}" @selected(old('blood_type_id', $patient->blood_type_id) == $bloodType->id)>
                                        {{ $bloodType->name }}
                                    </option>
                                @endforeach
                            </x-wire-native-select>
                            <x-wire-textarea label="Observaciones"
                                name="observations">{{ old('observations', $patient->observations) }}</x-wire-textarea>
                        </div>
                    </div>

                    {{-- Contenido Tab 4: Contacto Emergencia --}}
                    <div x-show="tab === 'contacto-emergencia'" style="display: none">
                        <div class="space-y-4">
                            <x-wire-input label="Nombre del contacto de emergencia" name="emergency_contact_name"
                                value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}" />
                            <x-wire-phone mask="(###) ###-####" placeholder="(999) 999-2222" label="Telefono del contacto de emergencia" name="emergency_contact_phone"
                                value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}"/>
                            <x-wire-input label="Relacion con el contacto de emergencia"
                                name="emergency_contact_relationship"
                                value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship) }}" placeholder="Familiar, amigo, etc"/>
                        </div>
                    </div>
                </div>
            </div>
        </x-wire-card>
    </form>


</x-admin-layout>
