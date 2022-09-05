<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;

class QuarryController extends CustomController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admin.quarry.index');
    }
}
