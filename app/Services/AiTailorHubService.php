<?php

namespace App\Services;

use ImranDevBd\AiHub\Facades\AIHub;
use Throwable;

class AiTailorHubService
{
    /**
     * Provide AI styling suggestions based on customer measurements and occasion.
     */
    public static function getStyleRecommendation(string $garmentType, array $measurements, string $occasion = 'regular'): array
    {
        $prompt = "You are a professional Bangladeshi Master Tailor and Fashion Consultant. 
        Analyze the garment type '{$garmentType}' with measurements: " . json_encode($measurements) . " for occasion '{$occasion}'.
        Provide recommended Collar type, Placket/Button style, Cut (Round or Straight), Pocket style, and matching fabric advice in Bengali.";

        try {
            // Attempt to call AI Hub if configured
            $response = AIHub::prompt($prompt)->generate();
            $text = $response->text();
        } catch (Throwable $e) {
            // High quality fallback tailoring domain intelligence
            $text = self::getRuleBasedRecommendation($garmentType, $measurements, $occasion);
        }

        return [
            'garment_type' => $garmentType,
            'recommendation' => $text,
            'estimated_yards' => TailoringDomainService::estimateFabricYards(
                $garmentType,
                $measurements['length'] ?? 40,
                $measurements['chest'] ?? 38
            ),
        ];
    }

    /**
     * Rule-based Bangladeshi tailoring intelligence fallback.
     */
    protected static function getRuleBasedRecommendation(string $garmentType, array $measurements, string $occasion): string
    {
        $chest = (float)($measurements['chest'] ?? 38);
        $length = (float)($measurements['length'] ?? 40);

        if ($garmentType === 'panjabi') {
            $collar = $chest > 40 ? '১.২৫ ইঞ্চি ব্যান্দ / কুর্তা কলার' : '১.৫ ইঞ্চি ব্যান কলার';
            $cut = $length > 41 ? 'সোজা কাট (Straight Cut) সাথে ডিপ পকেট' : 'সেমি-রাউন্ড কাট';
            return "👔 পাঞ্জাবি স্টাইল পরামর্শ:
• কলার: {$collar} (গলায় আরামদায়ক ফিট হবে)।
• বোতাম পট্টি: লুকানো পট্টি (Hidden Placket) সাথে সূক্ষ্ম হ্যান্ড স্টিচ।
• কাট: {$cut}।
• হাতা: ক্লাসিক ওপেন মুহুরি (১০.৫ ইঞ্চি)।
• কাপড়ের পছন্দ: ১০০% গিজা কটন বা লাক্সারি জ্যাকার্ড ফেব্রিক।";
        }

        if ($garmentType === 'shirt') {
            return "👔 এক্সিকিউটিভ শার্ট পরামর্শ:
• কলার: সেমি-স্প্রেড ফরমাল কলার (টাই এবং ওপেন উভয়ভাবেই দারুণ মানাবে)।
• কাফ: ২.৫ ইঞ্চি সিঙ্গেল বাটন কাফ।
• ফ্রন্ট: ক্লিন ফ্রেঞ্চ প্লাকেট, বাম পাশে ক্লাসিক ভি-পকেট।
• কাট: সাইড স্লিভ রাউন্ড কার্ভ।";
        }

        if ($garmentType === 'pant') {
            return "👖 প্যান্ট পরামর্শ:
• ফিটিং: স্লিম ট্রাউজার্স উইদাউট প্লেট (Flat Front)।
• পকেট: ক্রস হ্যান্ড পকেট, পেছনে ডানপাশে সিকিউর বোতাম পকেট।
• মুহুরি: ১৪.৫ ইঞ্চি অ্যাঙ্কেল লেন্থ হেম।";
        }

        return "✂️ কাস্টম কাটিং পরামর্শ: বডি পরিমাপ অনুযায়ী স্ট্যান্ডার্ড ফিটিং ও ডাবল স্টিচিং সুপারিশ করা হলো।";
    }
}
