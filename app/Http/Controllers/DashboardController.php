<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
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
        return view('admin.dashboard')->with(['quarries' => $c_quarries]);
    }
}
