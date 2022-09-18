<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MemberController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Member::with('user')->get();
        return view('admin.member.index')->with(['data' => $data]);
    }

    public function add()
    {
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                $user_data = [
                    'username' => $this->postField('username'),
                    'password' => Hash::make($this->postField('username')),
                    'roles' => ['member']
                ];
                $user = User::create($user_data);
                $data = [
                    'user_id' => $user->id,
                    'name' => $this->postField('name'),
                    'phone' => $this->postField('phone'),
                ];
                Member::create($data);
                DB::commit();
                return redirect()->back()->with('success', 'Berhasil Menambahkan Data...');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        return view('admin.member.add');
    }

    public function patch($id)
    {
        $data = Member::with('user')->where('user_id','=', $id)->firstOrFail();
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                $request = [
                    'name' => $this->postField('name'),
                    'phone' => $this->postField('phone'),
                ];
                $data->update($request);
                $data->user()->update([
                    'username' => $this->postField('username')
                ]);
                DB::commit();
                return redirect('/admin/member')->with('success', 'Berhasil Merubah Data...');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        return view('admin.member.edit')->with(['data' => $data]);
    }

    public function change_password($id)
    {
        $data = Member::with('user')->where('user_id','=', $id)->firstOrFail();
        if ($this->request->method() === 'POST') {
            try {
                $data->user()->update([
                    'password' => Hash::make($this->postField('password'))
                ]);
                return redirect('/admin/member')->with('success', 'Berhasil Mengganti Password...');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'Terjadi Kesalahan Server...');
            }
        }
        return view('admin.member.change-password')->with(['data' => $data]);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $member = Member::where('user_id', '=', $id)->first();
            $member->delete();
            User::destroy($id);
            DB::commit();
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonResponse('Terjadi Kesalahan Server...', 500);
        }
    }
}
