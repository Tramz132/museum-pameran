<?php

namespace Database\Factories;

use App\Models\MuseumItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class MuseumItemFactory extends Factory
{
    protected $model = MuseumItem::class;

    public function definition(): array
    {
        $kategori = ['Arkeologi', 'Etnografi', 'Senjata Tradisional', 'Naskah Kuno', 'Seni Rupa', 'Keramik'];
        $asal = ['Jawa Tengah', 'Bali', 'Sumatra Barat', 'Sulawesi Selatan', 'Kalimantan Timur', 'Maluku', 'Aceh'];
        $status = ['Tersedia', 'Dipinjam', 'Perbaikan'];

        return [
            'nama_barang' => fake()->words(3, true),
            'kode_barang' => 'MUS-' . fake()->unique()->numberBetween(1000, 9999),
            'kategori' => fake()->randomElement($kategori),
            'asal' => fake()->randomElement($asal),
            'tahun' => fake()->numberBetween(1400, 1950) . ' Masehi',
            'deskripsi' => fake()->paragraph(),
            'foto' => null, // default null, nanti diupload manual atau seeder isi path default
            'status' => fake()->randomElement($status),
        ];
    }
}
