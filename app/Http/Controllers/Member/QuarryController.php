<?php


namespace App\Http\Controllers\Member;


use App\Helper\CustomController;
use App\Models\Quarry;

class QuarryController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function show($id)
    {
        $data = Quarry::with(['company', 'category', 'city', 'images'])->findOrFail($id);
        return view('member.quarry.detail')->with(['data' => $data]);
    }
}
