<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\RelationManagers\SuppliersRelationManager;
use App\Models\Product;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'System Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name'),
                        TextInput::make('description'),
                        TextInput::make('sku'),
                        Select::make('suppliers_id')->relationship('supplier', 'name'),
                        TextInput::make('purchase_price'),
                        TextInput::make('sale_price'),
                        TextInput::make('quantity_on_hand'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Products'),
                TextColumn::make('description')
                    ->label('Product Description')
                    ->wrap(),
                TextColumn::make('sku')
                    ->label('SKU'),
                TextColumn::make('supplier.name')
                    ->label('Supplier Name'),
                TextColumn::make('purchase_price')
                    ->label('Purchase Price'),
                TextColumn::make('sale_price')
                    ->label('Sale Price'),
                TextColumn::make('quantity_on_hand')
                    ->label('Quantity On Hand'),
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
            SuppliersRelationManager::class
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
