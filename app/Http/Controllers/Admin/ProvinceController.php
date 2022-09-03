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
        if ($this->request->method() === 'POST') {
            try {
                $data = [
                    'name' => $this->postField('name')
                ];
                Province::create($data);
                return redirect()->back()->with('success', 'Berhasil Menambahkan Data...');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        return view('admin.province.add');
    }

    public function patch($id)
    {
        $data = Province::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $request = [
                    'name' => $this->postField('name')
                ];
                $data->update($request);
                return redirect('/admin/provinsi')->with('success', 'Berhasil Merubah Data...');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        return view('admin.province.edit')->with(['data' => $data]);
    }

    public function destroy($id)
    {
        try {
            Province::destroy($id);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('Terjadi Kesalahan Server...', 500);
        }
    }
}
