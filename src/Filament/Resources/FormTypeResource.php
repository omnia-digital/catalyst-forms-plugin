<?php

namespace OmniaDigital\CatalystForms\Filament\Resources;

use Closure;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use OmniaDigital\CatalystForms\Filament\Resources\FormTypeResource\Pages\CreateFormType;
use OmniaDigital\CatalystForms\Filament\Resources\FormTypeResource\Pages\EditFormType;
use OmniaDigital\CatalystForms\Filament\Resources\FormTypeResource\Pages\ListFormsType;
use OmniaDigital\CatalystForms\Filament\Resources\FormTypeResource\Pages\ViewFormType;
use OmniaDigital\CatalystForms\Models\FormType;

class FormTypeResource extends Resource
{
    protected static ?string $label = 'Form Types';

    protected static ?string $model = FormType::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Forms';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->lazy()
                    ->afterStateUpdated(function (Set $set, $state) {
                        $set('slug', Str::slug($state));
                    })
                    ->required(),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required(),
                Select::make('for')
                    ->label('Choose who can use this form type')
                    ->required()
                    ->options([
                        'teams' => 'Teams',
                        'admin' => 'Admin',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('slug'),
                TextColumn::make('for'),
            ])
            ->filters([
                Filter::make('name'),
            ])
            ->actions([
                ViewAction::make(),
                ActionGroup::make([
                    EditAction::make(),
                    ReplicateAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFormsType::route('/'),
            'create' => CreateFormType::route('/create'),
            'view' => ViewFormType::route('/{record}'),
            'edit' => EditFormType::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->get()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getEloquentQuery()->get()->count() > 10 ? 'warning' : 'primary';
    }

    protected function getTableRecordUrlUsing(): Closure
    {
        return fn (Model $record): string => route('form_types.edit', ['record' => $record]);
    }
}
