<x-admin-layout title="Usuarios" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Usuarios',
        'href' => route('admin.users.index'),
    ],
    [
        'name' => 'Crear',
    ],
]">

    <x-wire-card>
      <x-validation-errors class="mb-4" />
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div class="grid lg:grid-cols-2 gap-4">
                    <x-wire-input label="Nombre" name="name" placeholder="Nombre del usuario" autocomplete="email" required value="{{ old('name') }}"
                        ></x-wire-input>
                    <x-wire-input label="Correo Electrónico" name="email" placeholder="ejemplo@dominio.com" required value="{{ old('email') }}"
                        ></x-wire-input>
                    <x-wire-input label="Contraseña" type="password" name="password" placeholder="minimo 8 caracteres" required autocomplete="new-password"></x-wire-input>
                    <x-wire-input label="Confirmar Contraseña" type="password" name="password_confirmation" placeholder="Confirma la contraseña" required autocomplete="new-password"></x-wire-input>
                    <x-wire-input label="Numero ID" name="id_number" placeholder="Numero de identificacion" required autocomplete="off" inputmode="numeric" value="{{ old('id_number') }}"></x-wire-input>
                    <x-wire-input label="Telefono" name="phone" placeholder="999395969" required autocomplete="" inputmode="tel" value="{{ old('phone') }}"></x-wire-input>
                    <x-wire-input label="Direccion" name="address" placeholder="Direccion del usuario"  autocomplete="street-address" value="{{ old('address') }}"></x-wire-input>

                    <div class="space-y-1">
                      <x-wire-native-select label="Rol" name="role_id" required>
                        <option value="">Seleccione un rol</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>{{ $role->name }}</option>
                        @endforeach
                      </x-wire-native-select>
                      <p class="text-sm text-gray-500">Define los permisos y accesos del usuario</p>
                    </div>
  
                  </div>
                  <div class="flex justify-end">
                      <x-wire-button type="submit" blue>Guardar</x-wire-button>
                  </div>
            </div>
        </form>
    </x-wire-card>


</x-admin-layout>
