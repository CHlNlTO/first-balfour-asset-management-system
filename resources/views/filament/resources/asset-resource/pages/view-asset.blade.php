@php
    function displayText($value, $placeholder = 'Not Available')
    {
        return !empty($value) ? $value : $placeholder;
    }
@endphp

<x-filament::page>
    <div class="border border-blue-100 shadow-lg bg-gradient-to-r from-blue-500 via-blue-400 to-blue-500 rounded-xl">
        <div class="w-full px-4 py-8 md:px-8">
            <div class="flex items-start justify-between w-full">
                <div class="w-full space-y-1">
                    <div class="flex items-center space-x-3">
                        <h1 class="text-3xl font-bold text-white">
                            {{ displayText(($record->model?->brand?->name ?? '') . ' ' . ($record->model?->name ?? ''), 'Untitled Asset') }}
                        </h1>
                    </div>
                    <div class="flex items-start justify-between">
                        <p class="flex items-center text-blue-100">
                            {{ ucfirst(displayText($record->asset_type, 'Unspecified Type')) }}
                        </p>
                        @php
                            $isActive = $record->assetStatus?->asset_status === 'Active';
                        @endphp
                        <div
                            class="flex items-center px-4 py-2 rounded-full {{ $isActive ? 'bg-green-700/60 text-green-100' : 'bg-red-700/60 text-red-100' }}">
                            <span
                                class="h-2.5 w-2.5 rounded-full {{ $isActive ? 'bg-green-400' : 'bg-red-400' }} mr-2"></span>
                            {{ displayText($record->assetStatus?->asset_status, 'Unknown Status') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-4 py-4 border-t md:px-8 border-white/20">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <!-- Quick Stats -->
                @php
                    $quickStats = [
                        [
                            'icon' => 'building-office',
                            'label' => 'Cost Code',
                            'value' => $record->costCode?->name ?? 'Not Available',
                        ],
                        [
                            'icon' => 'calendar',
                            'label' => 'Acquired',
                            'value' => $record->lifecycle?->acquisition_date
                                ? \Carbon\Carbon::parse($record->lifecycle->acquisition_date)->format('M d, Y')
                                : null,
                        ],
                        [
                            'icon' => 'key',
                            'label' => 'License',
                            'value' => $record->software?->licenseType?->license_type,
                        ],
                        [
                            'icon' => 'currency-dollar',
                            'label' => 'Cost',
                            'value' => $record->purchases?->first()?->purchase_order_amount
                                ? '₱' . number_format($record->purchases[0]->purchase_order_amount, 2)
                                : null,
                        ],
                    ];
                @endphp

                @foreach ($quickStats as $stat)
                    <div class="flex items-center space-x-3">
                        <div class="p-2 rounded-lg bg-white/30">
                            <x-dynamic-component :component="'heroicon-o-' . $stat['icon']" class="w-5 h-5 text-white" />
                        </div>
                        <div>
                            <p class="text-xs text-blue-100">{{ $stat['label'] }}</p>
                            <p class="text-sm font-semibold text-white">
                                {{ displayText($stat['value']) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <div class="space-y-6">
            @if ($record->asset_type === 'software')
                <div class="overflow-hidden bg-white border border-blue-100 shadow-sm rounded-xl">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-500 via-blue-400 to-blue-500">
                        <h2 class="flex items-center text-lg font-semibold text-white">
                            <x-heroicon-o-code-bracket class="w-5 h-5 mr-2 text-white" />
                            Software Details
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-blue-400">PC Name</span>
                                <div
                                    class="p-3 mt-2 font-mono text-blue-800 border border-blue-100 rounded-lg bg-blue-50">
                                    {{ displayText($record->software?->pcName?->name, 'Unassigned') }}
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-blue-400">Type</span>
                                <div
                                    class="p-3 mt-2 font-mono text-blue-800 border border-blue-100 rounded-lg bg-blue-50">
                                    {{ displayText($record->software?->softwareType?->software_type) }}
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="pt-4 border-t border-gray-100">
                                <span class="text-sm font-medium text-blue-400">Version</span>
                                <div
                                    class="p-3 mt-2 font-mono text-blue-800 border border-blue-100 rounded-lg bg-blue-50">
                                    {{ displayText($record->software?->version) }}
                                </div>
                            </div>
                            <div class="pt-4 border-t border-gray-100">
                                <span class="text-sm font-medium text-blue-400">License Key</span>
                                <div
                                    class="p-3 mt-2 font-mono text-blue-800 border border-blue-100 rounded-lg bg-blue-50">
                                    {{ displayText($record->software?->license_key, 'No License Key Available') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($record->asset_type === 'hardware')
                <div class="overflow-hidden bg-white border border-blue-100 shadow-sm rounded-xl">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-500 via-blue-400 to-blue-500">
                        <h2 class="flex items-center text-lg font-semibold text-white">
                            <x-heroicon-o-computer-desktop class="w-5 h-5 mr-2 text-white" />
                            Hardware Details
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-blue-400">Hardware Type</span>
                                <div
                                    class="p-3 mt-2 font-mono text-blue-800 border border-blue-100 rounded-lg bg-blue-50">
                                    {{ displayText($record->hardware?->hardwareType?->hardware_type) }}
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-blue-400">Serial No.</span>
                                <div
                                    class="p-3 mt-2 font-mono text-blue-800 border border-blue-100 rounded-lg bg-blue-50">
                                    {{ displayText($record->hardware?->serial_number) }}
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-blue-400">Specifications</span>
                                <div
                                    class="p-3 mt-2 font-mono text-blue-800 border border-blue-100 rounded-lg bg-blue-50">
                                    {{ displayText($record->hardware?->specifications) }}
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-blue-400">MAC Address</span>
                                <div
                                    class="p-3 mt-2 font-mono text-blue-800 border border-blue-100 rounded-lg bg-blue-50">
                                    {{ displayText($record->hardware?->mac_address) }}
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-blue-400">PC Name</span>
                                <div
                                    class="p-3 mt-2 font-mono text-blue-800 border border-blue-100 rounded-lg bg-blue-50">
                                    {{ displayText($record->hardware?->pcName->name ?? 'Unassigned') }}
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-blue-400">Accessories</span>
                                <div
                                    class="p-3 mt-2 font-mono text-blue-800 border border-blue-100 rounded-lg bg-blue-50">
                                    {{ displayText($record->hardware?->accessories) }}
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-blue-400">Warranty Expiration Date</span>
                                <div
                                    class="p-3 mt-2 font-mono text-blue-800 border border-blue-100 rounded-lg bg-blue-50">
                                    {{ displayText($record->hardware?->warranty_expiration) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif ($record->asset_type === 'peripherals')
                <div class="overflow-hidden bg-white border border-blue-100 shadow-sm rounded-xl">
                    <div class="px-6 py-4 bg-gradient-to-r from-blue-500 via-blue-400 to-blue-500">
                        <h2 class="flex items-center text-lg font-semibold text-white">
                            <x-heroicon-o-device-tablet class="w-5 h-5 mr-2 text-white" />
                            Peripherals Details
                        </h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-blue-400">Peripheral Type</span>
                                <div
                                    class="p-3 mt-2 font-mono text-blue-800 border border-blue-100 rounded-lg bg-blue-50">
                                    {{ displayText($record->peripherals?->peripheralsType?->peripherals_type) }}
                                </div>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-blue-400">Specifications</span>
                                <div
                                    class="p-3 mt-2 font-mono text-blue-800 border border-blue-100 rounded-lg bg-blue-50">
                                    {{ displayText($record->peripherals?->specifications) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Purchase Details -->
            @php
                $purchase = $record->purchases?->first();
            @endphp
            <div class="overflow-hidden bg-white border border-blue-100 shadow-sm rounded-xl">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 via-blue-400 to-blue-500">
                    <h2 class="flex items-center text-lg font-semibold text-white">
                        <x-heroicon-o-shopping-cart class="w-5 h-5 mr-2 text-white" />
                        Purchase Details
                    </h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="flex flex-col space-y-1">
                            <span class="text-sm font-medium text-blue-400">Purchase Order Number</span>
                            <span
                                class="p-3 mt-2 font-mono text-blue-800 border border-blue-100 rounded-lg bg-blue-50">
                                {{ displayText($purchase?->purchase_order_no, 'No PO#') }}
                            </span>
                        </div>
                        <div class="flex flex-col space-y-1">
                            <span class="text-sm font-medium text-blue-400">Sales Invoice Number</span>
                            <span
                                class="p-3 mt-2 font-mono text-blue-800 border border-blue-100 rounded-lg bg-blue-50">
                                {{ displayText($purchase?->sales_invoice_no, 'No SI#') }}
                            </span>
                        </div>
                    </div>
                    <div class="p-4 mt-6 border border-blue-100 rounded-lg bg-blue-50">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-blue-400">Purchase Date</p>
                                <p class="font-mono text-blue-900">
                                    {{ $purchase?->purchase_order_date
                                        ? \Carbon\Carbon::parse($purchase->purchase_order_date)->format('M d, Y')
                                        : 'Date not set' }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-blue-400">Amount</p>
                                <p class="font-mono text-2xl font-bold text-blue-600">
                                    {{ $purchase?->purchase_order_amount
                                        ? '₱' . number_format($purchase->purchase_order_amount, 2)
                                        : 'Not specified' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Vendor Information -->
            @php
                $vendor = $record->purchases?->first()?->vendor;
            @endphp
            <div class="overflow-hidden bg-white border border-blue-100 shadow-sm rounded-xl">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 via-blue-400 to-blue-500">
                    <h2 class="flex items-center text-lg font-semibold text-white">
                        <x-heroicon-o-building-office class="w-5 h-5 mr-2 text-white" />
                        Vendor Information
                    </h2>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-6 space-x-4">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg">
                            <x-heroicon-o-building-office class="w-6 h-6 text-blue-500" />
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-blue-900">
                                {{ displayText($vendor?->name, 'Vendor Not Available') }}
                            </h3>
                            <p class="text-blue-500">
                                {{ displayText($vendor?->contact_person, 'No Contact Person') }}
                            </p>
                        </div>
                    </div>

                    @if ($vendor)
                        <div class="space-y-4">
                            <div class="p-3 mt-2 font-mono text-blue-800 border border-blue-100 rounded-lg bg-blue-50">
                                <div class="flex items-start space-x-3">
                                    <x-heroicon-o-map-pin class="w-5 h-5 mt-1 text-blue-400" />
                                    <div>
                                        <p class="text-blue-900">{{ displayText($vendor->address_1) }}</p>
                                        {{-- @if ($vendor->address_2 && $vendor->address_2 !== 'N/A')
                                            <p class="text-blue-900">{{ $vendor->address_2 }}</p>
                                        @endif --}}
                                        <p class="text-blue-900">{{ displayText($vendor->city) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="grid grid-cols-1 gap-4 p-3 mt-2 font-mono text-blue-800 border border-blue-100 rounded-lg md:grid-cols-2 bg-blue-50">
                                @if ($vendor->tel_no_1)
                                    <a href="tel:{{ $vendor->tel_no_1 }}"
                                        class="flex items-center p-3 bg-white border border-blue-100 rounded-lg hover:bg-blue-50">
                                        <x-heroicon-o-phone class="w-5 h-5 mr-3 text-blue-400" />
                                        <span class="text-blue-900">{{ $vendor->tel_no_1 }}</span>
                                    </a>
                                @endif

                                @if ($vendor->tel_no_2)
                                    <a href="tel:{{ $vendor->tel_no_2 }}"
                                        class="flex items-center p-3 bg-white border border-blue-100 rounded-lg hover:bg-blue-50">
                                        <x-heroicon-o-phone class="w-5 h-5 mr-3 text-blue-400" />
                                        <span class="text-blue-900">{{ $vendor->tel_no_2 }}</span>
                                    </a>
                                @endif

                                @if ($vendor->mobile_number)
                                    <a href="tel:{{ $vendor->mobile_number }}"
                                        class="flex items-center p-3 bg-white border border-blue-100 rounded-lg hover:bg-blue-50">
                                        <x-heroicon-o-device-phone-mobile
                                            class="w-5 h-5 mr-3 font-mono text-blue-400" />
                                        <span class="text-blue-900">{{ $vendor->mobile_number }}</span>
                                    </a>
                                @endif

                                @if ($vendor->email)
                                    <a href="mailto:{{ $vendor->email }}" target="_blank"
                                        class="flex items-center p-3 bg-white border border-blue-100 rounded-lg hover:bg-blue-50">
                                        <x-heroicon-o-envelope class="w-5 h-5 mr-3 font-mono text-blue-400" />
                                        <span class="text-blue-600">{{ $vendor->email }}</span>
                                    </a>
                                @endif
                            </div>

                            @if ($vendor->url)
                                <a href="{{ Str::startsWith($vendor->url, ['http://', 'https://']) ? $vendor->url : 'https://' . $vendor->url }}"
                                    target="_blank"
                                    class="flex items-center justify-center w-full p-3 transition-colors rounded-lg bg-blue-50 hover:bg-blue-100">
                                    <x-heroicon-o-globe-alt class="w-5 h-5 mr-2 text-blue-400" />
                                    <span class="font-mono text-blue-600">Visit Website</span>
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="p-4 text-center rounded-lg bg-blue-50">
                            <p class="text-blue-600">No vendor information available</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Lifecycle Information -->
            <div class="overflow-hidden bg-white border border-blue-100 shadow-sm rounded-xl">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 via-blue-400 to-blue-500">
                    <h2 class="flex items-center text-lg font-semibold text-white">
                        <x-heroicon-o-clock class="w-5 h-5 mr-2 text-white" />
                        Lifecycle Information
                    </h2>
                </div>
                <div class="p-6">
                    <div class="flex flex-col gap-4 sm:flex-row">
                        <div class="flex-1 p-4 rounded-lg bg-blue-50">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-green-200 rounded-lg">
                                    <x-heroicon-o-calendar class="w-5 h-5 text-blue-500" />
                                </div>
                                <div>
                                    <p class="text-sm text-blue-400">Acquired</p>
                                    <p class="font-mono text-lg font-semibold text-blue-900">
                                        {{ $record->lifecycle?->acquisition_date
                                            ? \Carbon\Carbon::parse($record->lifecycle->acquisition_date)->format('M d, Y')
                                            : 'Not set' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 p-4 rounded-lg bg-blue-50">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-red-100 rounded-lg">
                                    <x-heroicon-o-calendar class="w-5 h-5 text-blue-500" />
                                </div>
                                <div>
                                    <p class="text-sm text-blue-400">Retirement</p>
                                    <p class="font-mono text-lg font-semibold text-blue-900">
                                        {{ $record->lifecycle?->retirement_date
                                            ? \Carbon\Carbon::parse($record->lifecycle->retirement_date)->format('M d, Y')
                                            : 'Not set' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($record->remarks)
        <div class="mt-6">
            <div class="overflow-hidden bg-white border border-blue-100 shadow-sm rounded-xl">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 via-blue-400 to-blue-500">
                    <h2 class="flex items-center text-lg font-semibold text-white">
                        <x-heroicon-o-chat-bubble-left class="w-5 h-5 mr-2 text-white" />
                        Remarks
                    </h2>
                </div>
                <div class="p-6">
                    <div class="p-4 rounded-lg bg-blue-50">
                        <p class="text-blue-800">{{ displayText($record->remarks, 'No remarks available') }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Tabs -->
    <x-filament::tabs>
        <!-- Assignments Tab -->
    <x-filament::tabs.item :active="$activeTab === 'assignments'" wire:click="$set('activeTab', 'assignments')">
            <x-slot name="icon">
                <x-heroicon-o-document class="w-4 h-4" />
            </x-slot>
            Assignments
        </x-filament::tabs.item>

        {{-- @if ($record->asset_type === 'software')
            <!-- Installed On Hardware Tab -->
            <x-filament::tabs.item :active="$activeTab === 'installed on hardware'" wire:click="$set('activeTab', 'installed on hardware')">
                <x-slot name="icon">
                    <x-heroicon-o-cpu-chip class="w-4 h-4" />
                </x-slot>
                Installed On Hardware
            </x-filament::tabs.item>
        @elseif ($record->asset_type === 'hardware')
            <!-- Installed Software Tab -->
            <x-filament::tabs.item :active="$activeTab === 'installed software'" wire:click="$set('activeTab', 'installed software')">
                <x-slot name="icon">
                    <x-heroicon-o-cpu-chip class="w-4 h-4" />
                </x-slot>
                Installed Software
            </x-filament::tabs.item>
        @endif --}}

    </x-filament::tabs>

    <div>
        @if ($activeTab === 'assignments')
            @livewire(App\Filament\Resources\AssetResource\RelationManagers\AssignmentsRelationManager::class, [
                'ownerRecord' => $record,
                'pageClass' => get_class($this),
            ])
        {{-- @elseif ($activeTab === 'installed software' && $record->asset_type === 'hardware')
            @livewire(App\Filament\Resources\AssetResource\RelationManagers\SoftwareRelationmanager::class, [
                'ownerRecord' => $record,
                'pageClass' => get_class($this),
            ])
        @elseif ($activeTab === 'installed on hardware' && $record->asset_type === 'software')
            @livewire(App\Filament\Resources\AssetResource\RelationManagers\HardwareRelationmanager::class, [
                'ownerRecord' => $record,
                'pageClass' => get_class($this),
            ]) --}}
        @endif
    </div>
</x-filament::page>
