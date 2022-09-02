<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Province::insert(
            array(
                array('id' => '11','name' => 'ACEH', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '12','name' => 'SUMATERA UTARA', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '13','name' => 'SUMATERA BARAT', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '14','name' => 'RIAU', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '15','name' => 'JAMBI', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '16','name' => 'SUMATERA SELATAN', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '17','name' => 'BENGKULU', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '18','name' => 'LAMPUNG', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '19','name' => 'KEPULAUAN BANGKA BELITUNG', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '21','name' => 'KEPULAUAN RIAU', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '31','name' => 'DKI JAKARTA', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '32','name' => 'JAWA BARAT', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '33','name' => 'JAWA TENGAH', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '34','name' => 'DI YOGYAKARTA', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '35','name' => 'JAWA TIMUR', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '36','name' => 'BANTEN', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '51','name' => 'BALI', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '52','name' => 'NUSA TENGGARA BARAT', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '53','name' => 'NUSA TENGGARA TIMUR', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '61','name' => 'KALIMANTAN BARAT', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '62','name' => 'KALIMANTAN TENGAH', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '63','name' => 'KALIMANTAN SELATAN', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '64','name' => 'KALIMANTAN TIMUR', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '65','name' => 'KALIMANTAN UTARA', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '71','name' => 'SULAWESI UTARA', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '72','name' => 'SULAWESI TENGAH', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '73','name' => 'SULAWESI SELATAN', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '74','name' => 'SULAWESI TENGGARA', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '75','name' => 'GORONTALO', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '76','name' => 'SULAWESI BARAT', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '81','name' => 'MALUKU', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '82','name' => 'MALUKU UTARA', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '91','name' => 'PAPUA BARAT', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')),
                array('id' => '94','name' => 'PAPUA', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'))
            )
        );
    }
}
