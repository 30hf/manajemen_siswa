<?php

namespace App\Http\Controllers;


use App\Models\Classroom;
use App\Models\ParentModel;
use App\Models\PaymentStudent;
use App\Models\SchoolFee;
use App\Models\Student;
use Illuminate\Http\Request;


class PaymentStudentController extends Controller
{
    public function index()
    {
        $schoolfee = SchoolFee::all();

        return view('pages.admin.paymentstudents.index', [
            'student' => Student::all(),
            'schoolfee' => $schoolfee
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        $data['proof_of_payment'] = $request->file('proof_of_payment')->store('pembayaran-photo', 'public');

        PaymentStudent::create($data);

        return redirect()->back()->with('success', 'Verifikasi Sukses');
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        return view('pages.admin.paymentstudents.show', [
            'item' => Student::findOrFail($id),
            'schoolfee' => SchoolFee::all(),
            'parents' => ParentModel::where('id_student', $id)->get(),
            'payments'=> PaymentStudent::where('student_id', $id)->get(),
            'title' => 'Daftar Data pembayaran murid',
            



        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
