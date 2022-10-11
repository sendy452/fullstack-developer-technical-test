@extends('layout.app')

@section('css')
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('breadcrumb')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Employee</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Employee</li>
    </ol>
</div>
@endsection
@section('content')
@include('sweetalert::alert')

<div class="card mb-5">
    <div class="card-body">
      <h5 class="card-title">Tambah Data Employee</h5>
      <form class="row g-3" enctype="multipart/form-data" method="post" action="{{url('add-employee')}}">
        @csrf

        <div class="col-12">
            <label class="form-label">Nama Karyawan</label>
            <input name="nama_karyawan" type="text" class="form-control" required>
        </div>
        <div class="col-md-12">
            <label class="form-label">NIP</label>
            <input name="nip" type="text" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Jabatan</label>                        
            <select class="form-control" name="jabatan">
                @foreach($positions as $position)
                <option value="{{$position->id}}">{{$position->name}}</option>
                @endforeach
            </select>                       
        </div>
        <div class="col-md-6">
            <label class="form-label">Departemen</label>                        
            <select class="form-control" name="departemen">
                <option value="IT">IT</option>
                <option value="Finance">Finance</option>
            </select>                       
        </div>
        <div class="col-md-6">
            <label class="form-label">Tanggal Lahir</label>
            <input name="tgl_lahir" type="date" class="form-control">
        </div>
        <div class="col-md-6">
            <label class="form-label">Tahun Lahir</label>
            <select class="form-control" name="thn_lahir">
                <?php
                for ($year = (int)date('Y'); 1900 <= $year; $year--): ?>
                  <option value="<?=$year;?>"><?=$year;?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">Alamat</label>                    
            <textarea name="alamat" class="form-control"></textarea>                      
        </div>
        <div class="col-md-4">
            <label class="form-label">No Telepon</label> 
            <input name="no_telp" type="number" class="form-control" >
        </div>
        <div class="col-md-4">
            <label class="form-label">Agama</label>
            <div class="col-md-10">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="islam" type="radio" name="agama" value="Islam">
                    <label class="form-check-label" for="islam">
                        Islam
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="kristen" type="radio" name="agama" value="Kristen">
                    <label class="form-check-label" for="kristen">
                        Kristen
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="katolik" type="radio" name="agama" value="Katolik">
                    <label class="form-check-label" for="katolik">
                        Katolik
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="hindu" type="radio" name="agama" value="Hindu">
                    <label class="form-check-label" for="hindu">
                        Hindu
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="budha" type="radio" name="agama" value="Budha">
                    <label class="form-check-label" for="budha">
                        Budha
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="khonghucu" type="radio" name="agama" value="Khonghucu">
                    <label class="form-check-label" for="khonghucu">
                        Khonghucu
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label">Status</label>                        
            <select class="form-control" name="status">
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
            </select>                       
        </div>
        <div class="col-12">
            <label class="form-label">Foto KTP</label>                    
            <input name="ktp" type="file" class="form-control" >                
        </div>
        
        <div class="mt-3 ml-3 text-center float-right">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
</div>

<div class="card sm mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary"></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive p-3">
            <table class="table align-items-center table-flush" id="dataTable">
              <thead class="thead-light">
                <tr>
                  <th>No.</th>
                  <th>Nama Karyawan</th>
                  <th>NIP</th>
                  <th>Departemen</th>
                  <th>Aksi</th>
                </tr>
              </thead>
            </table>
          </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('employee.index') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false, className: "text-center"},
            { data: 'nama_karyawan' },
            { data: 'nip' },
            { data: 'departemen' },
           
        ]
    })
</script>
@endpush
