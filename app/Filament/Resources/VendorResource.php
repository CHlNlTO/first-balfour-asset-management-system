<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VendorResource\Pages;
use App\Filament\Resources\VendorResource\RelationManagers;
use App\Models\Vendor;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VendorResource extends Resource
{
    protected static ?string $model = Vendor::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Manage Transactions';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Vendor Information')
                    ->icon('heroicon-o-shopping-cart')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->inlineLabel()
                            ->required()
                            ->placeholder('Gigahertz Computers')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('url')
                            ->label('Website URL')
                            ->inlineLabel()
                            ->placeholder('www.gigahertzcomputers.com')
                            ->maxLength(255)
                            ->prefix('https://')
                            ->default(null),
                        Forms\Components\TextInput::make('contact_person')
                            ->inlineLabel()
                            ->placeholder('Juan Dela Cruz')
                            ->maxLength(255),

                    ]),
                Section::make('Address Information')
                    ->icon('heroicon-o-map-pin')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('address_1')
                            ->inlineLabel()
                            ->required()
                            ->placeholder('No. 123, Street, City')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('address_2')
                            ->inlineLabel()
                            ->placeholder('Barangay, District')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('city')
                            ->inlineLabel()
                            ->placeholder('Paranaque City')
                            ->maxLength(255),
                    ]),

                Section::make('Contact Information')
                    ->icon('heroicon-o-phone')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->inlineLabel()
                            ->email()
                            ->placeholder('juandelacruz@gmail.com')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('mobile_number')
                            ->inlineLabel()
                            ->placeholder('09123456789')
                            ->numeric(),
                        Forms\Components\TextInput::make('tel_no_1')
                            ->label('Telephone #1')
                            ->inlineLabel()
                            ->tel()
                            ->placeholder('123-4567')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('tel_no_2')
                            ->label('Telephone #2')
                            ->inlineLabel()
                            ->tel()
                            ->placeholder('765-4321')
                            ->maxLength(255)
                            ->default(null),
                    ]),
                Forms\Components\Textarea::make('remarks')
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
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Vendor Name')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('contact_person')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('address_1')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('address_2')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('city')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('tel_no_1')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('tel_no_2')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('mobile_number')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('url')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!')
                    ->tooltip('Click to copy')
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('N/A'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('N/A'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListVendors::route('/'),
            // 'create' => Pages\CreateVendor::route('/create'),
            'edit' => Pages\EditVendor::route('/{record}/edit'),
        ];
    }
}
