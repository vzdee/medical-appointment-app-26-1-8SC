<x-admin-layout title="Editar Especialidad" :breadcrumbs="[
  [
    'name' => 'Dashboard',
    'href' => route('admin.dashboard'),
  ],[
    'name' => 'Doctores',
    'href' => route('admin.doctors.index'),
  ],[
    'name' => 'Editar Especialidad',
  ]
]">

    <div class="mt-4 bg-white rounded-lg shadow border border-gray-200 w-full max-w-2xl">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Editar Especialidad</h2>
            <p class="text-sm text-gray-500 mt-1">
                Doctor: <strong>{{ $doctor->user->name ?? 'N/A' }}</strong>
            </p>
        </div>

        <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="specialty" class="block text-sm font-medium text-gray-700 mb-2">Especialidad</label>
                <input type="text" name="specialty" id="specialty" value="{{ old('specialty', $doctor->specialty) }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                       placeholder="Ej. Cardiología, Endocrinología, etc.">
                @error('specialty')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.doctors.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>

</x-admin-layout>
