<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\Package;
use App\Models\TicketVersion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationGroup = 'Manajemen Tiket';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
{
    return $form->schema([

        /* ================= form untuk create pesenan di admin ================= */
        Forms\Components\Section::make('Data Pemesan')
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(fn () => Auth::id()),

                Forms\Components\TextInput::make('name')
                    ->label('Nama Pemesan')
                    ->placeholder('Nama lengkap')
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->default(fn () => Auth::user()->email)
                    ->disabled()
                    ->dehydrated(),

                Forms\Components\TextInput::make('phone')
                    ->label('No Telepon / WhatsApp')
                    ->placeholder('08xxxxxxxxxx')
                    ->required(),

                Forms\Components\DatePicker::make('visit_date')
                    ->label('Tanggal Kunjungan')
                    ->required()
                    ->minDate(now()),
            ])
            ->columns(2),

        /* ================= milih paket ================= */
        Forms\Components\Section::make('Paket Wisata')
            ->schema([
                Forms\Components\Select::make('package_id')
                    ->label('Pilih Paket')
                    ->options(
                        Package::where('is_active', true)->pluck('name', 'id')
                    )
                    ->searchable()
                    ->reactive()
                    ->required()
                    ->helperText('Pilih satu paket, lalu tambahkan jenis tiket di bawah'),
            ]),

        /* ================= after milih paket kan milih tiket ================= */
        Forms\Components\Section::make('Detail Tiket')
            ->description('Tambahkan jenis tiket sesuai kebutuhan')
            ->schema([

                Forms\Components\Repeater::make('items')
                    ->relationship()
                    ->label('')
                    ->collapsible()
                    ->defaultItems(0)
                    ->schema([

                       Forms\Components\Select::make('ticket_version_id')
                            ->label('Jenis Tiket')
                            ->options(fn (Get $get) =>
                                $get('../../package_id')
                                    ? TicketVersion::where('package_id', $get('../../package_id'))
                                        ->with('category')
                                        ->get()
                                        ->mapWithKeys(fn ($v) => [
                                            $v->id => "{$v->category->name} - {$v->name} (Rp " . number_format($v->price, 0, ',', '.') . ")",
                                        ])
                                    : []
                            )
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Set $set, Get $get) {

                                $version = TicketVersion::find($get('ticket_version_id'));
                                $qty = (int) ($get('quantity') ?? 1);

                                if ($version) {
                                    $subtotal = $version->price * $qty;
                                    $set('price', $version->price);
                                    $set('subtotal', $subtotal);
                                }

                                $items = collect($get('../../items') ?? []);
                                $total = $items->sum(fn ($item) => $item['subtotal'] ?? 0);

                                $set('../../total_price', $total);
                            }),


                        Forms\Components\TextInput::make('quantity')
                            ->label('Jumlah')
                            ->numeric()
                            ->minValue(1)
                            ->default(1)
                            ->live()
                            ->required()
                            ->afterStateUpdated(function (Set $set, Get $get) {

                                $version = TicketVersion::find($get('ticket_version_id'));
                                $qty = (int) $get('quantity');

                                if ($version && $qty) {
                                    $subtotal = $version->price * $qty;
                                    $set('price', $version->price);
                                    $set('subtotal', $subtotal);
                                }

                                /* ===== itung ===== */
                                $items = collect($get('../../items') ?? []);
                                $total = $items->sum(fn ($item) => $item['subtotal'] ?? 0);

                                $set('../../total_price', $total);
                            }),
                        Forms\Components\TextInput::make('price')
                            ->label('Harga')
                            ->prefix('Rp')
                            ->disabled()
                            ->numeric()
                            ->dehydrated(),

                        Forms\Components\TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->prefix('Rp')
                            ->disabled()
                            ->numeric()
                            ->dehydrated(),
                    ])
                    ->columns(4)
                    ->createItemButtonLabel('+ Tambah Jenis Tiket')
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        $total = collect($get('items'))
                            ->sum(fn ($item) => $item['subtotal'] ?? 0);

                        $set('total_price', $total);
                    }),
            ]),

        /* ================= pembayaran ================= */
        Forms\Components\Section::make('Pembayaran')
            ->schema([
                Forms\Components\TextInput::make('total_price')
                    ->label('Total Pembayaran')
                    ->disabled()
                    ->dehydrated()
                    ->formatStateUsing(fn ($state) =>
                        $state ? 'Rp ' . number_format($state, 0, ',', '.') : 'Rp 0'
                    ),
                Forms\Components\Select::make('payment_gateway')
                    ->label('Metode Pembayaran')
                    ->options(['midtrans' => 'Midtrans'])
                    ->default('midtrans')
                    ->required(),

                Forms\Components\Select::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                    ])
                    ->default('pending')
                    ->disabled(), 
            ])
            ->columns(2),
    ]);

}


    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('order_code')->label('Kode Order')->searchable(),
            Tables\Columns\TextColumn::make('ticket_code')->label('Kode Tiket')->searchable(),
            Tables\Columns\TextColumn::make('name')->label('Pemesan'),
            Tables\Columns\TextColumn::make('visit_date')->date(),
            Tables\Columns\TextColumn::make('total_price')->money('IDR'),
            Tables\Columns\BadgeColumn::make('payment_status')
                ->colors([
                    'warning' => 'pending',
                    'success' => 'paid',
                    'danger' => 'failed',
                ]),
            Tables\Columns\TextColumn::make('created_at')->dateTime(),
            Tables\Columns\TextColumn::make('items')
                ->label('Detail Tiket')
                ->formatStateUsing(fn ($record) =>
                    $record->items->map(fn ($item) =>
                        "{$item->ticketVersion->category->name} {$item->ticketVersion->name} x{$item->quantity}"
                    )->implode(', ')
            ),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\Action::make('bayar')
            ->label('Bayar')
            ->url(fn (Order $record) =>
                "https://app.sandbox.midtrans.com/snap/v2/vtweb/{$record->payment_reference}"
            )
            ->openUrlInNewTab()
            ->visible(fn ($record) => $record->payment_status === 'pending'),

        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
