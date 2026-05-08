<x-admin-layout
    title="Consulta"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],[
            'name' => 'Citas',
            'href' => route('admin.appointments.index'),
        ],[
            'name' => 'Consulta'
        ]
    ]">
    
    <div class="mt-4">
        @livewire('admin.appointments.consultation-manager', ['appointment' => $appointment])
    </div>
</x-admin-layout>
