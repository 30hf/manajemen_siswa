@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-5">
                <h4 class="fw-bold "><i class='bx bx-credit-card-front'></i> Detail Pembayaran Siswa {{ $item->name }}</h4>
                @if (session('success'))
                <div class="alert alert-success d-flex align-items-center mb-3" role="alert">
                    <i class="bx bx-check"></i>
                    <div>
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center mb-4">
                            <header>
                                <h5 class="card-title fw-bold mb-2">Biodata Siswa</h5>
                            </header>
                            <img src="{{ url('storage/' . $item->photo) }}"width="110" height="120" alt=""
                                class="mt-3">
                            <h5 class="card-title fw-bold mt-2">{{ $item->name }}</h5>
                            <p class="card-title fw-bold mt-2">{{ $item->nisn }}</p>
                        </div>

                    </div>
                </div>
                <div class="col-8">

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <tr>
                                <th width ="203px">NISN</th>
                                <td>: {{ $item->nisn }}</td>
                            <tr>
                                <th>Nama Murid</th>
                                <td>: {{ $item->name }}</td>
                                <tr>
                                    @if (count($parents) > 1)
                                        <th>Nama wali</th>
                                        <td>: {{ $parents[0]->name }}</td>
                                    @elseif (count($parents) == 1)
                                        <th>Nama wali</th>
                                        @foreach ($parents as $parent)
                                            <td>: {{ $parent->name }}</td>
                                        @endforeach
                                    @else
                                        <th>Nama wali</th>
                                        <td>: Sorry, data not filled</td>
                                    @endif
                            </tr>
                            <th>Gender</th>
                            <td>: {{ $item->gender }}</td>
                            <tr>
                                <th>Kelas</th>
                                <td>: {{ $item->classroom->classroom_name }}</td>
                            <tr>
                                <th>Tempat Lahir</th>
                                <td>: {{ $item->place_of_birth }}</td>
                            </tr>
                    </div>
                    </table>
                    <div class=" gap-2 d-flex">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#Verifikasi{{ $item->id }}"
                            class="btn btn-success d-flex align-items-center gap-2">
                            <i class='bx bx-credit-card-front'></i>Lakukan Transaksi Pembayaran
                        </button>
                    </div>
                </div>
            </div>

        </div>
        <hr class="mt-5 mb-3">
        <div class=" mt-3">
            <div class="d-flex align-items-center justify-content-between mb-5">
                <h4 class="fw-bold "><i class='bx bx-credit-card-front'></i> Rekam Transaksi Pembayaran Siswa {{ $item->name }}</h4>
            </div>
            <span>*Rekam Transaksi diambil bedasarkan masa aktif siswa di sekolah</span>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kategori</th>
                            <th>Metode Pembayaran</th>
                            <th>Nominal</th>
                            <th>Bulan</th>
                            <th>payment date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($payments) > 0)
                            @foreach ($payments as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $value->student->name }}</td>
                                    <td>{{ $value->school_fee->name }}</td>
                                    @if ($value->metode_type == 'cash')
                                        <td> <span class="badge bg-success">Cash</span></td>
                                    @else
                                        <td> <span class="badge bg-info">Credit</span></td>
                                    @endif
                                    <td>Rp. {{ number_format($value->school_fee->nominal)}}</td>
                                    <td>{{ $value->month }}</td>
                                    <td>{{ $value->created_at }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">Siswa belum pernah melakukan transaksi</td>
                            </tr>
                        @endif
                    </tbody>
            </div>
        </div>
        </div>
        <div class="modal" tabindex="-1" id="Verifikasi{{ $item->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h5 class="modal-title text-white"> Verifikasi {{ $item->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf


                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="student_id">Nama Murid</label>
                                        <input type="hidden" name="student_id" id="student_id"
                                            class="form-control" value="{{ $item->id }}">
                                            
                                        <input class="form-control" type="text" value="{{ $item->name }}">
                                     </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="classroom_id">Nama Kelas</label>
                                        <input type="hidden" name="classroom_id" id="classroom_id"
                                            class="form-control" value="{{ $item->classroom->id }}">
                                            
                                        <input class="form-control" type="text"  value="{{ $item->classroom->classroom_name }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="parent_id">Nama Wali</label>
                                        <input type="hidden" name="parent_id" id="parent_id"
                                            class="form-control" value=" {{ $item->parent->first()->id }}">
                                            
                                        <input class="form-control" type="text"  value="{{ $item->parent->first()->name }}">
                                    </div>
                                </div>                                
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="school_fee_id">Kategori</label>
                                        <select name="school_fee_id" id="school_fee_id" class="form-control" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach ($schoolfee as $jenis)
                                          <option value="{{ $jenis->id }}">{{ $jenis->name }}</option>
                                          @endforeach
                                           
                                          </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="metode_type">Metode Pembayaran</label>
                                        <select name="metode_type" id="metode_type" class="form-control">
                                        <option value="">Pilih Metode</option>
                                        <option value="cash">Cash</option>
                                        <option value="credit">Credit</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="month">Bulan</label>
                                        <select name="month" id="month" class="form-control">
                                        <option value="">Pilih Bulan</option>
                                        <option value="january">january</option>
                                        <option value="february">february</option>
                                        <option value="march">march</option>
                                        <option value="april">april</option>
                                        <option value="may">may</option>
                                        <option value="june">june</option>
                                        <option value="july">july</option>
                                        <option value="august">august</option>
                                        <option value="september">september</option>
                                        <option value="october">october</option>
                                        <option value="november">november</option>
                                        <option value="december">december</option>
                                        </select>
                                    </div>
                                </div>
                                    <div class="mb-3">
                                        <label for="proof_of_payment">Bukti Pembayaran</label>
                                        <input type="file" name="proof_of_payment" id="proof_of_payment" class="form-control" accept="image/*" required>
                                    </div>
                                <span class="mt 2 mb-2">* Sebelum Mengirim data verifikasi, Harap mengecek dan mengisi seluruh form yang disediakan</span>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Simpan Verifikasi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
