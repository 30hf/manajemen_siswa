<?php

namespace App\Http\Controllers;

use App\Models\SchoolFee;
use Illuminate\Http\Request;

class SchoolFeeCotroller extends Controller
{
    public function index(Request $request)
    {
        $paymentType = $request->input('payment_type');
    
        if ($paymentType) {
            $paymentType = SchoolFee::where('payment_type', '=', $paymentType)->get();
        } else {
            $paymentType = SchoolFee::all();
        }
    
        return view('pages.admin.schoolfees.index', [
            'payments' => $paymentType,
            'datas' => SchoolFee::all(),
            'title' => 'Daftar SPP',
            'payment' => 'Semua Metode'
        ]);
    }
    
    public function filter(Request $request)
    {
        $paymentType = $request->input('payment_type');
        $payments = SchoolFee::where('payment_type', '=', $paymentType)->get();
        $datas = SchoolFee::all();
    
        // Filter the data based on the selected payment type
        if ($paymentType) {
            $datas = $datas->where('payment_type', '=', $paymentType);
        }
    
        return view('pages.admin.schoolfees.index', [
            'payments' => $payments,
            'datas' => $datas,
            'title' => 'Daftar SPP',
            'payment' => $paymentType
        ]);
    }
     public function store(Request $request)
     {
            $data = $request->all();
            SchoolFee::create($data);
            return  redirect()->back()->with('success', 'Daftar Spp Berhasil Ditambahkan');
    }

     public function update(Request $request, $id)
     {
            $data = $request->all();
            SchoolFee::findOrFail($id)->update($data);
            return  redirect()->back()->with('success', 'Daftar Spp Berhasil Diedit');
    }
     public function destroy( $id)
     {
        
            SchoolFee::findOrFail($id)->delete();
            return  redirect()->back()->with('success', 'Daftar Spp Berhasil Dihapus');
    }

}
