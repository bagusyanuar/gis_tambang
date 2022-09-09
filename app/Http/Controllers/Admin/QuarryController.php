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
        if ($this->request->method() === 'POST') {
            dd($this->request->all());
        }
        $cities = City::all();
        $categories = Category::all();
        $companies = Company::all();
        return view('admin.quarry.add')->with([
            'cities' => $cities,
            'categories' => $categories,
            'companies' => $companies,
        ]);
    }

    public function store_tmp_media()
    {
        $path = storage_path('tmp/uploads');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $file = $this->request->file('file');
        $name = uniqid() . '_' . trim($file->getClientOriginalName());
        $file->move($path, $name);

        return response()->json([
            'name' => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }
}
