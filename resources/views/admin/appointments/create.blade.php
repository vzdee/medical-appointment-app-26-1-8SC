<x-admin-layout
    title="Crear Cita"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],[
            'name' => 'Citas',
            'href' => route('admin.appointments.index'),
        ],[
            'name' => 'Nuevo'
        ]
    ]">
    
    <div class="mt-4">
        @livewire('admin.appointments.appointment-form')
    </div>
</x-admin-layout>
