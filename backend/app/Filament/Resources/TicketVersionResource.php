<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketVersionResource\Pages;
use App\Filament\Resources\TicketVersionResource\RelationManagers;
use App\Models\TicketVersion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketVersionResource extends Resource
{
    
    protected static ?string $model = \App\Models\TicketVersion::class;
    protected static ?string $navigationGroup = 'Manajemen Tiket';
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    public static function form(Form $form): Form
    {  
        return $form->schema([

        Forms\Components\Select::make('package_id')
            ->label('Package')
            ->relationship('package', 'name')
            ->searchable()
            ->required(),

        Forms\Components\Select::make('ticket_category_id')
            ->label('Category')
            ->relationship('category', 'name')
            ->searchable()
            ->required(),

        Forms\Components\Select::make('name')
            ->options([
                'Dewasa' => 'Dewasa',
                'Anak' => 'Anak',
            ])
            ->required(),
        Forms\Components\TextInput::make('price')
            ->label('Harga')
            ->numeric()
            ->prefix('Rp')
            ->required(),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('package.name')
                ->label('Package')
                ->searchable(),

            Tables\Columns\TextColumn::make('category.name')
                ->label('Category')
                ->searchable(),

            Tables\Columns\TextColumn::make('name')
                ->label('Versi'),

            Tables\Columns\TextColumn::make('price')
                ->label('Harga')
                ->money('IDR'),

            Tables\Columns\TextColumn::make('created_at')
                ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListTicketVersions::route('/'),
            'create' => Pages\CreateTicketVersion::route('/create'),
            'edit' => Pages\EditTicketVersion::route('/{record}/edit'),
        ];
    }
}
