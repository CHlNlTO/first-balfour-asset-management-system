<?php

namespace App\Filament\Resources\SoftwareResource\Pages;

use App\Filament\Resources\SoftwareResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;
use App\Models\Software;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Fieldset;
use Illuminate\Support\Facades\Log;

class EditSoftware extends EditRecord
{
    protected static string $resource = SoftwareResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        Log::info('Initial Record Data: ', $this->record->toArray());

        $data['asset_status'] = $this->record->asset->asset_status;
        $data['brand'] = $this->record->asset->brand;
        $data['model'] = $this->record->asset->model;
        $data['cost_code'] = $this->record->asset->cost_code;

        $data['version'] = $this->record->version;
        $data['license_key'] = $this->record->license_key;
        $data['license_type'] = $this->record->license_type;
        $data['pc_name'] = $this->record->pc_name;

        Log::info('Mutated Data Before Fill: ', $data);

        return $data;
    }

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        Log::info('Update Data Before Processing: ', $data);

        $assetData = [
            'asset_status' => $data['asset_status'],
            'brand' => $data['brand'],
            'model' => $data['model'],
            'cost_code' => $data['cost_code'],
        ];

        return DB::transaction(function () use ($record, $data, $assetData) {
            $record->asset->update($assetData);

            $record->update([
                'version' => $data['version'],
                'license_key' => $data['license_key'],
                'software_type' => $data['software_type'] ?? null,
                'license_type' => $data['license_type'] ?? null,
                'pc_name' => $data['pc_name'],
            ]);

            return $record;
        });
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
                TextInput::make('cost_code')->label('Department/Project Code'),
                Fieldset::make('Software Details')
                    ->schema([
                        TextInput::make('version')->label('Version'),
                        TextInput::make('license_key')->label('License Key'),
                        TextInput::make('license_type')->label('License Type'),
                        TextInput::make('pc_name')->label('PC Name'),
                    ]),
            ]);
    }
}
