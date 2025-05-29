<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <h2 class="text-xl font-semibold mb-4">
            Bienvenido{{ Auth::user()->role !== 'cliente' ? ',' : '' }} {{ Auth::user()->name }}
        </h2>

        @switch(Auth::user()->role)

            {{-- ADMIN --}}
            @case('admin')
                <div class="grid gap-4 md:grid-cols-3">
                    <div class="bg-white dark:bg-neutral-800 p-4 rounded-xl shadow border">
                        <h3 class="text-sm text-gray-600 mb-1">Total de Usuarios</h3>
                        <div class="text-2xl font-bold">123</div>
                        <a href="#" class="text-blue-600 text-sm mt-2 inline-block">Ver todos</a>
                    </div>
                    <div class="bg-white dark:bg-neutral-800 p-4 rounded-xl shadow border">
                        <h3 class="text-sm text-gray-600 mb-1">Citas Programadas</h3>
                        <div class="text-2xl font-bold">56</div>
                        <a href="#" class="text-blue-600 text-sm mt-2 inline-block">Ver citas</a>
                    </div>
                    <div class="bg-white dark:bg-neutral-800 p-4 rounded-xl shadow border">
                        <h3 class="text-sm text-gray-600 mb-1">Modelos Registrados</h3>
                        <div class="text-2xl font-bold">42</div>
                        <a href="{{ route('autos.crud') }}" class="text-blue-600 text-sm mt-2 inline-block">Ver modelos</a>
                    </div>
                </div>
                @break

            {{-- EMPLEADO --}}
            @case('empleado')
                <div class="grid gap-4 md:grid-cols-3">
                    <div class="bg-white dark:bg-neutral-800 p-4 rounded-xl shadow border">
                        <h3 class="text-sm text-gray-600 mb-1">Citas asignadas</h3>
                        <div class="text-2xl font-bold">14</div>
                        <a href="#" class="text-blue-600 text-sm mt-2 inline-block">Mis citas</a>
                    </div>
                    <div class="bg-white dark:bg-neutral-800 p-4 rounded-xl shadow border">
                        <h3 class="text-sm text-gray-600 mb-1">Modelos disponibles</h3>
                        <div class="text-2xl font-bold">20</div>
                        <a href="#" class="text-blue-600 text-sm mt-2 inline-block">Ver modelos</a>
                    </div>
                    <div class="bg-white dark:bg-neutral-800 p-4 rounded-xl shadow border">
                        <h3 class="text-sm text-gray-600 mb-1">Historial de atención</h3>
                        <div class="text-2xl font-bold">89</div>
                        <a href="#" class="text-blue-600 text-sm mt-2 inline-block">Ver historial</a>
                    </div>
                </div>
                @break

            {{-- CLIENTE --}}
            @case('cliente')
                <div class="grid gap-4 md:grid-cols-3">
                    <div class="bg-white dark:bg-neutral-800 p-4 rounded-xl shadow border">
                        <h3 class="text-sm text-gray-600 mb-1">Próxima Cita</h3>
                        <div class="text-2xl font-bold">15 Mayo, 2023</div>
                        <a href="#" class="text-blue-600 text-sm mt-2 inline-block">Ver detalles</a>
                    </div>
                    <div class="bg-white dark:bg-neutral-800 p-4 rounded-xl shadow border">
                        <h3 class="text-sm text-gray-600 mb-1">Vehículos Registrados</h3>
                        <div class="text-2xl font-bold">2</div>
                        <a href="#" class="text-blue-600 text-sm mt-2 inline-block">Administrar vehículos</a>
                    </div>
                    <div class="bg-white dark:bg-neutral-800 p-4 rounded-xl shadow border">
                        <h3 class="text-sm text-gray-600 mb-1">Historial de Servicios</h3>
                        <div class="text-2xl font-bold">8</div>
                        <a href="#" class="text-blue-600 text-sm mt-2 inline-block">Ver historial</a>
                    </div>
                </div>
                @break

        @endswitch
    </div>
</x-layouts.app>
