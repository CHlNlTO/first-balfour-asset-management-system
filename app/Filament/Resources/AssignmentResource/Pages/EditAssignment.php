<?php

namespace App\Filament\Resources\AssignmentResource\Pages;

use App\Filament\Resources\AssignmentResource;
use App\Helpers\StatusSynchronizationHelper;
use Filament\Actions;
use App\Models\Asset;
use App\Models\AssignmentStatus;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;

class EditAssignment extends EditRecord
{
    protected static string $resource = AssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        Log::info("Data received in mutateFormDataBeforeFill:", $data);
        return $data;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Asset Assignment Details')
                            ->description('Manage asset assignments to employees')
                            ->compact()
                            ->schema([
                                Forms\Components\Select::make('asset_id')
                                    ->label('Assets')
                                    ->placeholder('Select from existing assets')
                                    ->relationship('asset', 'id')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->getOptionLabelFromRecordUsing(function(Asset $record) {
                                        $label = $record->id;
                                        if ($record->model?->brand?->name || $record->model?->name) {
                                            $brand = $record->model->brand->name ?? 'Unknown Brand';
                                            // For software, only show brand
                                            if ($record->asset_type === 'software') {
                                                $label .= ' - ' . $brand;
                                            } else {
                                                // For hardware/peripherals, show brand + model
                                                $model = $record->model->name ?? 'Unknown Model';
                                                $label .= ' - ' . $brand . ' ' . $model;
                                            }
                                        }
                                        return $label;
                                    }),
                                Forms\Components\Select::make('employee_id')
                                    ->label('Employee')
                                    ->placeholder('Select from registered employees')
                                    ->relationship('employee', 'id_num')
                                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->id_num} {$record->first_name} {$record->last_name}")
                                    ->searchable()
                                    ->required(),
                                Forms\Components\Select::make('assignment_status')
                                    ->label('Assignment Status')
                                    ->options(AssignmentStatus::all()->pluck('assignment_status', 'id')->toArray())
                                    ->default('1')
                                    ->required()
                                    ->columnSpan(1),
                            ])->columns(2)
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make()
                    ->schema([
                        Section::make('Assignment Period')
                            ->description('Specify the duration of the asset assignment')
                            ->compact()
                            ->schema([
                                Grid::make(1)
                                    ->schema([
                                        Forms\Components\DatePicker::make('start_date')
                                            ->label('Receive Date')
                                            ->native()
                                            ->closeOnDateSelection()
                                            ->required(),
                                        Forms\Components\DatePicker::make('end_date')
                                            ->label('Return Date')
                                            ->native()
                                            ->closeOnDateSelection(),
                                    ]),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns([
                'lg' => 3
            ])
            ->inlineLabel();
    }

    protected function afterSave(): void
    {
        // Sync Asset Status with Assignment Status if this is the most recent assignment
        StatusSynchronizationHelper::syncAssetStatusFromAssignment($this->record);
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
