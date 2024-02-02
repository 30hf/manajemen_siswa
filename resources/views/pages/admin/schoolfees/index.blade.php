@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-5">
                <h4 class="fw-bold "><i class='bx bx-building-house'></i>   Daftar SPP</h4>
                <button type="button" data-bs-toggle="modal" data-bs-target="#addModal"
                    class="btn btn-primary d-flex align-items-center gap-2">
                    <i class="bx bx-plus"></i> Tambah Daftar SPP
                </button>
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
                <table class="table table-hover table-strippe rounded">
                    <thead>
                        <form action="{{ route('spp.filter') }}" method="GET">
                            <div class="mb-3 btn btn-success d-flex align-items-center gap-2">
                                <label for="payment_type" class="text-center">Kategori Pembayaran</label>
                                <select name="payment_type" id="payment_type" class="form-control">
                                    <option value="">Pilih Kategori Pembayaran</option>
                                    <option value="bulanan" {{  $payment == 'bulanan' ? 'SELECTED' : ''  }}>Bulanan </option>
                                    <option value="tahunan" {{  $payment == 'tahunan' ? 'SELECTED' : ''  }}>Tahunan</option>
                                </select>
                                <button type="submit" class="btn btn-primary col-2"> <i class='bx bx-filter-alt'></i> Filter</button>
                            </div>
                        </form>
                        <tr style="vertical-align: middle">
                            <th>No</th>
                            <th>Nama Spp</th>
                            <th>Deskripsi</th>
                            <th>Kategori</th>
                            <th>Nominal</th>
                            <th>Kelas Industri</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $key => $item)
                        <tr>

                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->desc }}</td>

                                @if ($item->payment_type == 'bulanan')
                                <td> <span class="badge bg-success">Bulanan</span></td>
                                @else
                                <td> <span class="badge bg-info">Tahunan</span></td>                           
                                @endif
                                <td> Rp. {{ number_format($item->nominal)}}</td>

                                <td> Rp. {{ number_format($item->special_major)}}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-warning px-4" type="button" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $item->id }}"> 
                                            Edit
                                        </button>
                                        <form action="{{ route('spp.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger px-4" type="submit"
                                                onclick="return confirm('Apakah kamu yakin ingin menghapusnya?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal" tabindex="-1" id="editModal{{ $item->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"> Spp {{ $item->name}}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('spp.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="name">Nama Jurusan</label>
                                                    <input type="text" name="name" id="name"
                                                        class="form-control" value="{{ $item->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="desc">Deskripsi</label>
                                                    <textarea name="desc" id="desc" cols="30" rows="3" class="form-control">{{ $item->desc }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="payment_type">Kategori</label>
                                                    <select name="payment_type" id="payment_type" class="form-control">
                                                    <option value="bulanan" {{$item->payment_type == 'bulanan' ? 'SELECTED' : ''}}>Bulanan</option>
                                                    <option value="tahunan" {{$item->payment_type == 'tahunan' ? 'SELECTED' : ''}}>Tahunan</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nominal" class="form-label">Nominal</label>
                                                    <input type="text" class="form-control" id="nominal" name="nominal" value="{{ $item->nominal}}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="special_major" class="form-label">Kelas Industri</label>
                                                    <input type="text" class="form-control" id="special_major" name="special_major" value="{{ $item->special_major}}" required>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Simpan perubahan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
            </div>
            @endforeach
            </tbody>
            </table>
        </div>
        </div>

    </section>
    <div class="modal" tabindex="-1" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Spp Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                  <div class="modal-body">
                    <form action="{{ route('spp.store') }}" method="POST">
                       @csrf
                        <div class="mb-3">
                            <label for="name">Nama SPP</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="desc">Deskripsi</label>
                            <textarea name="desc" id="desc" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                        <label for="payment_type">Kategori</label>
                            <select name="payment_type" id="payment_type" class="form-control">
                                <option value="" hidden> --Choose</option>
                                <option value="bulanan">Bulanan</option>
                                <option value="tahunan">Tahunan</option>
                            </select>
                        </label>
                        <div class="mb-3">
                            <label for="nominal" class="form-label">Nominal</label>
                            <input type="text" class="form-control" id="nominal" name="nominal" placeholder="Nominal Pembayar" required>
                        </div>
                        <div class="mb-3">
                            <label for="special_major" class="form-label">Kelas Industri</label>
                            <input type="text" class="form-control" id="special_major" name="special_major" placeholder="Nominal Pembayar kelas Industri" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        document.getElementById('payment_type').addEventListener('change', function() {
            document.getElementById('filter_payment_type').value = this.value;
            document.querySelector('form').submit();
        });
        </script>
@endsection
