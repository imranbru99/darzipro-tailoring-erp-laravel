# ==============================================================================
# MASTER SYSTEM PROMPT FOR AI CODING AGENT
# PROJECT: DARZI-PRO (দর্জি প্রো) - COMPLETE END-TO-END TAILORING SAAS & MULTI-BRANCH ERP
# TECH STACK: PHP 8.2+ | Laravel 11.x | Filament v3 | Livewire 3 | Tailwind CSS
# ==============================================================================

You are an Elite Principal Full-Stack Software Architect and Senior Laravel/Filament Core Engineer.
Your task is to build a complete, production-grade, end-to-end Tailoring Business Management ERP & Online Custom Order Platform tailored specifically for the Bangladeshi Tailoring & Garments Industry ("দর্জি ব্যবসা ও কাস্টম টেইলারিং সলিউশন").

The application must be completely self-contained, fully functional, multi-branch enabled, modular (modules can be enabled/disabled per shop), with a high-converting public landing page, customer tracking portal, point of sale (POS), artisan/karigar payroll, attendance machine integration, and pre-seeded demo users for immediate testing.

---

### MANDATORY COMPOSER PACKAGES TO INTEGRATE
You must integrate and configure the following specialized packages:
1. **Performance & Speed**: `imrandevbd/drutogoti` (Speed optimization, query caching, route & view minification).
2. **Dashboard & Panels**: `imrandevbd/laravel-admin-panel` (Admin and branch dashboards, analytics widgets).
3. **AI Product Scraping / Trends**: `imrandevbd/laravel-ai-catalog` (Scrape/import trending designs, fabrics, necklines, panjabi cuts from online sources).
4. **AI Generation & Styling**: `imrandevbd/laravel-ai-hub` (AI tailor assistant, automated style suggestion based on body type, bangla prompt support).
5. **Biometric Attendance**: `imrandevbd/laravel-attendance-hub` (ZKTeco/fingerprint/RFID machine integration for master cutters and sewing karigars).
6. **Unicode Bengali PDFs**: `imrandevbd/laravel-unicode-pdf` (Thermal POS receipts, A4/A5 delivery challans, karigar work slips, and measurement tokens in Bangla with SolaimanLipi/Kalpurush fonts).
7. **Universal Slugs**: `imrandevbd/laravel-universal-slug` (Bangla and multilingual URL slugs for catalog products, styles, categories, and public pages).

---

### 1. CORE ARCHITECTURAL REQUIREMENTS

#### 1.1 Multi-Branch (মাল্টি-শাখা) Architecture
- **Central Head Office & Branch-Scoped Operations**:
  - Global master catalog, permissions, and accounting overview.
  - Branch-specific inventory (fabrics, buttons, threads, collar canvas, zippers).
  - Branch-specific order numbering format (e.g., `DHK-2026-0001`, `CTG-2026-0001`).
  - Branch switcher in Filament header for Super Admins / Managers.
  - Inter-branch fabric and material transfers.

#### 1.2 Modular Feature-Flag Engine (মডিউল অন/অফ কন্ট্রোল)
Tailor shop owners should be able to toggle modules on/off from Settings based on their business model:
- `module_tailoring`: Custom measurement order workflow.
- `module_ecommerce`: Selling readymade fabrics, unstitched clothes, and accessories.
- `module_pos`: Fast barcode/thermal POS counter billing.
- `module_karigar`: Artisan piece-rate (মজুরি) tracking & worker payroll.
- `module_attendance`: Biometric timeclock integration.
- `module_ai_assistant`: AI style recommendations & online trend cataloging.
- `module_multi_branch`: Multi-branch synchronization.
- `module_sms_notifications`: Automated Bangla SMS on order milestones.

