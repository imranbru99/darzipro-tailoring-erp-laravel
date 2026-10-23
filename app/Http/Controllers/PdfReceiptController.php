<?php

namespace App\Http\Controllers;

use App\Models\TailoringOrder;
use App\Services\PdfReceiptService;
use Illuminate\Http\Request;

class PdfReceiptController extends Controller
{
    public function thermalReceipt(TailoringOrder $order)
    {
        $pdf = PdfReceiptService::generateThermalReceipt($order);
        return $pdf->stream("receipt-{$order->order_number}.pdf");
    }

    public function workshopToken(TailoringOrder $order)
    {
        $pdf = PdfReceiptService::generateWorkshopSlip($order);
        return $pdf->stream("workshop-token-{$order->order_number}.pdf");
    }
}
