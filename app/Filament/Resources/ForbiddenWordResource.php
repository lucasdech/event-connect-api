<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ForbiddenWordResource\Pages;
use App\Filament\Resources\ForbiddenWordResource\RelationManagers;
use App\Models\ForbiddenWord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ForbiddenWordResource extends Resource
{
    protected static ?string $model = ForbiddenWord::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('word')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('word')->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListForbiddenWords::route('/'),
            'create' => Pages\CreateForbiddenWord::route('/create'),
            'view' => Pages\ViewForbiddenWord::route('/{record}'),
            'edit' => Pages\EditForbiddenWord::route('/{record}/edit'),
        ];
    }
}
