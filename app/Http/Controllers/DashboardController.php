<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\City;
use App\Models\Quarry;

class DashboardController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $quarries = Quarry::all();
        $c_quarries = count($quarries);
        $cities = City::all();

        return view('admin.dashboard')->with(['quarries' => $c_quarries, 'cities' => $cities]);
    }

    public function geo_json_data()
    {
        try {
            $categories = $this->field('categories');
            return $this->jsonResponse('success', 200, $categories);
            $quarries = Quarry::with(['company', 'category', 'city'])
                ->get();
            $data = $quarries->map(function ($quarry) {
                return [
                    'type' => 'Feature',
                    'properties' => $quarry,
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [
                            $quarry->longitude,
                            $quarry->latitude
                        ]
                    ]
                ];
            });
            return $this->jsonResponse('success', 200, [
                'type' => 'FeatureCollection',
                'features' => $data
            ]);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }
}
