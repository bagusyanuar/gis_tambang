<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Category;

class CategoryController extends CustomController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Category::all();
        return view('admin.category.index')->with(['data' => $data]);
    }

    public function add()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data = [
                    'name' => $this->postField('name')
                ];
                Category::create($data);
                return redirect()->back()->with('success', 'Berhasil Menambahkan Data...');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        return view('admin.category.add');
    }

    public function patch($id)
    {
        $data = Category::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $request = [
                    'name' => $this->postField('name')
                ];
                $data->update($request);
                return redirect('/admin/jenis')->with('success', 'Berhasil Merubah Data...');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        return view('admin.category.edit')->with(['data' => $data]);
    }

    public function destroy($id)
    {
        try {
            Category::destroy($id);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('Terjadi Kesalahan Server...', 500);
        }
    }
}
