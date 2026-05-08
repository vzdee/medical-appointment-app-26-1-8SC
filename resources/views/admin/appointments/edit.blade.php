<x-admin-layout
    title="Editar Cita"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],[
            'name' => 'Citas',
            'href' => route('admin.appointments.index'),
        ],[
            'name' => 'Editar'
        ]
    ]">
    
    <div class="mt-4">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Editar</h2>
        @livewire('admin.appointments.appointment-form', ['appointmentId' => $appointment->id])
    </div>
</x-admin-layout>
