<?php

namespace App\Http\Controllers;


use App\Customer;
use App\Exports\ExportCustomers;
use App\Imports\CustomersImport;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Excel;
use PDF;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin,staff');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index');
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
        $this->validate($request, [
            'name'      => 'required|string|min:2',
            'address'   => 'required|string|min:2',
            'email'     => 'required|email|unique:customers',
            'phone'     => 'required|string|min:2',
        ]);

        $data = $request->all();
        $data['archived'] = false; // Explicitly set archived to false for new customers

        Customer::create($data);

        return response()->json([
            'success'    => true,
            'message'    => 'Customer Created'
        ]);

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
        $customer = Customer::find($id);
        return response()->json($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'      => 'required|string|min:2',
            'address'   => 'required|string|min:2',
            'email'     => 'required|string|email|max:255|unique:customers,email,' . $id,
            'phone'     => 'required|string|min:2',
        ]);

        $customer = Customer::findOrFail($id);

        $customer->update($request->all());

        return response()->json([
            'success'    => true,
            'message'    => 'Customer Updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->update(['archived' => true]);

        return response()->json([
            'success'    => true,
            'message'    => 'Customer Archived'
        ]);
    }

    public function apiCustomers()
    {
        $customer = Customer::where('archived', false)->get();

        return Datatables::of($customer)
            ->addColumn('action', function($customer){
                return '<a onclick="editForm('. $customer->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                    '<a onclick="archiveData('. $customer->id .')" class="btn btn-warning btn-xs"><i class="fa fa-archive"></i> Archive</a>';
            })
            ->rawColumns(['action'])->make(true);
    }

    public function apiArchivedCustomers()
    {
        $customer = Customer::where('archived', true)->get();

        return Datatables::of($customer)
            ->addColumn('action', function($customer){
                return '<a onclick="unarchiveData('. $customer->id .')" class="btn btn-success btn-xs"><i class="fa fa-undo"></i> Unarchive</a>';
            })
            ->rawColumns(['action'])->make(true);
    }

    public function unarchive($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->update(['archived' => false]);

        return response()->json([
            'success'    => true,
            'message'    => 'Customer Unarchived'
        ]);
    }

    public function ImportExcel(Request $request)
    {
        //Validasi
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        if ($request->hasFile('file')) {
            //UPLOAD FILE
            $file = $request->file('file'); //GET FILE
            Excel::import(new CustomersImport, $file); //IMPORT FILE
            return redirect()->back()->with(['success' => 'Upload file data customers !']);
        }

        return redirect()->back()->with(['error' => 'Please choose file before!']);
    }


    public function exportCustomersAll()
    {
        $customers = Customer::all();
        $pdf = PDF::loadView('customers.CustomersAllPDF',compact('customers'));
        return $pdf->download('customers.pdf');
    }

    public function exportExcel()
    {
        return (new ExportCustomers)->download('customers.xlsx');
    }
}
