<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Category;
use App\Models\City;
use App\Models\Company;
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
        $categories = Category::all();
        $companies = Company::all();
        return view('admin.dashboard')->with(['quarries' => $c_quarries, 'cities' => $cities, 'categories' => $categories, 'companies' => count($companies)]);
    }

    public function geo_json_data()
    {
        try {
            $categories = $this->field('categories');
            $cities = $this->field('cities');
//            return $this->jsonResponse('success', 200, [
//                $categories, $cities
//            ]);
            $query = Quarry::with(['company', 'category', 'city']);
            if($categories !== null) {
                $query->whereIn('category_id', $categories);
            }

            if($cities !== null) {
                $query->whereIn('city_id', $cities);
            }
            $quarries = $query->get();
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
