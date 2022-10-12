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
            <input name="tgl_lahir" type="date" class="form-control" required>
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
            <textarea name="alamat" class="form-control" required></textarea>                      
        </div>
        <div class="col-md-4">
            <label class="form-label">No Telepon</label> 
            <input name="no_telp" type="number" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Agama</label>
            <div class="col-md-10">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="islam" type="radio" name="agama" value="Islam" checked>
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
            <input name="ktp" type="file" class="form-control" required>                
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
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
            </table>
          </div>
    </div>
</div>

@foreach($employees as $employee)
<div class="modal fade" id="modalEdit{{$employee->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="test2">Edit Data Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="row g-3" enctype="multipart/form-data" method="post" action="{{url('update-employee')}}">
                @csrf
                @method("PUT")
    
            <div class="modal-body">
            <table class="table table-responsive">
                <input name="id" type="hidden" class="form-control" value="{{$employee->id}}">
                <tr><td>Nama Karyawan: </td><td><input name="nama_karyawan" type="text" class="form-control" value="{{$employee->nama_karyawan}}" required></td></tr>
                <tr><td>NIP: </td><td><input name="nip" type="text" class="form-control" value="{{$employee->nip}}" required></td></tr>
                <tr><td>Jabatan: </td><td><select class="form-control" name="jabatan"> @foreach($positions as $position) <option value="{{$position->id}}" 
                {{($position->name == $employee->jabatan) ? ' selected' : ''}}>{{$position->name}}</option> @endforeach</select></td></tr>
                <tr><td>Departemen: </td><td><select class="form-control" name="departemen"> <option value="IT" {{($employee->departemen == 'IT') ? ' selected' : ''}} >IT</option> <option value="Finance" {{($employee->departemen == 'Finance') ? 'selected' : '' }}>Finance</option> </select></td></tr>
                <tr><td>Tanggal Lahir: </td><td><input name="tgl_lahir" type="date" class="form-control" value="{{$employee->tgl_lahir}}" required></td></tr>
                <tr><td>Tahun Lahir: </td><td> <select class="form-control" name="thn_lahir"> @for ($year = (int)date('Y'); 1900 <= $year; $year--): <option value="{{$year}}" {{($year == $employee->thn_lahir) ? 'selected' : ''}}>{{$year}}</option> @endfor </select></td></tr>
                <tr><td>Alamat: </td><td><textarea name="alamat" class="form-control" required>{{$employee->alamat}}</textarea></td></tr>
                <tr><td>No. Telp: </td><td><input name="no_telp" type="number" class="form-control" value="{{$employee->no_telp}}" required></td></tr>
                <tr><td>Agama: </td><td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="islam{{$employee->id}}" type="radio" name="agama" value="Islam" {{ ($employee->agama == "Islam") ? "checked" : ""}} />
                            <label class="form-check-label" for="islam{{$employee->id}}">
                                Islam
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="kristen{{$employee->id}}" type="radio" name="agama" value="Kristen" {{ ($employee->agama == "Kristen") ? "checked" : ""}}/>
                            <label class="form-check-label" for="kristen{{$employee->id}}">
                                Kristen
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="katolik{{$employee->id}}" type="radio" name="agama" value="Katolik" {{ ($employee->agama == "Katolik") ? "checked" : ""}}/>
                            <label class="form-check-label" for="katolik{{$employee->id}}">
                                Katolik
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="hindu{{$employee->id}}" type="radio" name="agama" value="Hindu" {{ ($employee->agama == "Hindu") ? "checked" : ""}}/>
                            <label class="form-check-label" for="hindu{{$employee->id}}">
                                Hindu
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="budha{{$employee->id}}" type="radio" name="agama" value="Budha" {{ ($employee->agama == "Budha") ? "checked" : ""}}/>
                            <label class="form-check-label" for="budha{{$employee->id}}">
                                Budha
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" id="khonghucu{{$employee->id}}" type="radio" name="agama" value="Khonghucu" {{ ($employee->agama == "Khonghucu") ? "checked" : ""}}/>
                            <label class="form-check-label" for="khonghucu{{$employee->id}}">
                                Khonghucu
                           </label>
                        </div>
                </td></tr>
                <tr><td>Foto KTP: </td><td><input name="ktp" type="file" class="form-control" value="{{$employee->ktp}}"></td></tr>
            </table>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-warning">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
        </div>
    </div>
