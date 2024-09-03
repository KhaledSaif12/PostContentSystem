<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaFileResource\Pages;
use App\Filament\Resources\MediaFileResource\RelationManagers;
use App\Models\MediaFile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MediaFileResource extends Resource
{
    protected static ?string $model = MediaFile::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('post_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('file_path')
                    ->fetchFileInformation(false) // Disables automatic file info fetching
                    ->label('Attachment')
                    ->required()
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png']) // Define allowed file types
                    ->maxSize(10240) // Max size in KB (10MB in this case)
                    ->disk('public') // Define storage disk
                    ->directory('uploads'),
                Forms\Components\TextInput::make('file_type')
                    ->required()
                    ->uploadingMessage('Uploading attachment...'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('post_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('file_path')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_type'),
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
            'index' => Pages\ListMediaFiles::route('/'),
            'create' => Pages\CreateMediaFile::route('/create'),
            'view' => Pages\ViewMediaFile::route('/{record}'),
            'edit' => Pages\EditMediaFile::route('/{record}/edit'),
        ];
    }
}
