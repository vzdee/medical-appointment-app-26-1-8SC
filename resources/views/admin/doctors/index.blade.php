<x-admin-layout title="Doctores" :breadcrumbs="[
  [
    'name' => 'Dashboard',
    'href' => route('admin.dashboard'),
  ],[
    'name' => 'Doctores',
  ],
]">
    
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
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">ID <i class="fa-solid fa-sort ml-1"></i></th>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">NOMBRE <i class="fa-solid fa-sort ml-1"></i></th>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">EMAIL <i class="fa-solid fa-sort ml-1"></i></th>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">DNI <i class="fa-solid fa-sort ml-1"></i></th>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">TELÉFONO <i class="fa-solid fa-sort ml-1"></i></th>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">ESPECIALIDAD <i class="fa-solid fa-sort ml-1"></i></th>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider text-center">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($doctors as $doctor)
                        <tr class="bg-white border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $doctor->id }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $doctor->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $doctor->user->email ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $doctor->user->id_number ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $doctor->user->phone ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $doctor->specialty ?? 'N/A' }}</td>
                            <td class="px-6 py-4 flex justify-center space-x-2">
                                <a href="{{ route('admin.doctors.edit', $doctor) }}" class="p-2 bg-blue-500 text-white rounded hover:bg-blue-600 shadow-sm" title="Editar">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="{{ route('admin.doctors.schedules', $doctor) }}" class="p-2 bg-green-500 text-white rounded hover:bg-green-600 shadow-sm" title="Horarios">
                                    <i class="fa-solid fa-clock"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center">No hay doctores registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-200">
            {{ $doctors->links() }}
        </div>
    </div>
</x-admin-layout>