<?php

namespace App\Filament\Resources\PurchaseResource\Pages;

use App\Filament\Resources\PurchaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;
use App\Models\Asset;
use App\Models\Hardware;
use App\Models\Software;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;

class EditPurchase extends EditRecord
{
    protected static string $resource = PurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('General Purchase Information')
                    ->schema([
                        TextInput::make('receipt_no')
                            ->required()
                            ->numeric(),
                        DatePicker::make('purchase_date')
                            ->required(),
                        Select::make('vendor_id')
                            ->label('Vendor')
                            ->relationship('vendor', 'name')
                            ->preload()
                            ->required()
                            ->searchable(),
                        TextInput::make('purchase_cost')
                            ->label('Asset Cost')
                            ->required(),
                    ]),
                Fieldset::make('Asset Details')
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
                    ]),
                Fieldset::make('Hardware Details')
                    ->hidden(fn (callable $get) => $get('asset_type') !== 'hardware')
                    ->schema([
                        TextInput::make('specifications')->label('Specifications')->required(),
                        TextInput::make('serial_number')->label('Serial Number')->required(),
                        TextInput::make('manufacturer')->label('Manufacturer')->required(),
                        DatePicker::make('warranty_expiration')
                            ->label('Warranty Expiration')
                            ->displayFormat('m/d/Y')
                            ->format('Y-m-d')
                            ->seconds(false),
                    ]),
                Fieldset::make('Software Details')
                    ->hidden(fn (callable $get) => $get('asset_type') !== 'software')
                    ->schema([
                        TextInput::make('version')->label('Version')->required(),
                        TextInput::make('license_key')->label('License Key')->required(),
                        TextInput::make('license_type')->label('License Type')->required(),
                    ]),
            ]);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        Log::info('Initial Record Data: ', $this->record->toArray());

        $asset = $this->record->asset;
        $data['asset_type'] = $asset->asset_type;
        $data['asset_status'] = $asset->asset_status;
        $data['brand'] = $asset->brand;
        $data['model'] = $asset->model;

        if ($asset->asset_type === 'hardware') {
            $hardware = $asset->hardware;
            if ($hardware) {
                $data['specifications'] = $hardware->specifications;
                $data['serial_number'] = $hardware->serial_number;
                $data['manufacturer'] = $hardware->manufacturer;
                $data['warranty_expiration'] = $hardware->warranty_expiration;
            }
        } elseif ($asset->asset_type === 'software') {
            $software = $asset->software;
            if ($software) {
                $data['version'] = $software->version;
                $data['license_key'] = $software->license_key;
                $data['license_type'] = $software->license_type;
            }
        }

        Log::info('Mutated Data Before Fill: ', $data);

        return $data;
    }

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        Log::info('Update Data Before Processing: ', $data);

        return DB::transaction(function () use ($record, $data) {
            $record->update([
                'receipt_no' => $data['receipt_no'],
                'purchase_date' => $data['purchase_date'],
                'vendor_id' => $data['vendor_id'],
                'purchase_cost' => $data['purchase_cost'],
            ]);

            $asset = $record->asset;
            $asset->update([
                'asset_status' => $data['asset_status'],
                'brand' => $data['brand'],
                'model' => $data['model'],
            ]);

            if ($asset->asset_type === 'hardware') {
                $asset->hardware()->updateOrCreate(
                    ['asset_id' => $asset->id],
                    [
                        'specifications' => $data['specifications'],
                        'serial_number' => $data['serial_number'],
                        'manufacturer' => $data['manufacturer'],
                        'warranty_expiration' => $data['warranty_expiration'],
                    ]
                );
            }

            if ($asset->asset_type === 'software') {
                $asset->software()->updateOrCreate(
                    ['asset_id' => $asset->id],
                    [
                        'version' => $data['version'],
                        'license_key' => $data['license_key'],
                        'license_type' => $data['license_type'],
                    ]
                );
            }

            return $record;
        });
    }
}
