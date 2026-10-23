<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\KarigarJobSlip;
use App\Models\KarigarRate;
use App\Models\MeasurementProfile;
use App\Models\ModuleSetting;
use App\Models\Product;
use App\Models\TailoringOrder;
use App\Models\TailoringOrderItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password123');

        // 1. Seed Branches
        $branchDhanmondi = Branch::create([
            'name'        => 'Dhanmondi Flagship Branch',
            'bangla_name' => 'ঢাকা ধানমন্ডি ফ্ল্যাগশিপ শাখা',
            'code'        => 'DHK',
            'phone'       => '01711-000001',
            'email'       => 'dhanmondi@darzipro.test',
            'address'     => 'বাড়ি #১২, রোড #৪/এ, সাত মসজিদ রোড, ধানমন্ডি, ঢাকা-১২০৯',
            'is_active'   => true,
        ]);

        $branchUttara = Branch::create([
            'name'        => 'Uttara Branch',
            'bangla_name' => 'ঢাকা উত্তরা শাখা',
            'code'        => 'UTR',
            'phone'       => '01711-000002',
            'email'       => 'uttara@darzipro.test',
            'address'     => 'প্লট #৪৫, সেক্টর #৭, রবীন্দ্র সরণি, উত্তরা, ঢাকা-১২৩০',
            'is_active'   => true,
        ]);

        $branchCtg = Branch::create([
            'name'        => 'Chittagong GEC Branch',
            'bangla_name' => 'চট্টগ্রাম জিইসি শাখা',
            'code'        => 'CTG',
            'phone'       => '01711-000003',
            'email'       => 'ctg@darzipro.test',
            'address'     => 'জিইসি মোড়, সিডিএ এভিনিউ, নাসিরাবাদ, চট্টগ্রাম-৪০০০',
            'is_active'   => true,
        ]);

        // 2. Seed Module Settings (Feature Flags)
        $modules = [
            ['module_key' => 'module_tailoring', 'name' => 'Custom Tailoring & Measurements', 'bangla_name' => 'কাস্টম টেইলারিং ও মাপ ভল্ট', 'description' => 'পাঞ্জাবি, শার্ট, প্যান্টের পরিমাপ ও কাটিং ওয়ার্কফ্লো'],
            ['module_key' => 'module_ecommerce', 'name' => 'Readymade & Fabric Store', 'bangla_name' => 'তৈরি পোশাক ও গজ কাপড় বিক্রয়', 'description' => 'অনলাইন ফ্যাশন ক্যাটালগ ও গজ কাপড় ইনভেন্টরি'],
            ['module_key' => 'module_pos', 'name' => 'Fast Counter POS', 'bangla_name' => 'কাউন্টার পিওএস ও ক্যাশ বিলিং', 'description' => 'দ্রুত ডেলিভারি ক্যাশ কালেকশন ও থার্মাল প্রিন্টিং'],
            ['module_key' => 'module_karigar', 'name' => 'Artisan Piece-rate Wages', 'bangla_name' => 'কারিগর পিস-রেট মজুরি ও স্লিপ', 'description' => 'কাটিং মাস্টার ও সেলাই কারিগরদের মজুরি ট্র্যাকিং'],
            ['module_key' => 'module_attendance', 'name' => 'Biometric Attendance Hub', 'bangla_name' => 'ডিজিটাল বায়োমেট্রিক হাজিরা', 'description' => 'ফিঙ্গারপ্রিন্ট ও আরএফআইডি মেশিন সংযোগ'],
            ['module_key' => 'module_ai_assistant', 'name' => 'AI Style Hub & Yardage Calculator', 'bangla_name' => 'এআই ফ্যাশন ও গজ কাপড় নির্ণয়', 'description' => 'স্মার্ট বডি মেজারমেন্ট ফ্যাশন পরামর্শ'],
            ['module_key' => 'module_multi_branch', 'name' => 'Multi-Branch Synchronization', 'bangla_name' => 'মাল্টি-শাখা নেটওয়ার্ক', 'description' => 'একাধিক শাখা ব্যবস্থাপনা ও ইন্টার-ব্রাঞ্চ স্টক'],
            ['module_key' => 'module_sms', 'name' => 'Automated Bangla SMS', 'bangla_name' => 'স্বয়ংক্রিয় বাংলা এসএমএস', 'description' => 'অর্ডার নিশ্চিত ও ডেলিভারি প্রস্তুত হলে এসএমএস'],
        ];

        foreach ($modules as $mod) {
            ModuleSetting::create(array_merge($mod, [
                'branch_id'  => null, // Global default
                'is_enabled' => true,
            ]));
        }

        // 3. Seed Demo Users (Password: password123)
        $superAdmin = User::create([
            'branch_id' => null,
            'name'      => 'সুপার এডমিন (Chief Administrator)',
            'email'     => 'admin@darzipro.test',
            'phone'     => '01700000001',
            'role'      => 'super_admin',
            'password'  => $password,
        ]);

        $managerDhanmondi = User::create([
            'branch_id' => $branchDhanmondi->id,
            'name'      => 'কবির হোসেন (ধানমন্ডি ব্রাঞ্চ ম্যানেজার)',
            'email'     => 'manager.dhanmondi@darzipro.test',
            'phone'     => '01700000002',
            'role'      => 'branch_manager',
            'password'  => $password,
        ]);

        $masterCutter = User::create([
            'branch_id' => $branchDhanmondi->id,
            'name'      => 'ওস্তাদ মোশাররফ (প্রধান কাটিং মাস্টার)',
            'email'     => 'cutter@darzipro.test',
            'phone'     => '01700000003',
            'role'      => 'master_cutter',
            'password'  => $password,
        ]);

        $sewingKarigar = User::create([
            'branch_id' => $branchDhanmondi->id,
            'name'      => 'আব্দুল করিম (সিনিয়র পাঞ্জাবি কারিগর)',
            'email'     => 'karigar@darzipro.test',
            'phone'     => '01700000004',
            'role'      => 'karigar',
            'password'  => $password,
        ]);

        $posCashier = User::create([
            'branch_id' => $branchDhanmondi->id,
            'name'      => 'নাজমুল হাসান (কাউন্টার ক্যাশিয়ার)',
            'email'     => 'cashier@darzipro.test',
            'phone'     => '01700000005',
            'role'      => 'pos_cashier',
            'password'  => $password,
        ]);

        $customerUser = User::create([
            'branch_id' => $branchDhanmondi->id,
            'name'      => 'মাহমুদুল হক (সম্মানিত ক্লায়েন্ট)',
            'email'     => 'customer@darzipro.test',
            'phone'     => '01700000006',
            'role'      => 'customer',
            'password'  => $password,
        ]);

        // 4. Seed Karigar Default Rates
        $rates = [
            ['garment_type' => 'panjabi', 'task_type' => 'cutting', 'default_rate' => 60.00],
            ['garment_type' => 'panjabi', 'task_type' => 'stitching', 'default_rate' => 200.00],
            ['garment_type' => 'panjabi', 'task_type' => 'finishing', 'default_rate' => 40.00],
            ['garment_type' => 'pant', 'task_type' => 'cutting', 'default_rate' => 70.00],
            ['garment_type' => 'pant', 'task_type' => 'stitching', 'default_rate' => 250.00],
            ['garment_type' => 'shirt', 'task_type' => 'cutting', 'default_rate' => 50.00],
            ['garment_type' => 'shirt', 'task_type' => 'stitching', 'default_rate' => 180.00],
            ['garment_type' => 'kamiz', 'task_type' => 'stitching', 'default_rate' => 220.00],
        ];

        foreach ($rates as $r) {
            KarigarRate::create($r);
        }

        // 5. Seed Categories & Products
        $catFabrics = Category::create([
            'name'        => 'Fabrics & Unstitched',
            'bangla_name' => 'গজ কাপড় ও থান কাপড়',
            'is_active'   => true,
        ]);

        $catReadymade = Category::create([
            'name'        => 'Readymade Attire',
            'bangla_name' => 'তৈরি পোশাক ও পাঞ্জাবি',
            'is_active'   => true,
        ]);

        $catAccessories = Category::create([
            'name'        => 'Accessories & Fragrances',
            'bangla_name' => 'আতর ও এক্সেসরিজ',
            'is_active'   => true,
        ]);

        $fab1 = Product::create([
            'category_id'        => $catFabrics->id,
            'branch_id'          => $branchDhanmondi->id,
            'name'               => 'Egyptian Giza Cotton (Off-White)',
            'bangla_name'        => 'মিশরীয় ১০০% গিজা কটন (অফ-হোয়াইট)',
            'sku'                => 'FAB-GIZA-01',
            'product_type'       => 'fabric',
            'unit'               => 'yard',
            'cost_price'         => 420.00,
            'selling_price'      => 650.00,
            'stock_quantity'     => 150.00,
            'fabric_composition' => '100% Egyptian Cotton',
            'color'              => 'Off-White',
            'is_featured'        => true,
            'is_active'          => true,
        ]);

        $fab2 = Product::create([
            'category_id'        => $catFabrics->id,
            'branch_id'          => $branchDhanmondi->id,
            'name'               => 'Pure Mulberry Silk (Navy Blue)',
            'bangla_name'        => 'খাঁটি তুঁত সিল্ক ফেব্রিক (নেভি ব্লু)',
            'sku'                => 'FAB-SILK-02',
            'product_type'       => 'fabric',
            'unit'               => 'yard',
            'cost_price'         => 800.00,
            'selling_price'      => 1250.00,
            'stock_quantity'     => 80.00,
            'fabric_composition' => '100% Pure Silk',
            'color'              => 'Navy Blue',
            'is_featured'        => true,
            'is_active'          => true,
        ]);

        $fab3 = Product::create([
            'category_id'        => $catFabrics->id,
            'branch_id'          => $branchDhanmondi->id,
            'name'               => 'Italian Tropical Suiting (Charcoal)',
            'bangla_name'        => 'ইতালিয়ান ট্রপিক্যাল প্যান্ট ফেব্রিক (চারকোল)',
            'sku'                => 'FAB-TROP-03',
            'product_type'       => 'fabric',
            'unit'               => 'yard',
            'cost_price'         => 550.00,
            'selling_price'      => 850.00,
            'stock_quantity'     => 120.00,
            'fabric_composition' => 'Poly-Viscose Wool Blend',
            'color'              => 'Charcoal Grey',
            'is_featured'        => true,
            'is_active'          => true,
        ]);

        $ready1 = Product::create([
            'category_id'        => $catReadymade->id,
            'branch_id'          => $branchDhanmondi->id,
            'name'               => 'Festive Embroidered Kabli Panjabi',
            'bangla_name'        => 'ঈদ স্পেশাল হ্যান্ড-এমব্রয়ডারি কাবলি পাঞ্জাবি',
            'sku'                => 'RDY-PANJ-01',
            'product_type'       => 'readymade',
            'unit'               => 'piece',
            'cost_price'         => 1400.00,
            'selling_price'      => 2450.00,
            'stock_quantity'     => 25.00,
            'is_featured'        => true,
            'is_active'          => true,
        ]);

        $acc1 = Product::create([
            'category_id'        => $catAccessories->id,
            'branch_id'          => $branchDhanmondi->id,
            'name'               => 'Royal White Oudh Attar (12ml)',
            'bangla_name'        => 'রয়্যাল হোয়াইট উদ আতর (১২ মি.লি.)',
            'sku'                => 'ACC-OUDH-01',
            'product_type'       => 'accessory',
            'unit'               => 'piece',
            'cost_price'         => 350.00,
            'selling_price'      => 650.00,
            'stock_quantity'     => 50.00,
            'is_featured'        => true,
            'is_active'          => true,
        ]);

        // 6. Seed Customers & Measurement Profiles
        $customer1 = Customer::create([
            'branch_id'      => $branchDhanmondi->id,
            'name'           => 'তানভীর আহমেদ',
            'phone'          => '01711223344',
            'email'          => 'tanveer@example.com',
            'address'        => 'রোড ৭, বাড়ি ৪২, ধানমন্ডি, ঢাকা',
            'gender'         => 'male',
            'loyalty_points' => 120,
            'special_notes'  => 'ঢিলেঢালা ফিটিং ও সুতি কাপড় পছন্দ করেন।',
        ]);

        MeasurementProfile::create([
            'customer_id'  => $customer1->id,
            'title'        => 'ঈদের পাঞ্জাবি - ঢিলে ফিট',
            'garment_type' => 'panjabi',
            'measurements' => [
                'length'   => 41.5,
                'chest'    => 40.0,
                'waist'    => 38.0,
                'hip'      => 42.0,
                'shoulder' => 18.0,
                'sleeve'   => 25.0,
                'cuff'     => 11.0,
                'collar'   => 16.0,
            ],
            'notes'        => 'ব্যান কলার ও লুকানো বোতাম পট্টি।',
            'is_default'   => true,
        ]);

        MeasurementProfile::create([
            'customer_id'  => $customer1->id,
            'title'        => 'ক্লাসিক সাদা পায়জামা',
            'garment_type' => 'pajama',
            'measurements' => [
                'length' => 40.0,
                'waist'  => 36.0,
                'thigh'  => 28.0,
                'bottom' => 16.0,
                'asan'   => 16.0,
            ],
            'notes'        => 'দড়ি সিস্টেম কোমর।',
            'is_default'   => true,
        ]);

        $customer2 = Customer::create([
            'branch_id'      => $branchUttara->id,
            'name'           => 'নাফিসা কামাল',
            'phone'          => '01819556677',
            'email'          => 'nafisa@example.com',
            'address'        => 'সেক্টর ৩, উত্তরা, ঢাকা',
            'gender'         => 'female',
            'loyalty_points' => 80,
        ]);

        MeasurementProfile::create([
            'customer_id'  => $customer2->id,
            'title'        => 'ডিজাইনার লং কামিজ',
            'garment_type' => 'kamiz',
            'measurements' => [
                'length'     => 43.0,
                'bust'       => 36.0,
                'waist'      => 32.0,
                'hip'        => 38.0,
                'shoulder'   => 14.5,
                'armhole'    => 16.5,
                'sleeve'     => 19.0,
                'mohori'     => 10.5,
                'neck_front' => 6.0,
                'neck_back'  => 4.5,
                'slit'       => 21.0,
            ],
            'notes'        => 'বোট নেক ও কোয়ার্টার হাতা।',
            'is_default'   => true,
        ]);

        $customer3 = Customer::create([
            'branch_id'      => $branchCtg->id,
            'name'           => 'রফিকুল ইসলাম চৌধুরী',
            'phone'          => '01911889900',
            'address'        => 'মেহেন্দীবাগ, চট্টগ্রাম',
            'gender'         => 'male',
            'loyalty_points' => 200,
        ]);

        // 7. Seed Tailoring Orders across multiple stages
        
        // Order 1: Ready for Delivery (Partially paid)
        $order1 = TailoringOrder::create([
            'branch_id'             => $branchDhanmondi->id,
            'customer_id'           => $customer1->id,
            'created_by'            => $managerDhanmondi->id,
            'order_number'          => 'DHK-2026-0001',
            'token_pin'             => '8421',
            'subtotal'              => 2350.00,
            'discount_amount'       => 100.00,
            'total_amount'          => 2250.00,
            'advance_amount'        => 1500.00,
            'due_amount'            => 750.00,
            'payment_status'        => 'partial',
            'order_status'          => 'ready_for_delivery',
            'payment_method'        => 'bkash',
            'transaction_reference' => 'BK987X21',
            'trial_date'            => now()->subDays(2),
            'delivery_date'         => now()->addDay(),
            'notes'                 => 'ঈদের আগের দিন ডেলিভারি দিতে হবে।',
        ]);

        $item1_1 = TailoringOrderItem::create([
            'tailoring_order_id'  => $order1->id,
            'garment_type'        => 'panjabi',
            'fabric_source'       => 'shop_inventory',
            'fabric_product_id'   => $fab1->id,
            'fabric_yards_used'   => 2.50,
            'tailoring_price'     => 500.00,
            'fabric_price'        => 1625.00,
            'subtotal'            => 2125.00,
            'custom_measurements' => [
                'length' => 41.5, 'chest' => 40.0, 'waist' => 38.0, 'shoulder' => 18.0, 'sleeve' => 25.0, 'collar' => 16.0
            ],
            'style_attributes'    => [
                'collar_type' => 'ব্যান কলার (Mandarin)',
                'placket'     => 'লুকানো বোতাম পট্টি (Hidden Placket)',
                'pocket'      => '২ পাশে সাইড পকেট',
            ],
            'item_status'         => 'done',
        ]);

        $item1_2 = TailoringOrderItem::create([
            'tailoring_order_id'  => $order1->id,
            'garment_type'        => 'pajama',
            'fabric_source'       => 'customer_provided',
            'tailoring_price'     => 225.00,
            'fabric_price'        => 0.00,
            'subtotal'            => 225.00,
            'custom_measurements' => ['length' => 40.0, 'waist' => 36.0, 'bottom' => 16.0],
            'item_status'         => 'done',
        ]);

        // Job Slips for Order 1
        KarigarJobSlip::create([
            'branch_id'               => $branchDhanmondi->id,
            'tailoring_order_item_id' => $item1_1->id,
            'karigar_id'              => $masterCutter->id,
            'task_type'               => 'cutting',
            'rate'                    => 60.00,
            'status'                  => 'completed',
            'completed_at'            => now()->subDays(3),
            'paid_at'                 => now()->subDays(1),
        ]);

        KarigarJobSlip::create([
            'branch_id'               => $branchDhanmondi->id,
            'tailoring_order_item_id' => $item1_1->id,
            'karigar_id'              => $sewingKarigar->id,
            'task_type'               => 'stitching',
            'rate'                    => 200.00,
            'status'                  => 'completed',
            'completed_at'            => now()->subDays(1),
            'paid_at'                 => null, // Wage pending
        ]);

        // Order 2: In Sewing
        $order2 = TailoringOrder::create([
            'branch_id'             => $branchUttara->id,
            'customer_id'           => $customer2->id,
            'order_number'          => 'UTR-2026-0001',
            'token_pin'             => '5291',
            'subtotal'              => 1450.00,
            'discount_amount'       => 0.00,
            'total_amount'          => 1450.00,
            'advance_amount'        => 1000.00,
            'due_amount'            => 450.00,
            'payment_status'        => 'partial',
            'order_status'          => 'in_sewing',
            'payment_method'        => 'nagad',
            'delivery_date'         => now()->addDays(4),
        ]);

        $item2_1 = TailoringOrderItem::create([
            'tailoring_order_id'  => $order2->id,
            'garment_type'        => 'kamiz',
            'fabric_source'       => 'customer_provided',
            'tailoring_price'     => 650.00,
            'fabric_price'        => 0.00,
            'subtotal'            => 650.00,
            'custom_measurements' => ['length' => 43.0, 'bust' => 36.0, 'waist' => 32.0, 'sleeve' => 19.0],
            'item_status'         => 'stitched',
        ]);

        // Order 3: Delivered & Paid in full
        $order3 = TailoringOrder::create([
            'branch_id'             => $branchCtg->id,
            'customer_id'           => $customer3->id,
            'order_number'          => 'CTG-2026-0001',
            'token_pin'             => '3142',
            'subtotal'              => 1850.00,
            'discount_amount'       => 50.00,
            'total_amount'          => 1800.00,
            'advance_amount'        => 1800.00,
            'due_amount'            => 0.00,
            'payment_status'        => 'paid',
            'order_status'          => 'delivered',
            'payment_method'        => 'cash',
            'delivery_date'         => now()->subDays(1),
        ]);

        // 8. Seed Shop Expenses
        Expense::create([
            'branch_id'      => $branchDhanmondi->id,
            'user_id'        => $managerDhanmondi->id,
            'title'          => 'মার্চ মাসের দোকান ভাড়া (অগ্রিম)',
            'category'       => 'rent',
            'amount'         => 35000.00,
            'payment_method' => 'bank_transfer',
            'expense_date'   => now()->startOfMonth(),
        ]);

        Expense::create([
            'branch_id'      => $branchDhanmondi->id,
            'user_id'        => $managerDhanmondi->id,
            'title'          => 'জাপানি সেলাই সুতা ও কলার বক্রম পাইকারি ক্রয়',
            'category'       => 'haberdashery',
            'amount'         => 4500.00,
            'payment_method' => 'cash',
            'expense_date'   => now()->subDays(2),
        ]);

        Expense::create([
            'branch_id'      => $branchDhanmondi->id,
            'user_id'        => $managerDhanmondi->id,
            'title'          => 'কারিগর মোশাররফ সাহেবকে জরুরি এডভান্স প্রদান',
            'category'       => 'artisan_advance',
            'amount'         => 2000.00,
            'payment_method' => 'cash',
            'expense_date'   => now()->subDay(),
        ]);
    }
}
