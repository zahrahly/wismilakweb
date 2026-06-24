<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Event;
use App\Models\UserPoint;
use App\Models\CustomerProfile;
use App\Models\PartnerProfile;
use App\Models\AdminProfile;
use App\Models\Outlet;
use App\Models\Voucher;
use App\Models\VoucherRedemption;
use App\Models\EventRegistration;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\Reward;
use App\Models\PointHistory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── ROLES ────────────────────────────────────────────
        $roles = [];
        foreach (['admin', 'manager', 'partner', 'customer'] as $name) {
            $roles[$name] = Role::firstOrCreate(['name' => $name]);
        }

        // ── USERS ────────────────────────────────────────────
        $admin = User::firstOrCreate(
            ['email' => 'admin@wismilak.com'],
            ['name' => 'Admin Wismilak', 'role_id' => $roles['admin']->id, 'password' => Hash::make('password'), 'status' => 'active']
        );
        AdminProfile::firstOrCreate(['user_id' => $admin->id], ['department' => 'Management', 'phone' => '081234000000']);

        $manager = User::firstOrCreate(
            ['email' => 'manager@wismilak.com'],
            ['name' => 'Manager Wismilak', 'role_id' => $roles['manager']->id, 'password' => Hash::make('password'), 'status' => 'active']
        );

        // Partners
        $partners = [
            ['name'=>'PT Nusantara Tobacco', 'email'=>'partner@nusantara.com',  'company'=>'PT Nusantara Tobacco', 'city'=>'Surabaya'],
            ['name'=>'Cigar House Jakarta',  'email'=>'partner@cigarhouse.com', 'company'=>'Cigar House Jakarta', 'city'=>'Jakarta'],
        ];
        $partnerUsers = [];
        foreach ($partners as $p) {
            $pu = User::firstOrCreate(
                ['email' => $p['email']],
                ['name' => $p['name'], 'role_id' => $roles['partner']->id, 'password' => Hash::make('password'), 'status' => 'active']
            );
            PartnerProfile::firstOrCreate(['user_id' => $pu->id], ['company_name' => $p['company'], 'contact_person' => $p['name'], 'phone' => '0812340000' . rand(10,99)]);
            $partnerUsers[] = $pu;
        }

        // Customers
        $customerData = [
            ['name'=>'Budi Santoso',     'email'=>'budi@example.com',    'city'=>'Jakarta',   'gender'=>'male',   'points'=>350],
            ['name'=>'Dewi Rahayu',      'email'=>'dewi@example.com',    'city'=>'Bandung',   'gender'=>'female', 'points'=>120],
            ['name'=>'Ahmad Rizki',      'email'=>'ahmad@example.com',   'city'=>'Surabaya',  'gender'=>'male',   'points'=>580],
            ['name'=>'Siti Nurhaliza',   'email'=>'siti@example.com',    'city'=>'Medan',     'gender'=>'female', 'points'=>240],
            ['name'=>'Eko Prasetyo',     'email'=>'eko@example.com',     'city'=>'Yogyakarta','gender'=>'male',   'points'=>90],
            ['name'=>'Customer Test',    'email'=>'customer@example.com','city'=>'Jakarta',   'gender'=>'male',   'points'=>200],
        ];
        $customers = [];
        foreach ($customerData as $cd) {
            $cu = User::firstOrCreate(
                ['email' => $cd['email']],
                ['name' => $cd['name'], 'role_id' => $roles['customer']->id, 'password' => Hash::make('password'), 'status' => 'active']
            );
            CustomerProfile::firstOrCreate(['user_id' => $cu->id], [
                'phone' => '0812' . rand(10000000, 99999999),
                'date_of_birth' => now()->subYears(rand(25, 50))->format('Y-m-d'),
                'city'   => $cd['city'],
                'gender' => $cd['gender'],
            ]);
            UserPoint::firstOrCreate(['user_id' => $cu->id], ['total_points' => $cd['points']]);
            $customers[] = $cu;
        }

        // ── OUTLETS ──────────────────────────────────────────
        $outletData = [
            ['Jakarta',     'Sudirman Premium Lounge',  'Jl. Jend. Sudirman No. 1', -6.2088, 106.8456],
            ['Jakarta',     'Senayan Cigar Gallery',    'Plaza Senayan Lt. 2',       -6.2184, 106.7980],
            ['Surabaya',    'Tunjungan Cigar Lounge',   'Jl. Tunjungan No. 12',     -7.2575, 112.7378],
            ['Bandung',     'Braga Tobacco House',      'Jl. Braga No. 45',          -6.9175, 107.6191],
            ['Bali',        'Seminyak Premium Lounge',  'Jl. Kayu Aya No. 8',        -8.6906, 115.1576],
            ['Medan',       'Simalungun Cigars',        'Jl. Gatot Subroto No. 21', 3.5952,  98.6722],
            ['Yogyakarta',  'Malioboro Cigar House',    'Jl. Malioboro No. 77',     -7.7956, 110.3695],
        ];
        foreach ($outletData as [$city, $name, $address, $lat, $lng]) {
            Outlet::firstOrCreate(['name' => $name], [
                'city'      => $city,
                'region'    => $city,
                'address'   => $address,
                'latitude'  => $lat,
                'longitude' => $lng,
                'status'    => 'active',
                'phone'     => '021' . rand(1000000, 9999999),
            ]);
        }

        // ── VOUCHERS ─────────────────────────────────────────
        // Vouchers — columns: code,title,discount_type,discount_value,min_purchase,max_uses,used_count,points_required,valid_until,status
        $voucherData = [
            ['WELCOME10', 'Selamat Datang',     100, 'percentage', 10,    0,    50,],
            ['DISC50K',   'Diskon 50K',         200, 'fixed',      50000, 0,    30,],
            ['EVENT20',   'Event Discount 20%', 300, 'percentage', 20,    0,    20,],
            ['PREMIUM15', 'Premium Member 15%', 500, 'percentage', 15,    0,    10,],
            ['FIRST100K', 'First Event 100K',   150, 'fixed',      100000,0,    25,],
        ];
        $vouchers = [];
        foreach ($voucherData as [$code, $title, $pts, $type, $val, $minP, $maxU]) {
            $vouchers[] = Voucher::firstOrCreate(['code' => $code], [
                'title'           => $title,
                'points_required' => $pts,
                'discount_type'   => $type,
                'discount_value'  => $val,
                'min_purchase'    => $minP,
                'max_uses'        => $maxU,
                'used_count'      => 0,
                'status'          => 'active',
                'valid_until'     => now()->addMonths(3)->format('Y-m-d'),
            ]);
        }

        // ── REWARDS ──────────────────────────────────────────
        $rewardData = [
            ['Cigar Cutter Premium',   500,  10, 'Gunting cerutu premium stainless steel grade.'],
            ['Tobacco Humidor Box',    1200, 5,  'Kotak penyimpanan cerutu kapasitas 20 pcs.'],
            ['Exclusive Wismilak Mug', 300,  30, 'Mug keramik edisi terbatas Wismilak Premium.'],
            ['Event VIP Pass',         800,  15, 'Akses VIP untuk event eksklusif Wismilak.'],
            ['Gold Membership',        2000, 3,  'Upgrade ke membership gold selama 1 tahun.'],
        ];
        $rewards = [];
        foreach ($rewardData as [$title, $pts, $stock, $desc]) {
            $rewards[] = Reward::firstOrCreate(['title' => $title], [
                'points_required' => $pts,
                'stock'           => $stock,
                'description'     => $desc,
                'status'          => 'active',
            ]);
        }

        // ── EVENTS ───────────────────────────────────────────
        $eventData = [
            [
                'title'       => 'Wismilak Premium Cigar Evening',
                'description' => 'An exclusive evening of premium cigars, whiskey pairing, and jazz music.',
                'date'        => now()->addDays(30),
                'location'    => 'Grand Ballroom Hotel Indonesia, Jakarta',
                'quota'       => 100, 'price_type' => 'paid', 'price' => 250000,
                'status'      => 'published', 'created_by' => $admin->id,
            ],
            [
                'title'       => 'Tobacco Masterclass Surabaya',
                'description' => 'Pelajari seni menikmati cerutu premium bersama master tobacconist.',
                'date'        => now()->addDays(15),
                'location'    => 'Surabaya Convention Center',
                'quota'       => 50, 'price_type' => 'paid', 'price' => 150000,
                'status'      => 'published', 'created_by' => $partnerUsers[0]->id,
            ],
            [
                'title'       => 'Free Wismilak Tasting Session',
                'description' => 'Sesi tasting gratis untuk memperkenalkan lini premium terbaru.',
                'date'        => now()->addDays(7),
                'location'    => 'Wismilak Lounge, Bandung',
                'quota'       => 30, 'price_type' => 'free', 'price' => 0,
                'status'      => 'published', 'created_by' => $admin->id,
            ],
            [
                'title'       => 'Bali Sunset Cigar Experience',
                'description' => 'Nikmati cerutu premium sambil menyaksikan sunset di Seminyak.',
                'date'        => now()->addDays(45),
                'location'    => 'Seminyak Beach Club, Bali',
                'quota'       => 40, 'price_type' => 'paid', 'price' => 350000,
                'status'      => 'published', 'created_by' => $partnerUsers[1]->id,
            ],
            [
                'title'       => 'Partner Event (Pending Approval)',
                'description' => 'Event yang sedang menunggu persetujuan admin.',
                'date'        => now()->addDays(60),
                'location'    => 'Jakarta Convention Center',
                'quota'       => 80, 'price_type' => 'paid', 'price' => 200000,
                'status'      => 'pending', 'created_by' => $partnerUsers[0]->id,
            ],
        ];

        $events = [];
        foreach ($eventData as $ed) {
            $ed['remaining_quota'] = $ed['quota'];
            $ed['verification_status'] = in_array($ed['status'], ['published']) ? 'approved' : 'pending';
            if (!isset($ed['image'])) $ed['image'] = null;
            $events[] = Event::firstOrCreate(['title' => $ed['title']], $ed);
        }

        // ── EVENT REGISTRATIONS & TICKETS ────────────────────
        foreach ([$customers[0], $customers[2], $customers[5]] as $i => $customer) {
            $event = $events[0]; // Premium Cigar Evening

            $existing = EventRegistration::where('event_id', $event->id)->where('user_id', $customer->id)->first();
            if ($existing) continue;

            $reg = EventRegistration::create([
                'event_id'       => $event->id,
                'user_id'        => $customer->id,
                'quantity'       => 1,
                'ticket_price'   => $event->price,
                'total_amount'   => $event->price,
                'payment_status' => 'paid',
                'expired_at'     => now()->addDays(30),
            ]);

            // Transaction
            Transaction::create([
                'user_id'          => $customer->id,
                'registration_id'  => $reg->id,
                'amount'           => $event->price,
                'payment_method'   => 'midtrans',
                'transaction_code' => 'TRX-' . strtoupper(Str::random(8)),
                'status'           => 'paid',
                'paid_at'          => now()->subDays($i + 1),
            ]);

            // Ticket
            Ticket::firstOrCreate(
                ['event_registration_id' => $reg->id],
                [
                    'ticket_number' => 'TCK-' . strtoupper(Str::random(10)),
                    'user_id'       => $customer->id,
                    'event_id'      => $event->id,
                    'status'        => 'active',
                ]
            );

            // Point History
            PointHistory::create([
                'user_id'      => $customer->id,
                'points'       => 10,
                'type'         => 'earn',
                'source'       => 'event_registration',
                'reference_id' => $reg->id,
                'description'  => 'Tiket event: ' . $event->title,
            ]);
        }

        // Free event registration
        $freeEvent = $events[2];
        foreach ([$customers[1], $customers[3]] as $customer) {
            $existing = EventRegistration::where('event_id', $freeEvent->id)->where('user_id', $customer->id)->first();
            if ($existing) continue;

            $reg = EventRegistration::create([
                'event_id'       => $freeEvent->id,
                'user_id'        => $customer->id,
                'quantity'       => 1,
                'ticket_price'   => 0,
                'total_amount'   => 0,
                'payment_status' => 'paid',
                'expired_at'     => now()->addDays(7),
            ]);

            Ticket::firstOrCreate(
                ['event_registration_id' => $reg->id],
                [
                    'ticket_number' => 'TCK-' . strtoupper(Str::random(10)),
                    'user_id'       => $customer->id,
                    'event_id'      => $freeEvent->id,
                    'status'        => 'active',
                ]
            );
        }

        // Voucher Redemption for customer[0]
        if ($customers[0] && $vouchers[0]) {
            VoucherRedemption::firstOrCreate(
                ['user_id' => $customers[0]->id, 'voucher_id' => $vouchers[0]->id],
                [
                    'points_spent' => $vouchers[0]->points_required,
                    'voucher_code' => 'VCH-' . strtoupper(Str::random(8)),
                    'status'       => 'unused',
                    'redeemed_at'  => now()->subDays(5),
                    'expired_at'   => now()->addDays(25),
                ]
            );
        }

        $this->command->info('✅ Database seeded successfully with comprehensive test data!');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin',    'admin@wismilak.com',    'password'],
                ['Manager',  'manager@wismilak.com',  'password'],
                ['Partner',  'partner@nusantara.com', 'password'],
                ['Partner',  'partner@cigarhouse.com','password'],
                ['Customer', 'customer@example.com',  'password'],
                ['Customer', 'budi@example.com',      'password'],
            ]
        );
    }
}
