<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\SubService;
use App\Models\ServiceProviderOffering;

$services = SubService::all();
$groups = [];
foreach ($services as $s) {
    $lower = strtolower(trim($s->service_name));
    if (!isset($groups[$lower])) {
        $groups[$lower] = [];
    }
    $groups[$lower][] = $s;
}

foreach ($groups as $name => $subs) {
    if (count($subs) > 1) {
        $primary = $subs[0];
        
        for ($i = 1; $i < count($subs); $i++) {
            $duplicate = $subs[$i];
            
            $offerings = ServiceProviderOffering::where('sub_service_id', $duplicate->id)->get();
            foreach ($offerings as $offering) {
                $exists = ServiceProviderOffering::where('sub_service_id', $primary->id)
                            ->where('service_provider_id', $offering->service_provider_id)
                            ->exists();
                if (!$exists) {
                    $offering->update(['sub_service_id' => $primary->id]);
                } else {
                    $offering->delete(); // Avoid constraints
                }
            }
            $duplicate->delete();
        }
    }
}
echo "Done!\n";