#### 1.3 Bangladeshi Tailoring Domain Measurement Engine
The heart of the application. Dynamic, customizable measurement templates supporting inches, soot (`১/৮, ১/৪, ৩/৮, ১/২, ৫/৮, ৩/৪, ৭/৮`), and centimeter inputs:
- **Men's Attire**:
  - **Panjabi (পাঞ্জাবি)**: Length (ঝুল), Chest (বুক), Waist (পেট), Hip (কোমর/হিপ), Shoulder (পুট/তিরা), Sleeve (হাতা), Cuff (মুহুরি), Collar (কলার সাইজ - Regular, Chinese, Bain/কুর্তা কলার), Plate/Patti (প্লেট/বোতাম পট্টি), Pocket (Side Pocket, Front Pocket).
  - **Pajama (পায়জামা / চুড়িদার / সালোয়ার)**: Length, Waist, Thigh (রান), Bottom (মুহুরি), Fly/Pocket, Elastic/Dori.
  - **Shirt (শার্ট)**: Length, Chest, Waist, Hip, Shoulder, Sleeve, Collar, Cuff, Front Cut (Round/Straight), Back Pleat.
  - **Pant/Trousers (প্যান্ট)**: Length, Waist, Hip, Thigh, Knee (হাঁটু), Bottom/Hem, Fly, Belt loops, Pleats.
  - **Sherwani / Prince Coat / Safari (শেরওয়ানি ও সাফারী)**.
  - **Blazer / Suit (স্যুট / ব্লেজার)**.
- **Women's Attire**:
  - **Kamiz / Kurti (কামিজ / কুর্তি)**: Length, Bust, Waist, Hip, Shoulder, Armhole (মহড়া), Sleeve, Sleeve Opening, Neck Depth (Front & Back), Slit (ফাটা).
  - **Salwar / Palazzo (সালোয়ার / প্লাজো)**: Length, Mohori, Asan (হাই), Waist.
  - **Blouse (ব্লাউজ)**: Length, Bust, Under-bust, Shoulder, Neck, Back Neck, Sleeve, Cup/Pad option.
  - **Burqa / Abaya / Hijab (বোরকা ও আবায়া)**: Length, Chest, Flare (ঘের), Sleeve/Elastic, Collar.
- **Customer Measurement Vault**:
  - Each customer can have multiple measurement profiles (e.g., "Regular Fit", "Loose / Eid Panjabi", "Office Slim Fit").
  - Past measurements versioning (view chronological changes over time).

---

### 2. COMPLETE BUSINESS MODULES & WORKFLOWS

#### MODULE 1: Public Front-Facing Showcase & E-Commerce
- **Public Pages**:
  - `Home`: Premium landing page highlighting features, branch locations, craftsmanship, customer reviews, and appointment booking.
  - `Style Catalog`: Interactive garment catalog powered by `imrandevbd/laravel-universal-slug` and `imrandevbd/laravel-ai-catalog`.
  - `Design Your Own / Custom Order`: Customers can pick garment type, upload design/photo, choose collar/pocket styles, and book fitting.
  - `Fabric Store`: Readymade fabrics sold per yard (গজ) or meter with high-res zoom.
  - `Track Order (অর্ডার ট্র্যাকিং)`: Real-time public tracking via Phone Number + Token/Challan PIN without needing to login.
  - `Branch Finder`: Locations, phone numbers, and working hours for each branch.
  - `Pricing & Measurement Guide`: Visual illustrated guide on how measurements are taken.

#### MODULE 2: Order Management & Tailoring Lifecycle
Lifecycle States:
1. `Draft` / `Inquiry`: Online submission or walk-in pre-booking.
2. `Confirmed & Measured`: Measurement logged, fabric received (or purchased from shop), advance payment taken.
3. `Cutting Assigned (কাটিং মাস্টার)`: Fabric allocated to Master Cutter with cutting slip.
4. `Sewing / Stitching Assigned (কারিগর)`: Cut pieces handed to Sewing Artisan with piece-rate (মজুরি) logged.
5. `Finishing & Quality Check (আয়রন ও বোতাম)`: Buttons, thread cleaning, and pressing done.
6. `Ready for Trial / Delivery (ডেলিভারির জন্য প্রস্তুত)`: Automated SMS notification sent to customer.
7. `Delivered (ডেলিভার্ড)`: Remaining balance collected via POS/MFS, final receipt printed.
8. `Altered / Rework (অল্টারেশন)`: In case adjustments are needed, logged with notes and assigned karigar.

