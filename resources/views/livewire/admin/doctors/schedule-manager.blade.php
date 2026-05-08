<div>
    <div class="bg-white rounded-lg shadow border border-gray-200">
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Gestor de horarios</h2>
            <button wire:click="save" class="px-6 py-2 bg-indigo-500 text-white font-medium rounded-lg hover:bg-indigo-600 transition">
                Guardar horario
            </button>
        </div>

        <div class="p-6 overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-400 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">DÍA/HORA</th>
                        @foreach($days as $day)
                            <th scope="col" class="px-6 py-4 font-medium tracking-wider text-center">{{ strtoupper($day) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Group hours by base hour, e.g. 08:00:00 -> [08:00:00, 08:15:00, 08:30:00, 08:45:00]
                        $baseHours = [];
                        foreach ($hours as $hour) {
                            if (substr($hour, 3, 2) === '00') {
                                $baseHours[] = $hour;
                            }
                        }
                    @endphp

                    @foreach($baseHours as $baseHour)
                        <tr class="bg-white border-b border-gray-100 align-top">
                            <td class="px-6 py-8 font-medium text-gray-900 align-middle">
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" disabled>
                                    <span>{{ $baseHour }}</span>
                                </div>
                            </td>
                            @foreach($days as $day)
                                <td class="px-6 py-4">
                                    <div class="flex flex-col space-y-3">
                                        <div class="flex items-center space-x-2 pb-2 border-b border-gray-100">
                                            <input type="checkbox" 
                                                   wire:click="toggleAll('{{ $day }}', '{{ $baseHour }}')"
                                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
                                            <span class="text-gray-700 font-medium cursor-pointer" wire:click="toggleAll('{{ $day }}', '{{ $baseHour }}')">Todos</span>
                                        </div>
                                        @for($i = 0; $i < 4; $i++)
                                            @php
                                                $timeSlot = date('H:i:s', strtotime($baseHour) + ($i * 15 * 60));
                                                $timeEnd = date('H:i', strtotime($timeSlot) + (15 * 60));
                                                $timeStart = date('H:i', strtotime($timeSlot));
                                                // Check if it exists in the main hours array (could be past 17:00)
                                                $exists = in_array($timeSlot, $hours);
                                            @endphp
                                            @if($exists)
                                                <label class="flex items-center space-x-2 cursor-pointer">
                                                    <input type="checkbox" 
                                                           wire:model="selectedSchedules.{{ $day }}.{{ $timeSlot }}"
                                                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                                    <span class="text-gray-600">{{ $timeStart }} - {{ $timeEnd }}</span>
                                                </label>
                                            @endif
                                        @endfor
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
