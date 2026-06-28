<?php

namespace Database\Factories;

use App\Models\LoanRequest;
use App\Models\MuseumItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanRequestFactory extends Factory
{
    protected $model = LoanRequest::class;

    public function definition(): array
    {
        $status = ['Pending', 'Approved', 'Rejected'];
        $selectedStatus = fake()->randomElement($status);

        $tanggalMulai = fake()->dateTimeBetween('+1 week', '+1 month');
        $tanggalSelesai = fake()->dateTimeBetween($tanggalMulai, $tanggalMulai->format('Y-m-d') . ' +14 days');

        $approvedBy = null;
        $approvedAt = null;

        if ($selectedStatus !== 'Pending') {
            // Kita cari user staff nanti di seeder atau buat baru
            $approvedAt = fake()->dateTimeBetween('now', '+3 days');
        }

        return [
            'museum_item_id' => MuseumItem::factory(),
            'user_id' => User::factory()->state(['role' => 'panitia']),
            'nama_acara' => 'Pameran Seni ' . fake()->company(),
            'lokasi' => 'Gedung Serbaguna ' . fake()->city(),
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'status' => $selectedStatus,
            'approved_by' => $approvedBy,
            'approved_at' => $approvedAt,
            'catatan' => $selectedStatus === 'Rejected' ? fake()->sentence() : null,
        ];
    }
}
