{{-- vierificar si existe un elemento en el arreglo breadcrumb --}}
@if (count($breadcrumbs))
    <nav class="mb-2 block">
        <ol class="flex flex-wrap text-slate-700 text-sm">
            @foreach ($breadcrumbs as $item)
                <li class="flex items-center">
                    {{-- SI NO ES EL PRIMER ELEMENTO, PINTA EL SEPARADOR CON ESPACIO --}}
                    @unless ($loop->first)
                        <span class="px-2 text-gray-400"> / </span>
                    @endunless
                    {{-- Revisa SI EXISTE una llave llamado href --}}
                    @isset($item['href'])
                        <a href="{{ $item['href'] }}" class="opacity-60 hove:opacity-100 transition">{{ $item['name'] }}</a>
                    @else
                        {{ $item['name'] }}
                    @endisset
                </li>
            @endforeach
        </ol>
        {{-- El último elemento aprecera resaltado --}}
        @if (count($breadcrumbs) > 1)
            <h6 class="font-bold mt-2">
                {{ end($breadcrumbs)['name'] }}
            </h6>
        @endif
    </nav>
@endif
