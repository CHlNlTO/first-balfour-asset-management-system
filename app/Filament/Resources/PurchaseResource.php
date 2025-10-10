<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseResource\Pages;
use App\Filament\Resources\PurchaseResource\RelationManagers\AssetsRelationManager;
use App\Models\Purchase;
use App\Models\Vendor;
use Carbon\Carbon;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class PurchaseResource extends Resource
{
    protected static ?string $model = Purchase::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Manage Transactions';

    protected static ?int $navigationSort = 1;


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Purchase ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('asset.id')
                    ->label('Asset ID')
                    ->sortable()
                    ->searchable()
                    ->url(fn(Purchase $record): string => route('filament.admin.resources.assets.view', ['record' => $record->asset_id])),
                TextColumn::make('asset.tag_number')
                    ->label('Asset Tag No.')
                    ->sortable()
                    ->searchable()
                    ->url(fn(Purchase $record): string => route('filament.admin.resources.assets.view', ['record' => $record->asset_id])),
                TextColumn::make('asset')
                    ->label('Asset Name')
                    ->getStateUsing(function (Purchase $record): string {
                        $asset = $record->asset;
                        if (!$asset) return 'N/A';
                        $brand = $asset->model?->brand?->name ?? 'Unknown Brand';
                        $model = $asset->model?->name ?? 'Unknown Model';
                        return "{$brand} {$model}";
                    })
                    ->searchable()
                    ->url(fn(Purchase $record): string => route('filament.admin.resources.assets.view', ['record' => $record->asset_id])),
                TextColumn::make('asset.costCode.name')
                    ->label('Department/Project Code')
                    ->sortable()
                    ->searchable()
                    ->placeholder('N/A'),
                TextColumn::make('purchase_order_no')
                    ->label('Purchase Order No.')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('sales_invoice_no')
                    ->label('Sales Invoice No.')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('purchase_order_amount')
                    ->label('Purchase Order Amount')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($state) => 'PHP ' . number_format($state, 2)),
                TextColumn::make('purchase_order_date')
                    ->label('Purchase Order Date')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(fn(Purchase $record): string => Carbon::parse($record->purchase_order_date)->format('Y-m-d')),
                TextColumn::make('vendor.name')
                    ->label('Vendor ID')
                    ->sortable()
                    ->searchable()
                    ->url(fn(Purchase $record): string => route('filament.admin.resources.vendors.edit', ['record' => $record->vendor_id])),
                TextColumn::make('requestor')
                    ->label('Requestor')
                    ->sortable()
                    ->searchable()
                    ->placeholder('N/A'),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable()
                    ->searchable()
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->sortable()
                    ->searchable()
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('cost_code')
                    ->label("Filter by Cost Code")
                    ->searchable()
                    ->indicator('Cost Code')
                    ->relationship('asset.costCode', 'name')
                    ->preload(),
                SelectFilter::make('purchase_order_no')
                    ->label("Filter by Purchase Order No")
                    ->searchable()
                    ->indicator('Receipt No')
                    ->options(Purchase::pluck('purchase_order_no', 'purchase_order_no')->toArray()),
                SelectFilter::make('sales_invoice_no')
                    ->label("Filter by Sales Invoice No")
                    ->searchable()
                    ->indicator('Receipt No')
                    ->options(Purchase::pluck('sales_invoice_no', 'sales_invoice_no')->toArray()),
                SelectFilter::make('purchase_order_date')
                    ->label("Filter by Purchase Order Date")
                    ->searchable()
                    ->indicator('Date')
                    ->options(function () {
                        return Purchase::distinct()
                            ->get(['purchase_order_date'])
                            ->pluck('purchase_order_date')
                            ->map(fn($date) => Carbon::parse($date)->format('Y-m-d'))
                            ->unique()
                            ->sort()
                            ->mapWithKeys(fn($date) => [$date => $date])
                            ->toArray();
                    })
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'],
                            fn(Builder $query, $value): Builder => $query->where('purchase_order_date', $value)
                        );
                    }),
                SelectFilter::make('vendor_id')
                    ->label("Filter by Vendor")
                    ->searchable()
                    ->indicator('Vendor')
                    ->options(Vendor::pluck('name', 'id')->toArray()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('purchases.id', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            AssetsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchases::route('/'),
            // 'create' => Pages\CreatePurchase::route('/create'),
            'view' => Pages\ViewPurchase::route('/{record}'),
            // 'edit' => Pages\EditPurchase::route('/{record}/edit'),
        ];
    }
}
