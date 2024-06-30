<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Widgets\UsersOverview;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Main Information')
                    ->description(' Main information sector description')
                    ->collapsible()
                    ->schema([
                        TextInput::make("name")
                            ->label("Name")
                            ->required(),
                        TextInput::make("email")
                            ->label("Email")
                            ->email()
                            ->required(),
                        TextInput::make("password")
                            ->label("Password")
                            ->password(),
                    ])->columns(1)->columnSpan(3),
                Section::make('Additional information')
                    ->description('Additional sector description')
                    ->collapsible()
                    ->schema([
                        FileUpload::make("avatar_path")
                            ->disk('public')
                            ->label("Avatar")
                            ->avatar()
                            ->imageEditor()
                            ->circleCropper()
                            ->directory('avatars'),
                        Select::make('user_type')
                            ->options([
                                2 => 'Admin',
                                1 => 'User',
                            ])->label('User Type')
                            ->live()
                            ->afterStateUpdated(function (string $operation, string | null $state, Set $set) {
                                if ($state == 2) {
                                    $set('subscription_id', 3);
                                } else {
                                    $set('subscription_id', 1);
                                }
                            }),
                        Select::make('subscription_id')
                            ->options([
                                1 => 'Free',
                                2 => 'Basic',
                                3 => 'Premium',
                            ])->label('Subscription'),
                    ])->columns(1)->columnSpan(1),
            ])->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar_path')
                    ->label('Avatar')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('getUserType.name')
                    ->label('Role')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(function ($state) {
                        if ($state == "SUPER ADMIN") {
                            return 'success';
                        } else if ($state == "ADMIN") {
                            return 'warning';
                        } else {
                            return 'gray';
                        }
                    }),
                TextColumn::make('getSubscription.name')
                    ->label('Subscription')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(function ($state) {
                        if ($state == "FREE") {
                            return 'gray';
                        } else if ($state == "BASIC") {
                            return 'warning';
                        } else {
                            return 'success';
                        }
                    }),
            ])
            ->filters([
                SelectFilter::make('user_type')
                    ->label('Role')
                    ->options([
                        1 => 'User',
                        2 => 'Admin',
                        3 => 'Super Admin',
                    ])
                    ->multiple(),
                SelectFilter::make('subscription_id')
                    ->label('Subscription')
                    ->options([
                        1 => 'Free',
                        2 => 'Basic',
                        3 => 'Premium',
                    ])
                    ->multiple(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
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

    public static function getWidgets(): array
    {
        return [
            UsersOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
