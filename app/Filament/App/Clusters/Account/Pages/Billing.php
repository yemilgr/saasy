<?php

namespace App\Filament\App\Clusters\Account\Pages;

use App\Filament\App\Clusters\Account\AccountCluster;
use App\Models\Subscription;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Livewire\Attributes\Computed;

class Billing extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCreditCard;
    protected static ?string $cluster = AccountCluster::class;
    protected static ?int $navigationSort = 10;
    public ?Subscription $current = null;
    protected string $view = 'filament.app.clusters.account.pages.billing';

    public static function getNavigationLabel(): string
    {
        return __('Billing');
    }

    public function getTitle(): string|Htmlable
    {
        return __('Billing');
    }

    public function mount(): void
    {
        $this->current = auth()->user()->subscriptions()->active()->latest()->first();
    }

    #[Computed]
    public function upcomingInvoice()
    {
        return auth()->user()->upcomingInvoice()->toArray();
    }

    public function billingPortal(): void
    {
        $this->redirect(auth()->user()->billingPortalUrl(route('filament.app.pages.dashboard'), []));
    }

    public function checkoutPage(): void
    {
        $this->redirectRoute('filament.app.pages.checkout');
    }

    public function table(Table $table): Table
    {
        return $table
            ->records(fn (): array => auth()->user()->invoices()->toArray())
            ->heading(__('Invoices'))
            ->description(__('Your invoice history'))
            ->columns([
                TextColumn::make('number')
                    ->label(__('Number')),
                TextColumn::make('created')
                    ->label(__('Date'))
                    ->dateTime('M d, Y'),
                TextColumn::make('total')
                    ->money(config('cashier.currency'), divideBy: 100),
                IconColumn::make('paid')
                    ->label(__('Paid'))
                    ->boolean(),
            ])
            ->paginated()
            ->filters([
                // ...
            ])
            ->recordActions([
                Action::make('download')
                    ->url(fn (array $record): string => $record['hosted_invoice_url'])
                    ->openUrlInNewTab()
                    ->icon(Heroicon::OutlinedArrowDown),
            ])
            ->toolbarActions([
                // ...
            ]);
    }
}
