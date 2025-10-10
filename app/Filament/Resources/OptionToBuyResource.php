<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OptionToBuyResource\Pages;
use App\Filament\Resources\Actions\ApproveSaleAction;
use App\Models\OptionToBuy;
use App\Models\Assignment;
use App\Models\AssignmentStatus;
use App\Models\CEMREmployee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class OptionToBuyResource extends Resource
{
    protected static ?string $model = OptionToBuy::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Option to Buy';

    protected static ?string $navigationGroup = 'Manage Transactions';

    protected static ?string $modelLabel = 'Option to Buy';

    protected static ?string $pluralModelLabel = 'Option to Buy';

    protected static ?string $slug = "option-to-buy";

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('assignment_id')
                    ->label('Assignment ID')
                    ->options(Assignment::all()->mapWithKeys(function ($assignment) {
                        return [$assignment->id => $assignment->id . ' - ' . $assignment->employee->fullName . ' - ' . $assignment->asset->asset];
                    })->toArray())
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('asset_cost')
                    ->required()
                    ->prefix('₱')
                    ->numeric()
                    ->label('Asset Cost'),
                Forms\Components\Select::make('option_to_buy_status')
                    ->label('Status')
                    ->options(AssignmentStatus::all()->pluck('assignment_status', 'id'))
                    ->default('10')
                    ->required()
                    ->searchable(),
                Forms\Components\FileUpload::make('document_path')
                    ->label('Attach Document')
                    ->directory('option-to-buy-documents')
                    ->preserveFilenames()
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'])
                    ->maxSize(10240) // 10MB max size
                    ->disk('public') // Explicitly use public disk
                    ->visibility('public') // Set visibility to public
                    ->hint('Accepted file types: PDF, JPEG, PNG (Max: 10MB)')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('assignment.id')
                    ->label('Assignment ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('employee')
                    ->label('Employee')
                    ->sortable()
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        $employeeIds = DB::connection('central_employeedb')
                            ->table('employees')
                            ->whereRaw(
                                "CONCAT(first_name, ' ', last_name) LIKE ?",
                                ["%{$search}%"]
                            )
                            ->pluck('id_num');
                        return $query->whereHas('assignment', function (Builder $query) use ($employeeIds) {
                            $query->whereIn('employee_id', $employeeIds);
                        });
                    })
                    ->getStateUsing(function (OptionToBuy $record): string {
                        $employee = $record->assignment->employee->first_name . ' ' . $record->assignment->employee->last_name;
                        return $employee ? $employee : 'N/A';
                    })
                    ->url(fn(OptionToBuy $record): string => route('filament.admin.resources.employees.view', ['record' => $record->assignment->employee->id_num])),
                Tables\Columns\TextColumn::make('asset')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('assignment', function (Builder $query) use ($search) {
                            $query->whereHas('asset', function (Builder $query) use ($search) {
                                $query->whereHas('model', function (Builder $query) use ($search) {
                                    $query->whereHas('brand', function (Builder $query) use ($search) {
                                        $query->whereRaw(
                                            "CONCAT(brands.name, ' ', models.name) LIKE ?",
                                            ["%{$search}%"]
                                        );
                                    });
                                });
                            });
                        });
                    })
                    ->getStateUsing(function (OptionToBuy $record): string {
                        $asset = $record->assignment->asset ?? null;
                        if (!$asset) return 'N/A';
                        $brand = $asset->model?->brand?->name ?? 'Unknown Brand';
                        // For software, only show brand
                        if ($asset->asset_type === 'software') {
                            return $brand;
                        }
                        // For hardware/peripherals, show brand + model
                        $model = $asset->model?->name ?? 'Unknown Model';
                        return "{$brand} {$model}";
                    })
                    ->url(fn(OptionToBuy $record): string => route('filament.admin.resources.assets.view', ['record' => $record->assignment->asset_id])),
                Tables\Columns\TextColumn::make('asset_cost')
                    ->money('php')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status.assignment_status')
                    ->label('Assignment Status')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn($record) => $record->status?->color?->getColor())
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('document_path')
                    ->label('Document')
                    ->formatStateUsing(fn($state) => $state ? 'Attached' : 'None')
                    ->badge()
                    ->color(fn($state) => $state ? 'success' : 'danger')
                    ->url(fn($record) => $record->document_path ? $record->document_url : null, shouldOpenInNewTab: true)
                    ->tooltip(fn($record) => $record->document_path ? 'Click to view document' : 'No document attached'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('employee_id')
                    ->label("Filter by Employee")
                    ->searchable()
                    ->indicator('Employee')
                    ->options(function (string $search = null) {
                        $query = CEMREmployee::on('central_employeedb');

                        if ($search) {
                            $query->where(function ($query) use ($search) {
                                $query->where('first_name', 'like', "%{$search}%")
                                    ->orWhere('last_name', 'like', "%{$search}%");
                            });
                        }

                        return $query->get()
                            ->mapWithKeys(function ($employee) {
                                $fullName = trim("{$employee->first_name} {$employee->last_name}");
                                return [$employee->id_num => $fullName];
                            })
                            ->toArray();
                    })
                    ->query(function (Builder $query, $data) {
                        if (!empty($data['value'])) {
                            $query->whereHas('assignment', function (Builder $query) use ($data) {
                                $query->where('employee_id', $data['value']);
                            });
                        }
                    })
                    ->preload(),
                // Filter for documents
                Tables\Filters\Filter::make('has_document')
                    ->label('Has Document')
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('document_path'))
                    ->toggle(),
                // Filter for status
                SelectFilter::make('option_to_buy_status')
                    ->label('Status')
                    ->options(AssignmentStatus::all()->pluck('assignment_status', 'id'))
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\Action::make('download_document')
                    ->label('Download Document')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn(OptionToBuy $record): ?string => $record->document_path ? $record->document_url : null)
                    ->openUrlInNewTab()
                    ->visible(fn(OptionToBuy $record): bool => $record->document_path !== null),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                ApproveSaleAction::makeForOptionToBuy(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOptionToBuys::route('/'),
            'create' => Pages\CreateOptionToBuy::route('/create'),
            'view' => Pages\ViewOptionToBuy::route('/{record}'),
            'edit' => Pages\EditOptionToBuy::route('/{record}/edit'),
        ];
    }
}
