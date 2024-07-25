<?php

namespace App\Filament\Resources\AssetResource\Pages;

use App\Filament\Resources\AssetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;
use App\Models\Hardware;
use App\Models\Software;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Illuminate\Support\Facades\Log;

class EditAsset extends EditRecord
{
    protected static string $resource = AssetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
{
    Log::info('Initial Record Data: ', $this->record->toArray());

    $data['asset_type'] = $this->record->asset_type;
    $data['asset_status'] = $this->record->asset_status;
    $data['brand'] = $this->record->brand;
    $data['model'] = $this->record->model;

    Log::info('Mutated Data Before Fill: ', $data);

    if ($this->record->asset_type === 'hardware') {
        $hardware = Hardware::where('asset_id', $this->record->id)->first();
        $data['hardware'] = $hardware ? $hardware->toArray() : [];
        Log::info('Hardware Data: ', $data['hardware']);
    }

    if ($this->record->asset_type === 'software') {
        $software = Software::where('asset_id', $this->record->id)->first();
        $data['software'] = $software ? $software->toArray() : [];
        Log::info('Software Data: ', $data['software']);
    }

    return $data;
}

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        Log::info('Update Data Before Processing: ', $data);

        $assetData = [
            'asset_status' => $data['asset_status'],
            'brand' => $data['brand'],
            'model' => $data['model'],
        ];

        return DB::transaction(function () use ($record, $data, $assetData) {
            $record->update($assetData);

            $assetType = $record->asset_type;  // Use the existing asset_type from the record

            if ($assetType === 'hardware') {
                $record->hardware()->updateOrCreate(
                    ['asset_id' => $record->id],
                    [
                        'specifications' => $data['hardware']['specifications'],
                        'serial_number' => $data['hardware']['serial_number'],
                        'manufacturer' => $data['hardware']['manufacturer'],
                        'warranty_expiration' => $data['hardware']['warranty_expiration'],
                    ]
                );
            }

            if ($assetType === 'software') {
                $record->software()->updateOrCreate(
                    ['asset_id' => $record->id],
                    [
                        'version' => $data['software']['version'],
                        'license_key' => $data['software']['license_key'],
                        'license_type' => $data['software']['license_type'],
                    ]
                );
            }

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
                Fieldset::make('Hardware Details')                    ->hidden(fn (callable $get) => $get('asset_type') !== 'hardware')
                    ->schema([
                        TextInput::make('hardware.specifications')->label('Specifications')->required(),
                        TextInput::make('hardware.serial_number')->label('Serial Number')->required(),
                        TextInput::make('hardware.manufacturer')->label('Manufacturer')->required(),
                        DateTimePicker::make('hardware.warranty_expiration')
                            ->label('Warranty Expiration')
                            ->displayFormat('m/d/Y')
                            ->format('Y-m-d')
                            ->required(),
                    ]),
                Fieldset::make('Software Details')
                    ->hidden(fn (callable $get) => $get('asset_type') !== 'software')
                    ->schema([
                        TextInput::make('software.version')->label('Version')->required(),
                        TextInput::make('software.license_key')->label('License Key')->required(),
                        TextInput::make('software.license_type')->label('License Type')->required(),
                    ]),
            ]);
    }
}
