<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class POS_DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    
    public function index(Request $request)
    {
        $search = $request->search;
        $pagination = $request->pagination;
        $index = 3;
        $page_now =1;
        $url = 'pos-config.diskon.diskon';
        $start = 1;

        $datastore  = DB::table('pos_store')->get();

        if($search==null && $pagination ==null){
            $datadiskon = DB::table('pos_diskon')
                        ->join('pos_store', 'pos_diskon.id_store', '=', 'pos_store.id_store')
                        ->select('pos_diskon.*', 'pos_store.nama_store')
                        ->skip(0)->take($index)
                        ->get();
            $count = DB::table('pos_diskon')->count();
            $count = ceil($count/$index);
        }elseif($search==null&&$pagination!=null){
            $count = DB::table('pos_diskon')->count();
            $count = ceil($count/$index);
            $page_now = $pagination;
            $datadiskon = DB::table('pos_diskon')
                        ->join('pos_store', 'pos_diskon.id_store', '=', 'pos_store.id_store')
                        ->select('pos_diskon.*', 'pos_store.nama_store')
                        ->skip(($page_now-1)*$index)->take($index)
                        ->get();
            $start = (($page_now-1)*$index)+1;
        }elseif($search!=null && $pagination ==null){
            $count = DB::table('pos_diskon')
                ->join('pos_store', 'pos_diskon.id_store', '=', 'pos_store.id_store')
                ->select('pos_diskon.*', 'pos_store.nama_store')
                ->where('nama_voucher', 'like', $search.'%')
                ->orWhere('pos_store.nama_store', 'like', '%'.$search.'%')
                ->count();
            $count = ceil($count/$index);
            $page_now = 1;
            $datadiskon = DB::table('pos_diskon')
                        ->join('pos_store', 'pos_diskon.id_store', '=', 'pos_store.id_store')
                        ->select('pos_diskon.*', 'pos_store.nama_store')
                        ->where('nama_voucher', 'like', $search.'%')
                        ->orWhere('pos_store.nama_store', 'like', '%'.$search.'%')
                        ->skip(($page_now-1)*$index)->take($index)
                        ->get();
            $start = 1;
        }else{
            $count = DB::table('pos_diskon')
                ->join('pos_store', 'pos_diskon.id_store', '=', 'pos_store.id_store')
                ->select('pos_diskon.*', 'pos_store.nama_store')
                ->where('nama_voucher', 'like', $search.'%')
                ->orWhere('pos_store.nama_store', 'like', '%'.$search.'%')
                ->count();
            $count = ceil($count/$index);

            $page_now = $pagination;

            $datadiskon = DB::table('pos_diskon')
                        ->join('pos_store', 'pos_diskon.id_store', '=', 'pos_store.id_store')
                        ->select('pos_diskon.*', 'pos_store.nama_store')
                        ->where('nama_voucher', 'like', $search.'%')
                        ->orWhere('pos_store.nama_store', 'like', '%'.$search.'%')
                        ->skip(($page_now-1)*$index)->take($index)
                        ->get();

            $start = (($page_now-1)*$index)+1;
        }

        return view('pos-config.diskon.diskon', compact ('datastore','datadiskon', 'page_now', 'search', 'count', 'start'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        DB::table('pos_diskon')->insert([
            'id_voucher' => null,
            'nama_voucher' => $request->nama_diskon,
            'id_store' => $request->id_store,
            'nominal' => ($request->nominal)?$request->nominal:null,
            'persen' => ($request->persen)?$request->persen:null,
            'maks_persen' => ($request->maks_persen)?$request->maks_persen:null,
            'is_used' => 0,
        ]);

        return redirect('pos/discount')->with('status1', 'Data Berhasil Ditambah');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datadiskon = DB::table('pos_diskon')->where('id_voucher', $id)->get();
        $datastore = DB::table('pos_store')->get();

        return view('pos-config.diskon.diskon-edit', compact (['datadiskon', 'datastore']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request);
        DB::table('pos_diskon')
            ->where('id_voucher', $request->id_voucher)
            ->update([
                'nama_voucher' => $request->nama_diskon,
                'id_store' => $request->id_store,
                'nominal' => ($request->nominal)?$request->nominal:null,
                'persen' => ($request->persen)?$request->persen:null,
                'maks_persen' => ($request->maks_persen)?$request->maks_persen:null,
            ]);

        return redirect('pos/discount')->with('status1', 'Data Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('pos_diskon')->where('id_voucher', $id)->delete();

        return redirect('pos/discount')->with('status1', 'Data Berhasil Dihapus');
    }
}
