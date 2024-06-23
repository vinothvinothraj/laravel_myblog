<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TvAdvertsResource\Pages;
use App\Filament\Resources\TvAdvertsResource\RelationManagers;
use App\Models\TvAdverts;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components\TextEntry;

class TvAdvertsResource extends Resource
{
    protected static ?string $model = TvAdverts::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('mainstream_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('name_of_tv_channel')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\TextInput::make('time')
                    ->required(),
                Forms\Components\TextInput::make('duration_from')
                    ->required(),
                Forms\Components\TextInput::make('duration_to')
                    ->required(),
                Forms\Components\Toggle::make('repetition')
                    ->required(),
                Forms\Components\TextInput::make('repetition_count')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('cost')
                    ->numeric()
                    ->default(null)
                    ->prefix('$'),
                Forms\Components\Textarea::make('other_details')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('evidence')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mainstream_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name_of_tv_channel')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('time'),
                Tables\Columns\TextColumn::make('duration_from'),
                Tables\Columns\TextColumn::make('duration_to'),
                Tables\Columns\IconColumn::make('repetition')
                    ->boolean(),
                Tables\Columns\TextColumn::make('repetition_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cost')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('evidence')
                    ->searchable(),
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
            'index' => Pages\ListTvAdverts::route('/'),
            'create' => Pages\CreateTvAdverts::route('/create'),
            'edit' => Pages\EditTvAdverts::route('/{record}/edit'),
        ];
    }
}
