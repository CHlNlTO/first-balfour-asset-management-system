<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-8 p-2 md:p-4 lg:p-6 md:grid-cols-3">
        <a href="{{ route('filament.admin.resources.assets.create-hardware') }}" class="block">
            <div
                class="p-4 transition-shadow bg-white rounded-lg shadow-lg md:p-4 lg:p-6 hover:shadow-xl ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/hardware-logo.png') }}" class="w-full h-auto rounded-lg"
                        alt="Create Hardware" />
                    {{-- <h3 class="text-lg font-medium text-gray-900">Hardware</h3>
                    <p class="mt-2 text-sm text-center text-gray-500">
                        Create new hardware assets like computers, laptops, and servers
                    </p> --}}
                </div>
            </div>
        </a>

        <a href="{{ route('filament.admin.resources.assets.create-software') }}" class="block">
            <div
                class="p-4 transition-shadow bg-white rounded-lg shadow-lg md:p-4 lg:p-6 hover:shadow-xl ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/software-logo.png') }}" class="w-full h-auto rounded-lg"
                        alt="Create Software" />
                    {{-- <h3 class="text-lg font-medium text-gray-900">Software</h3>
                    <p class="mt-2 text-sm text-center text-gray-500">
                        Create new software assets like applications, licenses, and drivers
                    </p> --}}
                </div>
            </div>
        </a>

        <a href="{{ route('filament.admin.resources.assets.create-peripherals') }}" class="block">
            <div
                class="p-4 transition-shadow bg-white rounded-lg shadow-lg md:p-4 lg:p-6 hover:shadow-xl ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/peripherals-logo.png') }}" class="w-full h-auto rounded-lg"
                        alt="Create Peripherals" />
                    {{-- <h3 class="text-lg font-medium text-gray-900">Peripherals</h3>
                    <p class="mt-2 text-sm text-center text-gray-500">
                        Create new peripheral assets like bags, headsets, and accessories
                    </p> --}}
                </div>
            </div>
    </div>
</x-filament-panels::page>
