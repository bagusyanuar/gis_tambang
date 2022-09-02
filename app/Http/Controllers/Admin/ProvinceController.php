<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Province;

class ProvinceController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Province::all();
        return view('admin.province.index')->with(['data' => $data]);
    }

    public function add()
    {
        return view('admin.province.add');
    }
}
