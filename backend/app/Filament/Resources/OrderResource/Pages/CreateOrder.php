<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Mail\OrderTicketMail;
use Illuminate\Support\Facades\Mail;
use App\Services\MidtransService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\GdImageBackEnd;
class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
    
    protected function getRedirectUrl(): string
    {
        return static::$resource::getUrl('index');
    }
    protected function afterCreate(): void
{
    $order = $this->record->load('items.ticketVersion.category');

    // ================= QR CODE (PNG FILE) =================
    // $qrPath = 'qrcodes/' . $order->ticket_code . '.png';

    // $qrImage = QrCode::format('png')
    //     ->size(300)
    //     ->margin(2)
    //     ->generate($order->ticket_code);

    // Storage::disk('public')->put($qrPath, $qrImage);

    // $order->update([
    //     'qr_code_path' => $qrPath,
    // ]);



    // ================= EMAIL =================
    Mail::to($order->email)->send(new OrderTicketMail($order));

    // ================= MIDTRANS =================
    $snap = \App\Services\MidtransService::createSnap($order);

    $order->update([
        'payment_reference' => $snap->token,
    ]);

    $this->redirect($snap->redirect_url);
}


}
