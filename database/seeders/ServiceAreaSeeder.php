<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceArea;

class ServiceAreaSeeder extends Seeder
{
    public function run()
    {
        $regionData = [
            'Dhaka' => ['Mirpur', 'Dhanmondi', 'Uttara', 'Gulshan', 'Banani', 'Mohammadpur', 'Tejgaon', 'Motijheel', 'Paltan', 'Savar', 'Keraniganj', 'Dohar'],
            'Chittagong' => ["Cox's Bazar", 'Panchlaish', 'Halishahar', 'Pahartali', 'Chandgaon', 'Sitakunda', 'Rangunia', 'Sandwip', 'Mirsharai', 'Boalkhali'],
            'Sylhet' => ['Zindabazar', 'Amberkhana', 'Tilagor', 'Noyashahar', 'Kumarpara', 'Moglabazar', 'Gowainghat', 'Beanibazar', 'Balaganj', 'Fenchuganj'],
            'Barisal' => ['Sadatpur', 'Amtali', 'Agailjhara', 'Babuganj', 'Bakerganj', 'Banaripara', 'Gournadi', 'Hizla', 'Mehendiganj', 'Muladi', 'Wazirpur'],
            'Rangpur' => ['Modern More', 'Kaunia', 'Gangachara', 'Pirgachha', 'Badarganj', 'Mithapukur', 'Pirganj', 'Rangpur Sadar', 'Taraganj', 'Pirgachha'],
            'Rajshahi' => ['Motihar', 'Boalia', 'Paba', 'Durgapur', 'Bagha', 'Bagmara', 'Charghat', 'Godagari', 'Tanore', 'Puthia', 'Mohonpur'],
            'Khulna' => ['Boyra', 'Khalishpur', 'Sonadanga', 'Daulatpur', 'Dumuria', 'Dighalia', 'Batiaghata', 'Phultala', 'Rupsha', 'Terokhada', 'Paikgachha']
        ];

        foreach ($regionData as $city => $areas) {
            foreach ($areas as $area) {
                ServiceArea::firstOrCreate([
                    'city_name' => $city,
                    'area_name' => $area
                ]);
            }
        }
    }
}