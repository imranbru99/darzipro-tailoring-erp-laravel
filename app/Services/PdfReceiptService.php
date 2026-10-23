<?php

namespace App\Services;

use App\Models\TailoringOrder;
use ImranDev\UnicodePdf\Facades\UnicodePdf;

class PdfReceiptService
{
    /**
     * Generate thermal POS receipt stream / download.
     */
    public static function generateThermalReceipt(TailoringOrder $order)
    {
        $order->load(['customer', 'branch', 'items.fabricProduct']);

        return UnicodePdf::view('pdf.thermal-receipt', ['order' => $order])
            ->preset('bengali')
            ->setPaper([0, 0, 215, 600]) // 76mm thermal paper
            ->margin(4, 4, 4, 4);
    }

    /**
     * Generate A4 / A5 workshop cutting slip.
     */
    public static function generateWorkshopSlip(TailoringOrder $order)
    {
        $order->load(['customer', 'branch', 'items.fabricProduct']);

        return UnicodePdf::view('pdf.workshop-token', ['order' => $order])
            ->preset('bengali')
            ->paper('a4', 'portrait')
            ->margin(10, 10, 10, 10);
    }
}
