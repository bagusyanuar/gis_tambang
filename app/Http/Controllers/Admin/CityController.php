<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\City;

class CityController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = City::with('province')->get();
        return view('admin.city.index')->with(['data' => $data]);
    }
}
