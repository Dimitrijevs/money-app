<?php

namespace App\Filament\Resources\TransactionTagResource\Pages;

use App\Filament\Resources\TransactionTagResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransactionTags extends ListRecords
{
    protected static string $resource = TransactionTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
