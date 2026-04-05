<?php

namespace App\Filament\Resources;
use Illuminate\Support\Str;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $slug = '23810310238-categories';

    public static function form(Form $form): Form
{
    return $form->schema([
        TextInput::make('name')
            ->required()
            ->unique(ignoreRecord: true)
            ->live(onBlur: true)
            ->afterStateUpdated(fn ($state, callable $set) => 
                $set('slug', Str::slug($state))
            ),

        TextInput::make('slug')
            ->required(),

        Textarea::make('description'),

        Toggle::make('is_visible')
            ->default(true),
    ]);
}

   public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('name')->searchable(),

            TextColumn::make('slug'),

            IconColumn::make('is_visible')
                ->boolean(),
        ])
        ->filters([
            TernaryFilter::make('is_visible')
                ->label('Hiển thị'),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
