<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Category;
use App\Models\City;
use App\Models\Company;
use App\Models\Quarry;
use App\Models\QuarryImage;
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
                if ($this->request->hasFile('images')) {
                    foreach ($this->request->file('images') as $file) {
                        $name = $this->uuidGenerator() . '.' . $file->getClientOriginalExtension();
                        $file_name = '/assets/images/quarries/'.$name;
                        Storage::disk('quarry')->put($name, File::get($file));
                        $images_data = [
                            'quarry_id' => $quarry->id,
                            'image' => $file_name
                        ];
                        QuarryImage::create($images_data);
                    }
                }
                DB::commit();
                return $this->jsonResponse('sucess', 200, [
                    'request' => $this->request->all(),
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->jsonResponse('failed', 500, $e->getMessage());
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

    public function data()
    {
        try {
            $data = Quarry::with(['company', 'category', 'city.province'])
                ->orderBy('id', 'DESC')
                ->get();
            return $this->basicDataTables($data);
        }catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }
}
