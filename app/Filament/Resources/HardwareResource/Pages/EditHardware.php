<?php

namespace App\Filament\Resources\HardwareResource\Pages;

use App\Filament\Resources\HardwareResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;

class EditHardware extends EditRecord
{
    protected static string $resource = HardwareResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['asset_type'] = $this->record->asset->asset_type;
        $data['asset_status'] = $this->record->asset->asset_status;
        $data['brand'] = $this->record->asset->model?->brand?->name ?? null;
        $data['model'] = $this->record->asset->model?->name ?? null;
        $data['cost_code'] = $this->record->asset->costCode?->name ?? null;

        $data['specifications'] = $this->record->specifications;
        $data['serial_number'] = $this->record->serial_number;
        $data['manufacturer'] = $this->record->manufacturer;
        $data['mac_address'] = $this->record->mac_address;
        $data['accessories'] = $this->record->accessories;
        $data['warranty_expiration'] = $this->record->warranty_expiration;

        return $data;
    }

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        $assetData = [
            'asset_status' => $data['asset_status'],
            'brand' => $data['brand'],
            'model' => $data['model'],
        ];

        return DB::transaction(function () use ($record, $data, $assetData) {
            $record->asset->update($assetData);

            $record->update([
                'specifications' => $data['specifications'],
                'serial_number' => $data['serial_number'],
                'manufacturer' => $data['manufacturer'],
                'warranty_expiration' => $data['warranty_expiration'],
            ]);

            return $record;
        });
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('asset_type')
                    ->options([
                        'hardware' => 'Hardware',
                        'software' => 'Software',
                    ])
                    ->required()
                    ->label('Asset Type')
                    ->reactive()
                    ->autofocus()
                    ->disabled(),
                Select::make('asset_status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'under repair' => 'Under Repair',
                        'in transfer' => 'In Transfer',
                        'disposed' => 'Disposed',
                        'lost' => 'Lost',
                        'stolen' => 'Stolen'
                    ])
                    ->required()
                    ->label('Asset Status')
                    ->default('active'),
                TextInput::make('brand')->label('Brand')->required(),
                TextInput::make('model')->label('Model')->required(),
                TextInput::make('asset.cost_code')
                    ->label('Cost Code')
                    ->nullable(),
                Fieldset::make('Hardware Details')
                    ->schema([
                        TextInput::make('specifications')->label('Specifications')->required(),
                        TextInput::make('serial_number')->label('Serial Number')->required(),
                        TextInput::make('manufacturer')->label('Manufacturer')->required(),
                        TextInput::make('mac_address')->label('MAC Address')->nullable(),
                        TextInput::make('accessories')->label('Accessories')->nullable(),
                        DatePicker::make('warranty_expiration')
                            ->label('Warranty Expiration')
                            ->displayFormat('m/d/Y')
                            ->format('Y-m-d'),
                    ]),
            ]);
    }
}
