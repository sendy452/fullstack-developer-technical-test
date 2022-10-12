<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions = Position::all();
        $employees = Employee::join('positions', 'employees.position_id', '=', 'positions.id')
        ->get(['employees.*', 'positions.name as jabatan', 'positions.id as id_jabatan']);

        if(request()->ajax()) {
            $employees = Employee::join('positions', 'employees.position_id', '=', 'positions.id')
            ->get(['employees.*', 'positions.name as jabatan', 'positions.id as id_jabatan']);
            return datatables($employees)
                ->addIndexColumn()
                ->toJson();
        }
        return view('employee',['positions' => $positions, 'employees' => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'nip' => 'string|unique:employees,nip',
            'ktp' => 'image|mimes:jpg,png',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            if($validator->errors()->has('nip')){
                toast('NIP telah didaftarkan sebelumnya', 'warning');
                return redirect('/employee');
            }

            if($validator->errors()->has('ktp')){
                toast('Format KTP harus jpg atau png', 'warning');
                return redirect('/employee');
            }
        }

        $file= $request->file('ktp');
        $filename= date('Ymd').$file->getClientOriginalName();
        $file->move(public_path('public/Image'), $filename);

        Employee::create([
            'position_id' => $request->jabatan,
            'nip' => $request->nip,
            'nama_karyawan' => $request->nama_karyawan,
            'departemen' => $request->departemen,
            'tgl_lahir' => $request->tgl_lahir,
            'thn_lahir' => $request->thn_lahir,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'agama' => $request->agama,
            'status' => $request->status,
            'ktp' => $filename,
        ]);
        
        toast('Data employee berhasil ditambahkan', 'success');
        return redirect('/employee');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $employee = Employee::find($request->id);

        $data = $request->all();
        $validator = Validator::make($data, [
            'nip' => 'string|unique:employees,nip,'.$request->id.',id',
            'ktp' => 'image|mimes:jpg,png',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            if($validator->errors()->has('nip')){
                toast('NIP telah didaftarkan sebelumnya', 'warning');
                return redirect('/employee');
            }

            if($validator->errors()->has('ktp')){
                toast('Format KTP harus jpg atau png', 'warning');
                return redirect('/employee');
            }
        }

        if ($request->file('ktp') != null) {
            $file= $request->file('ktp');
            $filename= date('Ymd').$file->getClientOriginalName();
            $file->move(public_path('public/Image'), $filename);

            $employee->ktp = $filename;
        }

        
        $employee->position_id = $request->jabatan;
        $employee->nip = $request->nip;
        $employee->nama_karyawan = $request->nama_karyawan;
        $employee->departemen = $request->departemen;
        $employee->tgl_lahir = $request->tgl_lahir;
        $employee->thn_lahir = $request->thn_lahir;
        $employee->alamat = $request->alamat;
        $employee->no_telp = $request->no_telp;
        $employee->agama = $request->agama;

        $employee->save();

        toast('Data employee berhasil dirubah', 'success');
        return redirect('/employee');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        $employee = Employee::find($request->id);

        if ($employee->status == 1) {
            $employee->status = 0;
            $employee->save();
        } else {
            $employee->status = 1;
            $employee->save();
        }

        toast('Status employee berhasil dirubah', 'success');
        return redirect('/employee');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $employee = Employee::find($request->id);

        $employee->delete();

        toast('Data employee berhasil dihapus', 'success');
        return redirect('/employee');
    }
}
