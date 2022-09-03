<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\City;
use App\Models\Province;

class CityController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = City::with('province')->orderBy('province_id', 'ASC')->get();
        return view('admin.city.index')->with(['data' => $data]);
    }

    public function add()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data = [
                    'province_id' => $this->postField('province'),
                    'name' => $this->postField('name'),
                ];
                City::create($data);
                return redirect()->back()->with('success', 'Berhasil Menambahkan Data...');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        $provinces = Province::all();
        return view('admin.city.add')->with(['provinces' => $provinces]);
    }

    public function patch($id)
    {
        $data = City::with('province')->findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $request = [
                    'province_id' => $this->postField('province'),
                    'name' => $this->postField('name')
                ];
                $data->update($request);
                return redirect('/admin/kota')->with('success', 'Berhasil Merubah Data...');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        $provinces = Province::all();
        return view('admin.kota.edit')->with(['data' => $data, 'provinces' => $provinces]);
    }
}
