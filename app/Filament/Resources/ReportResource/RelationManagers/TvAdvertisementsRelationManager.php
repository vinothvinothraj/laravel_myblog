<?php

namespace App\Filament\Resources\ReportResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TvAdvertisementsRelationManager extends RelationManager
{
    protected static string $relationship = 'tvAdvertisements';

    public  function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name_of_tv_channel')
                    ->required(),
                Forms\Components\DateTimePicker::make('date')
                    ->required(),
                Forms\Components\TextInput::make('time')
                    ->required(),
                Forms\Components\TextInput::make('duration_from')
                    ->required(),
                Forms\Components\TextInput::make('duration_to')
                    ->required(),
                Forms\Components\TextInput::make('repetition')
                    ->required(),
                Forms\Components\TextInput::make('repetition_count')
                    ->required(),
                Forms\Components\TextInput::make('cost')
                    ->required(),
                Forms\Components\Textarea::make('other_details'),
                Forms\Components\FileUpload::make('evidence'),
            ]);
    }

    public  function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_of_tv_channel'),
                Tables\Columns\TextColumn::make('date'),
                Tables\Columns\TextColumn::make('time'),
                Tables\Columns\TextColumn::make('duration_from'),
                Tables\Columns\TextColumn::make('duration_to'),
                Tables\Columns\TextColumn::make('repetition'),
                Tables\Columns\TextColumn::make('repetition_count'),
                Tables\Columns\TextColumn::make('cost'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
