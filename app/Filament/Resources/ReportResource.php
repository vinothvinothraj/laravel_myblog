<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ReportResource\RelationManagers\MainStreamRelationManager;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('district')
                    ->required(),
                Forms\Components\TextInput::make('electorate')
                    ->required(),
                Forms\Components\TextInput::make('candidate')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->required(),
                Forms\Components\Select::make('report_category')
                    ->options([
                        'mainstream' => 'Mainstream',
                        'social_media' => 'Social Media',
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) => $set('type', null)),
                Forms\Components\Select::make('type')
                    ->options(fn (callable $get) => $get('report_category') === 'mainstream' ? [
                        'tv' => 'TV',
                        'radio' => 'Radio',
                        'print' => 'Print',
                    ] : [
                        'facebook' => 'Facebook',
                        'twitter' => 'Twitter',
                        'instagram' => 'Instagram',
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) => $set('showTvFields', $state === 'tv')),
                Forms\Components\Hidden::make('showTvFields')
                    ->default(false)
                    ->reactive(),
                Forms\Components\Placeholder::make('TvFieldsPlaceholder')
                    ->content('TV Fields will be shown here')
                    ->visible(fn (callable $get) => $get('showTvFields'))
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('district'),
                Tables\Columns\TextColumn::make('electorate'),
                Tables\Columns\TextColumn::make('candidate'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('report_category'),
                Tables\Columns\TextColumn::make('type'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            MainStreamRelationManager::class,
        ];
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
