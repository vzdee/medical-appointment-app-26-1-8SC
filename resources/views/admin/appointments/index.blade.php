<x-admin-layout
    title="Citas Médicas"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],[
            'name' => 'Citas'
        ]
    ]">
    
    <x-slot:action>
        <a href="{{ route('admin.appointments.create') }}" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
            + Nuevo
        </a>
    </x-slot:action>

    <div class="mt-4 bg-white rounded-lg shadow border border-gray-200">
        <div class="p-4 flex justify-between items-center border-b border-gray-200">
            <input type="text" placeholder="Buscar" class="border border-gray-300 rounded-lg px-4 py-2 w-64 text-sm focus:ring-blue-500 focus:border-blue-500">
            
            <div class="flex items-center space-x-2">
                <select class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option>Columnas</option>
                </select>
                <select class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option>10</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-400 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">Paciente</th>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">Doctor</th>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">Fecha</th>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">Hora</th>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">Hora Fin</th>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">Estado</th>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $app)
                        <tr class="bg-white border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $app->id }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $app->patient->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $app->doctor->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $app->date->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">{{ date('H:i', strtotime($app->start_time)) }}</td>
                            <td class="px-6 py-4">{{ date('H:i', strtotime($app->end_time)) }}</td>
                            <td class="px-6 py-4">{{ $app->status }}</td>
                            <td class="px-6 py-4 flex space-x-2">
                                <a href="{{ route('admin.appointments.edit', $app) }}" class="p-2 bg-blue-100 text-blue-600 rounded hover:bg-blue-200">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="{{ route('admin.appointments.show', $app) }}" class="p-2 bg-green-100 text-green-600 rounded hover:bg-green-200">
                                    <i class="fa-solid fa-file-medical"></i>
                                </a>
                                <form action="{{ route('admin.appointments.destroy', $app) }}" method="POST" class="inline" id="delete-form-{{ $app->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete('delete-form-{{ $app->id }}')" class="p-2 bg-red-100 text-red-600 rounded hover:bg-red-200">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center">No hay citas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-200">
            {{ $appointments->links() }}
        </div>
    </div>

    <script>
        function confirmDelete(formId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esto. La cita será eliminada.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            })
        }
    </script>
</x-admin-layout>