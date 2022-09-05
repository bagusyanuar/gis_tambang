<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Company;

class CompanyController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Company::all();
        return view('admin.company.index')->with(['data' => $data]);
    }

    public function add()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data = [
                    'name' => $this->postField('name'),
                    'phone' => $this->postField('phone'),
                ];
                Company::create($data);
                return redirect()->back()->with('success', 'Berhasil Menambahkan Data...');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        return view('admin.company.add');
    }

    public function patch($id)
    {
        $data = Company::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $request = [
                    'name' => $this->postField('name'),
                    'phone' => $this->postField('phone'),
                ];
                $data->update($request);
                return redirect('/admin/perusahaan')->with('success', 'Berhasil Merubah Data...');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        return view('admin.company.edit')->with(['data' => $data]);
    }

    public function destroy($id)
    {
        try {
            Company::destroy($id);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('Terjadi Kesalahan Server...', 500);
        }
    }
}