</div>
@endforeach

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
            { data: null,
                render: function ( data, type, row ) {
                    if (data.status == 1) {
                        var url = '{{route("status.employee", ":id")}}';
                        url = url.replace(':id', data.id);
                        return '<a href="'+url+'" type="button" class="btn btn-success">Aktif</a>';
                    } else {
                        var url = '{{route("status.employee", ":id")}}';
                        url = url.replace(':id', data.id);
                        return '<a href="'+url+'" type="button" class="btn btn-danger">Tidak Aktif</a>';
                    }
                }
            },
            { data: null,
                render: function ( data, type, row ) {
                    
                    var url_hapus = '{{route("hapus.employee", ":id")}}';
                    url_hapus = url_hapus.replace(':id', data.id);

                    if (data.status == 1) {
                        data.status = "Aktif";
                    } else {
                        data.status = "Tidak Aktif";
                    }
                    
                    return '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalDetail'+data.id+'">Detail</button> ' +
                    '<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalEdit'+data.id+'">Edit</button> ' +
                    '<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalHapus'+data.id+'">Delete</button> ' +
                    '<div class="modal fade" id="modalDetail'+data.id+'" tabindex="-1" role="dialog" aria-hidden="true">'+
                        '<div class="modal-dialog" role="document">'+
                            '<div class="modal-content">'+
                                '<div class="modal-header">'+
                                    '<h5 class="modal-title" id="test2">Detail Data Employee</h5>'+
                                    '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                                        '<span aria-hidden="true">&times;</span>'+
                                    '</button>'+
                                '</div>'+
                                '<div class="modal-body">'+
                                '<table class="table table-responsive">'+
                                    '<tr><td>Nama Karyawan: </td><td>'+data.nama_karyawan+'</td></tr>'+
                                    '<tr><td>NIP: </td><td>'+data.nip+'</td></tr>'+
                                    '<tr><td>Jabatan: </td><td>'+data.jabatan+'</td></tr>'+
                                    '<tr><td>Departemen: </td><td>'+data.departemen+'</td></tr>'+
                                    '<tr><td>Tanggal Lahir: </td><td>'+data.tgl_lahir+'</td></tr>'+
                                    '<tr><td>Tahun Lahir: </td><td>'+data.thn_lahir+'</td></tr>'+
                                    '<tr><td>Alamat: </td><td>'+data.alamat+'</td></tr>'+
                                    '<tr><td>No. Telp: </td><td>'+data.no_telp+'</td></tr>'+
                                    '<tr><td>Agama: </td><td>'+data.agama+'</td></tr>'+
                                    '<tr><td>Status: </td><td>'+data.status+'</td></tr>'+
                                    '<tr><td>Foto KTP: </td><td><img src="public/Image/'+data.ktp+'" style="width:250px;height:200px;"></td></tr>'+
                                '</table>'+
                                '</div>'+
                                '<div class="modal-footer">'+
                                    '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="modal fade" id="modalHapus'+data.id+'" tabindex="-1" role="dialog" aria-hidden="true">'+
                        '<div class="modal-dialog" role="document">'+
                            '<div class="modal-content">'+
                                '<div class="modal-header">'+
                                    '<h5 class="modal-title" id="test2">Hapus Data Employee</h5>'+
                                    '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
                                        '<span aria-hidden="true">&times;</span>'+
                                    '</button>'+
                                '</div>'+
                                '<div class="modal-body">'+
                               'Yakin untuk hapus data employee ?'+
                                '</div>'+
                                '<div class="modal-footer">'+
                                    '<a href="'+url_hapus+'" type="button" class="btn btn-danger">Delete</a>'+
                                    '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>';
                }
            }
        ]
    })
</script>
@endpush
