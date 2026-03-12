<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // ── Create a test event ──
        $event = Event::create([
            'name'         => 'درس الفقه الأسبوعي',
            'description'  => 'درس فقه أسبوعي يقام كل يوم ثلاثاء بعد صلاة العشاء في مسجد الحمد.',
            'location'     => 'مسجد الحمد — ركن الدين',
            'event_date'   => now()->addDays(3)->setTime(20, 30),
            'max_attendees'=> 80,
            'notes'        => 'يرجى الحضور قبل 10 دقائق',
            'is_active'    => true,
        ]);

        // ── Get area IDs by name ──
        $areaIds = Area::pluck('id', 'name')->toArray();

        // ── السائقون — موزعون على كل المحاور الـ 7 ──
        // المناطق المستخدمة هنا تطابق بالضبط ما في TransportSeeder
        $drivers = [
            // محور 1: ببيلا والجنوب البعيد
            ['name' => 'سامر الحلبي',     'phone' => '0991234501', 'area' => 'ببيلا (البلد)',                         'seats' => 4, 'landmark' => 'مسجد ببيلا الكبير'],
            ['name' => 'رائد الأسعد',     'phone' => '0991234502', 'area' => 'يلدا / بيت سحم',                       'seats' => 3, 'landmark' => 'مدخل يلدا الشمالي'],

            // محور 2: الميدان والزاهرة
            ['name' => 'ياسر القدسي',     'phone' => '0991234503', 'area' => 'ميدان أبو حبل',                        'seats' => 3, 'landmark' => 'بجانب سوق الميدان'],
            ['name' => 'حمزة العمري',     'phone' => '0991234504', 'area' => 'الزاهرة الجديدة',                      'seats' => 4, 'landmark' => 'ساحة الزاهرة'],

            // محور 3: المزة
            ['name' => 'خالد حسن',        'phone' => '0991234505', 'area' => 'المزة - أوتوستراد (فيلات شرقية وغربية)', 'seats' => 4, 'landmark' => 'أوتستراد المزة'],
            ['name' => 'فراس الدمشقي',    'phone' => '0991234506', 'area' => 'المزة 86 (مدرسة)',                      'seats' => 3, 'landmark' => 'مقابل مدرسة المزة 86'],

            // محور 4: كفرسوسة
            ['name' => 'فادي النجار',     'phone' => '0991234507', 'area' => 'تنظيم كفرسوسة (ساحة شام سيتي سنتر)',   'seats' => 3, 'landmark' => 'مقابل شام سيتي سنتر'],
            ['name' => 'وسيم الكردي',     'phone' => '0991234508', 'area' => 'كفرسوسة - الواحة',                     'seats' => 4, 'landmark' => 'منطقة الواحة'],

            // محور 5: الشمال الغربي (دمر وقدسيا)
            ['name' => 'جمال الحمصي',     'phone' => '0991234509', 'area' => 'دمر البلد',                            'seats' => 3, 'landmark' => 'ساحة دمر'],
            ['name' => 'بلال السوري',     'phone' => '0991234510', 'area' => 'قدسيا (البلد / الساحة)',               'seats' => 4, 'landmark' => 'ساحة قدسيا'],

            // محور 6: الوسط والشرق
            ['name' => 'محمد العلي',      'phone' => '0991234511', 'area' => 'شارع بغداد / المزرعة',                 'seats' => 3, 'landmark' => 'شارع بغداد الرئيسي'],
            ['name' => 'أحمد الشامي',     'phone' => '0991234512', 'area' => 'العباسيين / الزبلطاني',                'seats' => 4, 'landmark' => 'ساحة العباسيين'],

            // محور 7: الشمال والشمال الشرقي
            ['name' => 'عمر الديري',      'phone' => '0991234513', 'area' => 'برزة البلد',                           'seats' => 4, 'landmark' => 'مقابل جامع الفتح'],
            ['name' => 'طارق عبدالرحمن', 'phone' => '0991234514', 'area' => 'القابون',                               'seats' => 3, 'landmark' => 'مدخل القابون'],
        ];

        foreach ($drivers as $d) {
            $areaId = $areaIds[$d['area']] ?? null;
            Registration::create([
                'event_id'         => $event->id,
                'name'             => $d['name'],
                'phone'            => $d['phone'],
                'area'             => $d['area'],
                'area_id'          => $areaId,
                'nearest_landmark' => $d['landmark'],
                'has_car'          => true,
                'available_seats'  => $d['seats'],
                'willing_to_drive' => true,
                'needs_ride'       => false,
                'driver_token'     => Str::random(48),
            ]);
        }

        // ── الركاب — موزعون على المحاور عشان نختبر التوزيع ──
        $passengers = [
            // محور 1: ببيلا والجنوب البعيد
            ['name' => 'عبدالله المصري',  'phone' => '0991234601', 'area' => 'ببيلا (البلد)',          'landmark' => 'قرب الجامع'],
            ['name' => 'حسام البيطار',    'phone' => '0991234602', 'area' => 'سيدي مقداد',            'landmark' => 'مدخل سيدي مقداد'],
            ['name' => 'منذر الأيوبي',    'phone' => '0991234603', 'area' => 'القزاز',                'landmark' => 'شارع القزاز'],
            ['name' => 'وليد العثمان',    'phone' => '0991234604', 'area' => 'يلدا / بيت سحم',        'landmark' => 'مدخل يلدا الجنوبي'],

            // محور 2: الميدان والزاهرة
            ['name' => 'يوسف الأحمد',    'phone' => '0991234605', 'area' => 'باب مصلى / المجتهد',    'landmark' => 'بجانب المستشفى'],
            ['name' => 'زياد الخطيب',    'phone' => '0991234606', 'area' => 'ميدان غواص / بوابة الميدان', 'landmark' => 'بوابة الميدان'],
            ['name' => 'سعد الحموي',     'phone' => '0991234607', 'area' => 'الزاهرة القديمة',       'landmark' => 'ساحة الزاهرة القديمة'],
            ['name' => 'ثامر الرفاعي',   'phone' => '0991234608', 'area' => 'التضامن / دف الشوك',   'landmark' => 'منطقة التضامن'],
            ['name' => 'مصطفى عيسى',     'phone' => '0991234609', 'area' => 'الزاهرة الجديدة',      'landmark' => 'شارع الزاهرة الجديد'],

            // محور 3: المزة
            ['name' => 'رامي السعيد',    'phone' => '0991234610', 'area' => 'المواساة / مستشفى الأطفال', 'landmark' => 'مقابل مستشفى الأطفال'],
            ['name' => 'نادر حمودة',     'phone' => '0991234611', 'area' => 'المزة - شيخ سعد',       'landmark' => 'شارع شيخ سعد'],
            ['name' => 'تيسير الجمال',   'phone' => '0991234612', 'area' => 'المزة جبل',             'landmark' => 'مدخل المزة جبل'],
            ['name' => 'نور العراقي',    'phone' => '0991234613', 'area' => 'المزة 86 (خزان)',        'landmark' => 'منطقة الخزان'],
            ['name' => 'هيثم السلطي',    'phone' => '0991234614', 'area' => 'السومرية',              'landmark' => 'آخر السومرية'],

            // محور 4: كفرسوسة
            ['name' => 'باسل الكيالي',   'phone' => '0991234615', 'area' => 'الجمارك / عقدة كفرسوسة', 'landmark' => 'دوار الجمارك'],
            ['name' => 'عادل النابلسي',  'phone' => '0991234616', 'area' => 'كفرسوسة - البلد (المحطة القديمة / الجامع الكبير)', 'landmark' => 'الجامع الكبير'],
            ['name' => 'كريم الصيداوي', 'phone' => '0991234617', 'area' => 'حي اللوان',             'landmark' => 'نهاية حي اللوان'],

            // محور 5: الشمال الغربي (دمر وقدسيا)
            ['name' => 'إبراهيم محمود',  'phone' => '0991234618', 'area' => 'مشروع دمر (الجزيرة 1-6)', 'landmark' => 'الجزيرة الثالثة'],
            ['name' => 'ماهر الطويل',    'phone' => '0991234619', 'area' => 'مشروع دمر (الجزيرة 7-16)', 'landmark' => 'الجزيرة العاشرة'],
            ['name' => 'أنس الشيخ',      'phone' => '0991234620', 'area' => 'ضاحية قدسيا (السكن الشبابي)', 'landmark' => 'السكن الشبابي'],
            ['name' => 'غسان الحافظ',    'phone' => '0991234621', 'area' => 'الهامة',                'landmark' => 'مدخل الهامة'],

            // محور 6: الوسط والشرق
            ['name' => 'عامر الفقيه',    'phone' => '0991234622', 'area' => 'العمارة / باب السلام',  'landmark' => 'باب السلام'],
            ['name' => 'نبيل المحمد',    'phone' => '0991234623', 'area' => 'القصاع / التجارة',      'landmark' => 'سوق التجارة'],
            ['name' => 'مروان الجراح',   'phone' => '0991234624', 'area' => 'باب توما / الدويلعة',   'landmark' => 'باب توما'],
            ['name' => 'لؤي الحسن',      'phone' => '0991234625', 'area' => 'جرمانا',               'landmark' => 'دوار جرمانا'],

            // محور 7: الشمال والشمال الشرقي
            ['name' => 'سليمان الكيلاني','phone' => '0991234626', 'area' => 'مساكن برزة / مسبق الصنع', 'landmark' => 'مساكن برزة'],
            ['name' => 'فريد الأتاسي',   'phone' => '0991234627', 'area' => 'برزة البلد',            'landmark' => 'دوار برزة'],
            ['name' => 'صهيب الراعي',    'phone' => '0991234628', 'area' => 'عش الورور',             'landmark' => 'مقابل المدرسة'],

            // ── ركاب من محاور مجاورة — لاختبار fallback التوزيع ──
            ['name' => 'عماد الخير',     'phone' => '0991234629', 'area' => 'مشروع دمر (التراسات / الجزر الحديثة)', 'landmark' => 'التراسات الجديدة'],
        ];

        foreach ($passengers as $p) {
            $areaId = $areaIds[$p['area']] ?? null;
            Registration::create([
                'event_id'         => $event->id,
                'name'             => $p['name'],
                'phone'            => $p['phone'],
                'area'             => $p['area'],
                'area_id'          => $areaId,
                'nearest_landmark' => $p['landmark'],
                'has_car'          => false,
                'available_seats'  => null,
                'willing_to_drive' => false,
                'needs_ride'       => true,
            ]);
        }

        // ── أشخاص عندهم سيارة لكن مو مستعدين يوصّلوا ──
        $carNotDriving = [
            ['name' => 'هاني الأمين',    'phone' => '0991234640', 'area' => 'المزة - شيخ سعد',       'landmark' => 'شيخ سعد'],
            ['name' => 'راتب الشيخلي',   'phone' => '0991234641', 'area' => 'برزة البلد',             'landmark' => 'برزة البلد'],
        ];

        foreach ($carNotDriving as $c) {
            $areaId = $areaIds[$c['area']] ?? null;
            Registration::create([
                'event_id'         => $event->id,
                'name'             => $c['name'],
                'phone'            => $c['phone'],
                'area'             => $c['area'],
                'area_id'          => $areaId,
                'nearest_landmark' => $c['landmark'],
                'has_car'          => true,
                'available_seats'  => 2,
                'willing_to_drive' => false,
                'needs_ride'       => false,
            ]);
        }

        // ── أشخاص ما يحتاجون توصيل ──
        $noRide = [
            ['name' => 'حارث الموصلي',   'phone' => '0991234650', 'area' => 'القصاع / التجارة',      'landmark' => 'قرب القصاع'],
            ['name' => 'ضياء الانبار',    'phone' => '0991234651', 'area' => 'ميدان أبو حبل',         'landmark' => 'الميدان'],
        ];

        foreach ($noRide as $n) {
            $areaId = $areaIds[$n['area']] ?? null;
            Registration::create([
                'event_id'         => $event->id,
                'name'             => $n['name'],
                'phone'            => $n['phone'],
                'area'             => $n['area'],
                'area_id'          => $areaId,
                'nearest_landmark' => $n['landmark'],
                'has_car'          => false,
                'available_seats'  => null,
                'willing_to_drive' => false,
                'needs_ride'       => false,
            ]);
        }

        // ── Summary ──
        $total          = Registration::where('event_id', $event->id)->count();
        $driversCount   = Registration::where('event_id', $event->id)->where('has_car', true)->where('willing_to_drive', true)->count();
        $totalSeats     = Registration::where('event_id', $event->id)->eligibleDrivers()->sum('available_seats');
        $passengersCount= Registration::where('event_id', $event->id)->where('needs_ride', true)->count();
        $carNoDrive     = Registration::where('event_id', $event->id)->where('has_car', true)->where('willing_to_drive', false)->count();
        $noRideCount    = Registration::where('event_id', $event->id)->where('has_car', false)->where('needs_ride', false)->count();

        $this->command->info("═══════════════════════════════════════");
        $this->command->info("  ✅ تم إنشاء بيانات تجريبية بنجاح!");
        $this->command->info("═══════════════════════════════════════");
        $this->command->info("  📅 الفعالية: {$event->name} (ID: {$event->id})");
        $this->command->info("  👥 إجمالي المسجلين: {$total}");
        $this->command->info("  🚗 سائقين مستعدين: {$driversCount} ({$totalSeats} مقعد)");
        $this->command->info("  🚶 يحتاجون توصيل: {$passengersCount}");
        $this->command->info("  🚗 لديهم سيارة لكن غير مستعدين: {$carNoDrive}");
        $this->command->info("  🚶 لا يحتاجون توصيل: {$noRideCount}");
        $this->command->info("═══════════════════════════════════════");
        $this->command->info("  📌 جرّب الآن:");
        $this->command->info("  → admin/events/{$event->id}/rides");
        $this->command->info("  → اضغط '⚡ توزيع تلقائي'");
        $this->command->info("═══════════════════════════════════════");
    }
}