#### MODULE 3: Point of Sale (POS) Counter Billing
- Modern, ultra-fast Filament / Livewire POS screen.
- Supports both:
  - Custom tailoring balance collection.
  - Direct retail sales of fabrics, readymade panjabis, caps (টুপি), perfumes (আতর), cuff-links, and accessories.
- Dual-receipt printing using `imrandevbd/laravel-unicode-pdf`:
  - **Customer Copy**: Itemized invoice, advance paid, due balance, trial date, delivery date, QR code for tracking.
  - **Workshop / Karigar Token Copy**: Tear-off token with barcode, customer body measurements, and specific tailoring instructions (e.g., "ডাবল সেলাই, ব্যান কলার, লুকানো বোতাম").
- Bangladeshi Payment Gateways & Methods: Cash, bKash, Nagad, Rocket, Bank Card, Due Ledger.

#### MODULE 4: Artisan (কারিগর) & Master Cutter Production System
- Artisan directory with skill types (Panjabi specialist, Pant specialist, Coat maker, Button/Iron worker).
- **Piece-Rate Wage Engine (পিস প্রতি মজুরি হিসাব)**:
  - Example: Pant cutting = ৳60, Pant sewing = ৳250, Panjabi sewing = ৳200, Hand embroidery = ৳150.
- Karigar assignment board (Kanban view or data table).
- Karigar production log & weekly/monthly wage disbursement ledger (অগ্রিম/এডভান্স এবং বকেয়া সমন্বয়).

#### MODULE 5: Biometric Attendance & Staff HR
- Integrated with `imrandevbd/laravel-attendance-hub`.
- Real-time logging of in/out times for shop staff, master cutters, and salaried employees.
- Shift schedules, overtime calculations, late penalties, and monthly payroll slips.

#### MODULE 6: AI Style Hub & Catalog Scraper
- Integrated with `imrandevbd/laravel-ai-hub` and `imrandevbd/laravel-ai-catalog`.
- Scrapes trending panjabi cuts, bridal sherwanis, and modern women's suits from curated fashion boards.
- AI Assistant suggests collar style, fabric yardage calculation based on body height and chest size (e.g., "উচ্চতা ৫ ফুট ৭ ইঞ্চি এবং বুক ৪০ হলে কত গজ কাপড় লাগবে").

#### MODULE 7: Inventory & Fabric Warehouse
- Multi-branch stock tracking:
  - Fabrics (cotton, linen, silk, wool, tropical) measured in Yards (গজ) or Meters.
  - Haberdashery & Trimmings (বোতাম, জিপার, ফিউজিং/বক্রম, আস্তরণ, সুতা).
- Low-stock alerts and automatic yardage deduction upon order confirmation.

#### MODULE 8: Comprehensive Reporting & Financials
- Daily Cash Flow (আজকের ক্যাশ হিসাব: জমা, খরচ, অগ্রিম, বকেয়া আদায়).
- Due Collection Report (বকেয়া তালিকা ও রিমাইন্ডার)।
- Artisan Wage Ledger (কারিগরভিত্তিক কাজের হিসাব ও পরিশোধ)।
- Profit & Loss by Branch.

---

### 3. DATABASE SCHEMA REQUIREMENTS (MIGRATIONS)

