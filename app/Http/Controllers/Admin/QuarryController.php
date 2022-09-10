<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Category;
use App\Models\City;
use App\Models\Company;
use App\Models\Quarry;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
            DB::beginTransaction();
            try {
                $request = [
                    'company_id' => $this->postField('company'),
                    'category_id' => $this->postField('category'),
                    'city_id' => $this->postField('city'),
                    'large' => $this->postField('large'),
                    'permission' => $this->postField('permission'),
                    'address' => $this->postField('address'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                ];
                $quarry = Quarry::create($request);
                if ($this->request->hasFile('file')) {
                    foreach ($this->request->file('file') as $file) {
                        $name = $this->uuidGenerator() . '.' . $file->getClientOriginalExtension();
                        Storage::disk('quarry')->put($name, File::get($file));
                    }
                }
                DB::commit();
                return redirect()->back()->with('success', 'Berhasil Menambahkan Data..');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('failed', $e->getMessage());
            }

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
