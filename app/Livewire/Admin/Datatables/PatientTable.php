<?php

namespace App\Livewire\Admin\Datatables;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Patient;

class PatientTable extends DataTableComponent
{
    //protected $model = Patient::class;
    public function builder(): Builder{
        return Patient::query()
        ->with('user'); // Cargar la relación de roles para evitar consultas adicionales

    }
    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Nombre", "user.name")
                ->sortable(),
            Column::make("Email", "user.email")
                ->sortable(),
            Column::make("Numero ID", "user.id_number")
                ->sortable(),
            Column::make("Telefono", "user.phone")
                ->sortable(),
            Column::make("Acciones")
                ->label(function($row){
                    return view('admin.patients.actions', ['patient' => $row]);
                })

        ];
    }
}
