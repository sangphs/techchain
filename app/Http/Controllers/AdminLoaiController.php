<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class AdminLoaiController extends Controller
{    
    public function index()
    {
        $dsloai = \DB::table('loai')->orderBy('thutu','asc')->get();
        return view('admin/dsloai',['dsloai'=>$dsloai]);
    }    
    public function create()
    {
        return view('admin/themloai');
    }
    
    public function store(Request $request)
    {
        $ten_loai = $request['ten_loai'];
        $thutu = (int) $request['thutu'];
        $anhien = (int) $request['anhien'];
        \DB::table('loai')->insert(['ten_loai'=>$ten_loai,'thutu'=>$thutu,'anhien'=>$anhien]);
        return redirect('/admin/loai');
    
    }
   
    public function show(string $id)
    {
        //
    }
   
    public function edit( Request $request , string $id) {
        $loai = \DB::table('loai')->where('id_loai', $id)->first();
        if ($loai==null){
            $request->session()->flash('thongbao','Không có loại này: '. $id);
            return redirect('/admin/loai');
        }
        return view('admin/sualoai' , ['loai'=>$loai]);
    }
    

    public function update(Request $request, string $id)
    {
        $ten_loai = $request['ten_loai'];
        $thutu = (int) $request['thutu'];
        $anhien = (int) $request['anhien'];
        \DB::table('loai')->where('id_loai', $id)
        ->update(['ten_loai'=>$ten_loai,'thutu'=>$thutu,'anhien'=>$anhien]);
        return redirect('/admin/loai');
    
    }
    public function destroy(Request $request, string $id)
    {
        $sosp = \DB::table('sanpham')->where('id_loai', $id)->count();
        if ($sosp>0) {
            $request->session()->flash('thongbao','Không xóa, vì có sản phẩm trong loại');
            return redirect('/admin/loai');
        }
        \DB::table('loai')->where('id_loai', $id)->delete();
        $request->session()->flash('thongbao', 'Đã xóa loại');
        return redirect('/admin/loai');
    
    }
}
