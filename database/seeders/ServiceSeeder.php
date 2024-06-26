<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    protected array $services = [
        [
            'title' => 'Periksa Kehamilan',
            'description' => 'Pemeriksaan rutin untuk memantau kesehatan ibu dan janin. Termasuk pemeriksaan tekanan darah, berat badan, detak jantung janin, dan pemeriksaan fisik umum.',
            'price' => 200000,
        ],
        [
            'title' => 'Suntik Keluarga Berencana',
            'description' => 'Layanan kontrasepsi suntik untuk mencegah kehamilan. Termasuk konseling sebelum dan sesudah penyuntikan.',
            'price' => 150000,
        ],
        [
            'title' => 'Imunisasi',
            'description' => 'Pemberian vaksin untuk bayi dan anak-anak untuk mencegah berbagai penyakit',
            'price' => 150000,
        ],
        [
            'title' => 'Persalinan',
            'description' => 'Layanan persalinan yang mencakup persalinan normal. Termasuk pemeriksaan pra-persalinan, tindakan persalinan, dan perawatan harga persalinan',
            'price' => 2500000,
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->services as $service) {
            Service::factory()->create([
                'title' => $service['title'],
                'description' => $service['description'],
                'price' => $service['price'],
            ]);
        }
    }
}
