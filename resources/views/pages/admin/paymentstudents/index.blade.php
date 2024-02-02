@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-5">
                <h4 class="fw-bold "><i class='bx bx-building-house'></i>Data Pembayaran Siswa</h4>
            </div>
            @if (session('success'))
                <div class="alert alert-success d-flex align-items-center mb-3" role="alert">
                    <i class="bx bx-check"></i>
                    <div>
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover table-striped rounded">
                    <thead>
                        <tr style="vertical-align: middle">
                            <th>No</th>
                            <th>Photo</th>
                            <th>NISN</th>
                            <th>Nama Murid</th>
                            <th>Gender</th>
                            <th>Kelas</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($student as $key => $item)
                            <tr>

                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <img src="{{url('storage/' . $item->photo)}}"width="30" height="" alt="">
                                </td>
                                <td>{{ $item->nisn }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->gender }}</td>
                                <td>{{ $item->classroom->classroom_name }}</td>
                                <td>
                                    <div class=" gap-2 ">
                                        <a href="{{ route('pembayaran.show', $item->id)}}" 
                                            class="btn btn-sm btn-success text-white align-items-center">
                                            <i class='bx bx-credit-card-front'></i>  Detail Pembayaran Siswa </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>   
    </section>
@endsection
