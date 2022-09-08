<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Category;
use App\Models\City;
use App\Models\Company;
use App\Models\Quarry;

class QuarryController extends CustomController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Quarry::with(['company', 'category', 'city'])
            ->orderBy('id', 'DESC')
            ->get();
        return view('admin.quarry.index')->with(['data' => $data]);
    }

    public function add()
    {
        $cities = City::all();
        $categories = Category::all();
        $companies = Company::all();
        return view('admin.quarry.add')->with([
            'cities' => $cities,
            'categories' => $categories,
            'companies' => $companies,
        ]);
    }
}
