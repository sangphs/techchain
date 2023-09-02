<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Illuminate\Pagination\Paginator;
Paginator::useBootstrap();
class SanphamController extends Controller
{
    public function __construct() {
    $loaisp = DB::table('loai')->where('anhien','=',1 )->orderBy('thutu')->get();
    \View::share( 'loaisp', $loaisp  );
}

    function index(){
        $spnoibat = DB::table('sanpham')->where('hot',1)->orderBy('ngay','desc')->limit(9)->get();
        $spxemnhieu = DB::table('sanpham')->orderBy('soluotxem','desc')->limit(9)->get();
        return view ('home' , ['spnoibat' =>$spnoibat , 'spxemnhieu'=>$spxemnhieu]);
    }
    function chitiet($id=0){
        $sp = DB::table('sanpham')->where ('id_sp','=', $id)->first();   
        $idsp = $sp->id_sp;
        $tc = $sp->tinhchat;
        $idloai = $sp->id_loai;     
        $splienquan = DB::table('sanpham')
        ->where ('id_loai', $idloai)->where('tinhchat', $tc)
        ->orderBy('ngay','desc')
        ->limit(4)->get()->except($idsp);  
        return view ('chitiet', ['id'=>$id, 'title'=>$sp->ten_sp, 'sp'=>$sp, 'splienquan'=>$splienquan] );
    }
    function sptrongloai($idloai=0){
        $perpage= 12;
        $listsp = DB::table('sanpham')
        ->where ('id_loai', $idloai)
        ->paginate($perpage)->withQueryString();
        $tenloai = DB::table('loai')->where ('id_loai', $idloai)->value('ten_loai');
        return view ('sptrongloai', ['id'=>$idloai, 'title'=>$tenloai , 'listsp'=>$listsp]); 
    }
    

    function themvaogio(Request $request, $id_sp = 0, $soluong=1){
        /* 
        cart = [
            ['id_sp'=>1, 'soluong'=>3],
            ['id_sp'=>5, 'soluong'=>12],
            ['id_sp'=>8, 'soluong'=>2]
        ]
        */

        if ($request->session()->exists('cart')==false) {//chưa có cart trong session           
            $request->session()->push('cart', ['id_sp'=> $id_sp,  'soluong'=> $soluong]);          
        } else {// đã có cart, kiểm tra id_sp có trong cart không
            $cart =  $request->session()->get('cart'); 
            $index = array_search($id_sp, array_column($cart, 'id_sp'));
            if ($index!=''){ //id_sp có trong giỏ hàng thì tăhg số lượng
                $cart[$index]['soluong']+=$soluong;
                $request->session()->put('cart', $cart);
            }
            else { //sp chưa có trong arrary cart thì thêm vào 
                $cart[]= ['id_sp'=> $id_sp, 'soluong'=> $soluong];
                $request->session()->put('cart', $cart);
            }    
        }   
        // echo "<pre>";
        // print_r($request->session()->get('cart'));  
        //$request->session()->forget('cart');
        return redirect('/hiengiohang');
    }
    function hiengiohang(Request $request){
        $cart =  $request->session()->get('cart'); 
        return view('hiengiohang', ['cart'=> $cart]);
    }
    function xoasptronggio(Request $request, $id_sp=0){
        $cart =  $request->session()->get('cart'); 
        $index = array_search($id_sp, array_column($cart, 'id_sp'));
        if ($index!=''){ 
            array_splice($cart, $index, 1);
            $request->session()->put('cart', $cart);
        }
        return redirect('/hiengiohang');
    }

    function download() { 
        return view("download"); 
    }
    
}
