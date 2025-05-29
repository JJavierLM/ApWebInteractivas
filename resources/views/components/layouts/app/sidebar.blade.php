<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">
<flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.toggle class="lg:hidden" />

    <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
        <x-app-logo />
    </a>

    {{-- Navegación por rol --}}
    <flux:navlist variant="outline">
        <flux:navlist.group :heading="__('Menú')" class="grid">
            {{-- Botón de Inicio visible para todos --}}
            <flux:navlist.item :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                {{ __('Inicio') }}
            </flux:navlist.item>

            {{-- Dashboard --}}
            <flux:navlist.item :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </flux:navlist.item>

            @php $role = auth()->user()->role; @endphp

            @if ($role === 'admin')
                <flux:navlist.item :href="route('empleados.index')" :current="request()->routeIs('empleados.*')" wire:navigate>
                    {{ __('Empleados') }}
                </flux:navlist.item>
                <flux:navlist.item :href="route('autos.index')" :current="request()->routeIs('autos.*')" wire:navigate>
                    {{ __('Vehículos') }}
                </flux:navlist.item>
                <flux:navlist.item :href="route('citas.index')" :current="request()->routeIs('citas.index')" wire:navigate>
                    {{ __('Citas') }}
                </flux:navlist.item>
            @elseif ($role === 'empleado')
                <flux:navlist.item :href="route('citas.index')" :current="request()->routeIs('citas.index')" wire:navigate>
                    {{ __('Mis Citas') }}
                </flux:navlist.item>
                <flux:navlist.item :href="route('autos.index')" :current="request()->routeIs('autos.*')" wire:navigate>
                    {{ __('Modelos') }}
                </flux:navlist.item>
            @elseif ($role === 'cliente')
                <flux:navlist.item :href="route('citas.mis')" :current="request()->routeIs('citas.mis')" wire:navigate>
                    {{ __('Mis Citas') }}
                </flux:navlist.item>
                <flux:navlist.item :href="route('autos.index')" :current="request()->routeIs('autos.*')" wire:navigate>
                    {{ __('Mis Vehículos') }}
                </flux:navlist.item>
            @endif
        </flux:navlist.group>
    </flux:navlist>

    <flux:spacer />

    {{-- Menú de usuario (escritorio) --}}
    <flux:dropdown position="bottom" align="start">
        <flux:profile
            :name="auth()->user()->name"
            :initials="auth()->user()->initials()"
        />

        <flux:menu class="w-[220px]">
            <flux:menu.radio.group>
                <div class="p-0 text-sm font-normal">
                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                        <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                            <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                {{ auth()->user()->initials() }}
                            </span>
                        </span>
                        <div class="grid flex-1 text-start text-sm leading-tight">
                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                </div>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <flux:menu.radio.group>
                <flux:menu.item :href="route('settings.profile')" wire:navigate>
                    {{ __('Settings') }}
                </flux:menu.item>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" class="w-full">
                    {{ __('Log Out') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:sidebar>

{{-- Menú móvil --}}
<flux:header class="lg:hidden">
    <flux:sidebar.toggle class="lg:hidden" inset="left" />
    <flux:spacer />
    <flux:dropdown position="top" align="end">
        <flux:profile :initials="auth()->user()->initials()" />
        <flux:menu>
            <flux:menu.radio.group>
                <div class="p-0 text-sm font-normal">
                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                        <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                            <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                {{ auth()->user()->initials() }}
                            </span>
                        </span>
                        <div class="grid flex-1 text-start text-sm leading-tight">
                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                        </div>
                    </div>
                </div>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <flux:menu.radio.group>
                <flux:menu.item :href="route('settings.profile')" wire:navigate>
                    {{ __('Settings') }}
                </flux:menu.item>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item as="button" type="submit" class="w-full">
                    {{ __('Log Out') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:header>

{{ $slot }}

@fluxScripts
</body>
</html>
