<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = User::whereJsonContains('roles', 'admin')->get();
        return view('admin.admin.index')->with(['data' => $data]);
    }

    public function add()
    {
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                $user_data = [
                    'username' => $this->postField('username'),
                    'password' => Hash::make($this->postField('password')),
                    'roles' => ['member']
                ];
                User::create($user_data);
                DB::commit();
                return redirect()->back()->with('success', 'Berhasil Menambahkan Data...');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        return view('admin.admin.add');
    }

    public function patch($id)
    {
        $data = User::whereJsonContains('roles', 'admin')->where('id','=', $id)->firstOrFail();
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                $data->update([
                    'username' => $this->postField('username')
                ]);
                DB::commit();
                return redirect('/admin/admin')->with('success', 'Berhasil Merubah Data...');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        return view('admin.admin.edit')->with(['data' => $data]);
    }

    public function change_password($id)
    {
        $data = User::whereJsonContains('roles', 'admin')->where('id','=', $id)->firstOrFail();
        if ($this->request->method() === 'POST') {
            try {
                $data->update([
                    'password' => Hash::make($this->postField('password'))
                ]);
                return redirect('/admin/admin')->with('success', 'Berhasil Mengganti Password...');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        return view('admin.admin.change-password')->with(['data' => $data]);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            User::destroy($id);
            DB::commit();
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonResponse('Terjadi Kesalahan Server...', 500);
        }
    }
}
