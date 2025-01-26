<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoardingHouseResource\Pages;
use App\Filament\Resources\BoardingHouseResource\RelationManagers;
use App\Models\BoardingHouse;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use illuminate\support\Str;

class BoardingHouseResource extends Resource
{
    protected static ?string $model = BoardingHouse::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make("tabs")
                    ->columnSpan(2)
                    ->tabs([
                        Tab::make("Boarding House")
                            ->schema([
                                FileUpload::make("thumbnail")
                                    ->image()
                                    ->directory("boarding-house")
                                    ->required()
                                    ->columnSpan(2),
                                Select::make("city_id")
                                    ->relationship("city", "name")
                                    ->required()
                                    ->columnSpan(2),
                                TextInput::make("name")
                                    ->required()
                                    ->reactive()
                                    ->debounce()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $set('slug', Str::slug($state));
                                    }),
                                TextInput::make("slug")
                                    ->required(),
                                Textarea::make("description")
                                    ->required()
                                    ->columnSpan(2),
                                Textarea::make("address")
                                    ->required()
                                    ->columnSpan(2),
                                Select::make("rules")
                                    ->columnSpan(2)
                                    ->relationship("rules", "rule")
                                    ->multiple()
                                    ->preload(),
                            ]),
                        Tab::make("Rooms")
                            ->schema([
                                Repeater::make("rooms")
                                    ->relationship("rooms")
                                    ->schema([
                                        Repeater::make("images")
                                            ->columnSpan(2)
                                            ->relationship("roomImages")
                                            ->schema([
                                                FileUpload::make("image")
                                                    ->image()
                                                    ->directory("room-images")
                                                    ->required()
                                            ]),
                                        TextInput::make('name')
                                            ->required(),
                                        TextInput::make('price')
                                            ->numeric()
                                            ->prefix("IDR")
                                            ->required(),
                                        TextInput::make('width')
                                            ->numeric()
                                            ->prefix("Meter")
                                            ->required(),
                                        TextInput::make('length')
                                            ->numeric()
                                            ->prefix("Meter")
                                            ->required(),
                                        Textarea::make('description')
                                            ->columnSpan(2),
                                        Radio::make("is_available")
                                            ->label("availability")
                                            ->options([
                                                true => "available",
                                                false => "not available"
                                            ])
                                            ->default(true),
                                    ])
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make("thumbnail"),
                TextColumn::make("name"),
                TextColumn::make("address"),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListBoardingHouses::route('/'),
            'create' => Pages\CreateBoardingHouse::route('/create'),
            'edit' => Pages\EditBoardingHouse::route('/{record}/edit'),
        ];
    }
}
