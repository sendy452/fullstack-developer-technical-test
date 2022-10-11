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

        if(request()->ajax()) {
            $employees = Employee::join('positions', 'employees.position_id', '=', 'positions.id')
            ->get(['employees.*', 'positions.name as jabatan', 'positions.id as id_jabatan']);
            return datatables($employees)
                ->addIndexColumn()
                ->toJson();
        }
        return view('employee',['positions' => $positions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
        
        toast('Data Employee Berhasil Ditambahkan', 'success');
        return redirect('/employee');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
