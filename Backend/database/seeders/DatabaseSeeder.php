<?php

namespace Database\Seeders;

use App\Models\LoanRequest;
use App\Models\MuseumItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users
        $admin = User::create([
            'name' => 'Administrator Museum',
            'email' => 'admin@museum.id',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);

        $staff = User::create([
            'name' => 'Staf Kurator',
            'email' => 'staff@museum.id',
            'password' => Hash::make('12345678'),
            'role' => 'staff',
        ]);

        $panitia = User::create([
            'name' => 'Panitia Pameran',
            'email' => 'panitia@museum.id',
            'password' => Hash::make('12345678'),
            'role' => 'panitia',
        ]);

        // Tambahan Panitia lain untuk variasi data
        $panitia2 = User::create([
            'name' => 'Panitia Festival Seni',
            'email' => 'panitia2@museum.id',
            'password' => Hash::make('12345678'),
            'role' => 'panitia',
        ]);

        // 2. Seed Museum Items (Minimal 10 data spesifik)
        $itemsData = [
            [
                'nama_barang' => 'Keris Pusaka Singosari',
                'kode_barang' => 'MUS-1001',
                'kategori' => 'Senjata Tradisional',
                'asal' => 'Jawa Timur',
                'tahun' => 'Abad ke-13',
                'deskripsi' => 'Keris pusaka peninggalan era Kerajaan Singasari dengan pamor ngulit semangka melambangkan perlindungan.',
                'status' => 'Dipinjam', // Akan dicocokkan dengan loan request approved
            ],
            [
                'nama_barang' => 'Arca Ganesha Perunggu',
                'kode_barang' => 'MUS-1002',
                'kategori' => 'Arkeologi',
                'asal' => 'Jawa Tengah',
                'tahun' => 'Abad ke-9',
                'deskripsi' => 'Arca Ganesha berbahan perunggu yang menggambarkan dewa kebijaksanaan dan pengetahuan.',
                'status' => 'Tersedia',
            ],
            [
                'nama_barang' => 'Mahkota Kerajaan Gowa (Saloko)',
                'kode_barang' => 'MUS-1003',
                'kategori' => 'Atribut Kerajaan',
                'asal' => 'Sulawesi Selatan',
                'tahun' => 'Abad ke-16',
                'deskripsi' => 'Mahkota emas murni berhias berlian dan permata, lambang kekuasaan tertinggi Raja Gowa.',
                'status' => 'Dipinjam', // Akan dicocokkan dengan loan request approved
            ],
            [
                'nama_barang' => 'Prasasti Batu Tulis Tarumanegara',
                'kode_barang' => 'MUS-1004',
                'kategori' => 'Arkeologi',
                'asal' => 'Jawa Barat',
                'tahun' => 'Abad ke-5',
                'deskripsi' => 'Replika prasasti batu tapak kaki Raja Purnawarman dengan aksara Pallawa dan bahasa Sanskerta.',
                'status' => 'Tersedia',
            ],
            [
                'nama_barang' => 'Wayang Kulit Tokoh Arjuna',
                'kode_barang' => 'MUS-1005',
                'kategori' => 'Seni Kriya',
                'asal' => 'Yogyakarta',
                'tahun' => 'Tahun 1850',
                'deskripsi' => 'Wayang kulit purwa tokoh Arjuna berhiaskan prada emas asli peninggalan Keraton Yogyakarta.',
                'status' => 'Tersedia',
            ],
            [
                'nama_barang' => 'Gamelan Jawa Laras Slendro',
                'kode_barang' => 'MUS-1006',
                'kategori' => 'Alat Musik',
                'asal' => 'Jawa Tengah',
                'tahun' => 'Tahun 1910',
                'deskripsi' => 'Satu set gamelan perunggu lengkap berlaras slendro buatan perajin legendaris Surakarta.',
                'status' => 'Perbaikan',
            ],
            [
                'nama_barang' => 'Topeng Barong Bali Kuno',
                'kode_barang' => 'MUS-1007',
                'kategori' => 'Etnografi',
                'asal' => 'Bali',
                'tahun' => 'Tahun 1920',
                'deskripsi' => 'Topeng Barong ket sakral yang diukir dari kayu khusus dan dihiasi bulu serat tumbuhan alami.',
                'status' => 'Tersedia',
            ],
            [
                'nama_barang' => 'Naskah Kuno Negarakertagama',
                'kode_barang' => 'MUS-1008',
                'kategori' => 'Naskah Kuno',
                'asal' => 'Jawa Timur',
                'tahun' => 'Abad ke-14',
                'deskripsi' => 'Salinan daun lontar naskah sejarah tulisan Empu Prapanca tentang kemegahan Kerajaan Majapahit.',
                'status' => 'Perbaikan',
            ],
            [
                'nama_barang' => 'Meriam Portugis Si Jagur',
                'kode_barang' => 'MUS-1009',
                'kategori' => 'Senjata Bersejarah',
                'asal' => 'Malaka / Jakarta',
                'tahun' => 'Abad ke-16',
                'deskripsi' => 'Meriam perunggu besar dengan lambang kepalan tangan khas "mano in fica" di bagian belakang.',
                'status' => 'Tersedia',
            ],
            [
                'nama_barang' => 'Patung Buddha Candi Borobudur',
                'kode_barang' => 'MUS-1010',
                'kategori' => 'Arkeologi',
                'asal' => 'Jawa Tengah',
                'tahun' => 'Abad ke-9',
                'deskripsi' => 'Patung Buddha berbahan batu andesit dalam posisi dhyani mudra (semadi).',
                'status' => 'Tersedia',
            ],
        ];

        $items = [];
        foreach ($itemsData as $data) {
            $items[$data['kode_barang']] = MuseumItem::create($data);
        }

        // 3. Seed Loan Requests (Minimal 5 data dengan variasi status)
        // Request 1: Approved (Keris Pusaka Singosari)
        LoanRequest::create([
            'museum_item_id' => $items['MUS-1001']->id,
            'user_id' => $panitia->id,
            'nama_acara' => 'Pameran Pusaka Nusantara 2026',
            'lokasi' => 'Gedung Agung Yogyakarta',
            'tanggal_mulai' => Carbon::now()->addDays(5)->toDateString(),
            'tanggal_selesai' => Carbon::now()->addDays(12)->toDateString(),
            'status' => 'Approved',
            'approved_by' => $staff->id,
            'approved_at' => Carbon::now()->subDays(2),
            'catatan' => 'Barang dalam kondisi prima, asuransi telah disetujui.',
        ]);

        // Request 2: Approved (Mahkota Gowa)
        LoanRequest::create([
            'museum_item_id' => $items['MUS-1003']->id,
            'user_id' => $panitia2->id,
            'nama_acara' => 'Exhibition Mahkota Kerajaan Seluruh Indonesia',
            'lokasi' => 'Museum Nasional Jakarta',
            'tanggal_mulai' => Carbon::now()->addDays(10)->toDateString(),
            'tanggal_selesai' => Carbon::now()->addDays(20)->toDateString(),
            'status' => 'Approved',
            'approved_by' => $staff->id,
            'approved_at' => Carbon::now()->subDays(1),
            'catatan' => 'Wajib dengan pengawalan ketat kepolisian.',
        ]);

        // Request 3: Pending (Arca Ganesha)
        LoanRequest::create([
            'museum_item_id' => $items['MUS-1002']->id,
            'user_id' => $panitia->id,
            'nama_acara' => 'Pameran Arkeologi & Peradaban Kuno',
            'lokasi' => 'Museum Benteng Vredeburg',
            'tanggal_mulai' => Carbon::now()->addDays(15)->toDateString(),
            'tanggal_selesai' => Carbon::now()->addDays(25)->toDateString(),
            'status' => 'Pending',
            'approved_by' => null,
            'approved_at' => null,
            'catatan' => null,
        ]);

        // Request 4: Rejected (Patung Buddha Borobudur)
        LoanRequest::create([
            'museum_item_id' => $items['MUS-1010']->id,
            'user_id' => $panitia2->id,
            'nama_acara' => 'Festival Budaya Internasional Bali',
            'lokasi' => 'Art Center Denpasar',
            'tanggal_mulai' => Carbon::now()->addDays(20)->toDateString(),
            'tanggal_selesai' => Carbon::now()->addDays(30)->toDateString(),
            'status' => 'Rejected',
            'approved_by' => $staff->id,
            'approved_at' => Carbon::now()->subDays(3),
            'catatan' => 'Patung andesit terlalu berat dan rawan retak jika dikirim jarak jauh.',
        ]);

        // Request 5: Pending (Topeng Barong Bali Kuno)
        LoanRequest::create([
            'museum_item_id' => $items['MUS-1007']->id,
            'user_id' => $panitia->id,
            'nama_acara' => 'Pementasan Budaya & Eksibisi Topeng',
            'lokasi' => 'Taman Ismail Marzuki Jakarta',
            'tanggal_mulai' => Carbon::now()->addDays(30)->toDateString(),
            'tanggal_selesai' => Carbon::now()->addDays(35)->toDateString(),
            'status' => 'Pending',
            'approved_by' => null,
            'approved_at' => null,
            'catatan' => null,
        ]);
    }
}