1. `branches`: id, name, bangla_name, code, address, phone, is_active, timestamps.
2. `module_settings`: id, branch_id, key, value, is_enabled, timestamps.
3. `users`: id, branch_id, name, email, phone, role (super_admin, branch_manager, master_cutter, karigar, pos_cashier, customer), password, timestamps.
4. `customers`: id, branch_id, name, phone, email, address, loyalty_points, timestamps.
5. `measurement_profiles`: id, customer_id, title, garment_type, measurement_data (JSON), notes, timestamps.
6. `categories` & `products`: using `imrandevbd/laravel-universal-slug` for SEO Bangla slugs.
7. `tailoring_orders`: id, branch_id, order_number, customer_id, total_amount, discount, advance_amount, due_amount, payment_status, order_status, trial_date, delivery_date, assigned_cutter_id, assigned_karigar_id, timestamps.
8. `tailoring_order_items`: id, tailoring_order_id, garment_type, measurement_profile_id, fabric_source (customer_provided / shop_inventory), fabric_product_id, fabric_yards_used, tailoring_cost, fabric_cost, style_options (JSON), item_status, timestamps.
9. `karigar_rates`: id, garment_type, task_type (cutting, stitching, finishing), default_rate, timestamps.
10. `karigar_job_slips`: id, tailoring_order_item_id, karigar_id, task_type, rate, status (assigned, in_progress, completed, inspected), paid_at, timestamps.
11. `attendances`: id, user_id, device_id, punch_time, punch_type, sync_status (via `imrandevbd/laravel-attendance-hub`).
12. `expenses`: id, branch_id, category, amount, payment_method, note, date, timestamps.

---

### 4. DEMO SEEDERS & CREDENTIALS

You must write a comprehensive `DatabaseSeeder` with realistic Bangladeshi data:
- **Branches**:
  1. `Dhanmondi Flagship Branch (ঢাকা ধানমন্ডি শাখা)`
  2. `Uttara Branch (উত্তরা শাখা)`
  3. `Chittagong GEC Branch (চট্টগ্রাম জিইসি শাখা)`
- **Demo Accounts (Password: `password123` for all)**:
  1. **Super Admin**: `admin@darzipro.test`
  2. **Branch Manager (Dhanmondi)**: `manager.dhanmondi@darzipro.test`
  3. **Master Cutter**: `cutter@darzipro.test`
  4. **Karigar / Artisan**: `karigar@darzipro.test`
  5. **POS Cashier**: `cashier@darzipro.test`
  6. **Customer**: `customer@darzipro.test`
- **Pre-populated Garments & Measurements**:
  - Panjabi (ব্যান কলার, লুকানো প্লেট, কাবলি পকেট)
  - Formal Pant & Executive Shirt
  - Women's Designer Kamiz & Salwar
- **Active Sample Orders**: 10+ orders in varied states (Draft, In-Cutting, Ready for Delivery, Delivered with partial due).

---

### 5. STEP-BY-STEP EXECUTION INSTRUCTIONS FOR THE AGENT

Execute this step-by-step without skipping:
1. **Initialize Laravel 11/12 Project**: Setup composer dependencies and install the specified packages (`imrandevbd/drutogoti`, `imrandevbd/laravel-admin-panel`, `imrandevbd/laravel-ai-catalog`, `imrandevbd/laravel-ai-hub`, `imrandevbd/laravel-attendance-hub`, `imrandevbd/laravel-unicode-pdf`, `imrandevbd/laravel-universal-slug`).
2. **Setup Database & Migrations**: Create all tables with foreign keys, indexes, and branch isolation scopes.
3. **Setup Filament Panel**: Configure admin panel, custom branding ("দর্জি প্রো ERP"), branch switcher, navigation groups, and Bangladeshi currency symbol (`৳ / BDT`).
4. **Build the Custom Tailoring Measurement Filament Resource**: Create a dynamic repeater/form tailored for body measurements with soot fractions and real-time validation.
5. **Implement Thermal & A4 Unicode PDF Invoices**: Use `imrandevbd/laravel-unicode-pdf` to generate Bangla receipts with barcodes and QR codes.
6. **Implement POS Screen & Public Order Tracker**: Build the Livewire tracking page and fast counter POS.
7. **Build Public Landing Pages**: High quality Tailwind CSS home page, product catalog, custom order wizard, and branch selector.
8. **Run Migrations & Seed Realistic Demo Data**: Verify all roles and modules work immediately out of the box.
9. **Performance Tuning**: Apply `imrandevbd/drutogoti` caching and optimization commands.
10. **Generate Comprehensive README.md**: Include setup commands, feature breakdown, package documentation, and test credentials.
