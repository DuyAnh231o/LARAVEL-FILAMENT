<?php

namespace App\Filament\Resources;

use Illuminate\Support\Str;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Grid;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


     protected static ?string $slug = '23810310238-products';
   public static function form(Form $form): Form
{
    return $form->schema([
        Grid::make(2)->schema([
            TextInput::make('name')
    ->required()
    ->live(onBlur: true)
    ->afterStateUpdated(function ($state, callable $set) {
        $set('slug', Str::slug($state));
    }),
TextInput::make('slug')
    ->required()
    ->disabled()
    ->dehydrated(),
    
            TextInput::make('price')
                ->numeric()
                ->minValue(0)
                ->required(),

            TextInput::make('stock_quantity')
                ->numeric()
                ->integer()
                ->required(),
                
            TextInput::make('discount_percent')
                   ->label('Giảm giá (%)')
                 ->numeric()
                  ->minValue(0)
                 ->maxValue(100)
                 ->default(0), 

            Select::make('category_id')
                ->relationship('category', 'name')
                ->required(),
        ]),

        RichEditor::make('description'),

        FileUpload::make('image_path')
            ->image()
            ->directory('products'),
    ]);
    
}

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('name')->searchable(),

            TextColumn::make('price')
                ->money('VND'),

            TextColumn::make('stock_quantity'),

            TextColumn::make('final_price')
                ->label('Giá sau giảm')
                 ->money('VND'),

                 TextColumn::make('discount_percent')
                      ->suffix('%'),

            TextColumn::make('category.name'),
        ])
        ->filters([
            SelectFilter::make('category')
                ->relationship('category', 'name'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
