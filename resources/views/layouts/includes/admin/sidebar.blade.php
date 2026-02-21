@php
  //ARREGLO DE PRUEBA PARA EL SIDEBAR, SE DEBE REEMPLAZAR POR LOS DATOS REALES
  $links = [
    [
      'name' => 'Dashboard',
      'icon' => 'fa-solid fa-gauge',
      'href' => route('admin.dashboard'),
      'active' => request()->routeIs('admin.dashboard'),
    ],[
    'header' => 'Administración'
    ],
    [
      'name' => 'Personas',
      'icon' => 'fa-solid fa-user-group',
      'href' => route('admin.dashboard'),
      'active' => request()->routeIs('admin.dashboard'),
    ],
  ];
@endphp


<aside id="top-bar-sidebar"
  class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0"
  aria-label="Sidebar">
  <div class="h-full px-3 py-4 overflow-y-auto bg-neutral-primary-soft border-e border-default">
    <a href="/" class="flex items-center ps-2 mb-5">
      <img src="{{asset('img/logo_personal.svg')}}" class="h-10 me-2" alt="Logo" />
      <span class="self-center text-lg text-heading font-semibold whitespace-nowrap "></span>
    </a>
    <ul class="space-y-2 font-medium">
      @foreach ($links as $link)
        <li>
          {{-- - Si revisa si existe una llave/prop --}}
          @isset($link['header'])
            <div class="px-2 py-2 text-xs font-semibold text-gray-500 uppercase">
              {{ $link['header'] }}
            </div>
          @else
            <a href="{{ $link['href'] }}"
              class="flex items-center px-3 py-3 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group {{ $link['active'] ? 'bg-gray-100' : '' }}">
              <i class="{{ $link['icon'] }}"></i>
              <span class="ms-3">{{ $link['name'] }}</span>
            </a>
          @endisset
        </li>
      @endforeach
    </ul>
  </div>
  <script src="https://kit.fontawesome.com/e732c9a5c1.js" crossorigin="anonymous"></script>
</aside>