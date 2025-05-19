<?php

namespace App\Http\Controllers;

use App\Exports\ExportSuppliers;
use App\Imports\SuppliersImport;
use App\Supplier;
use Excel;
use Illuminate\Http\Request;
use PDF;
use Yajra\DataTables\DataTables;

class SupplierController extends Controller {
	public function __construct() {
		$this->middleware('role:admin');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$suppliers = Supplier::all();
		return view('suppliers.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$this->validate($request, [
			'name' => 'required|string|min:2',
			'address' => 'required|string|min:2',
			'email' => 'required|email|unique:suppliers',
			'phone' => 'required|string|min:2',
		]);

		$data = $request->all();
		$data['archived'] = false; // Explicitly set archived to false for new suppliers

		Supplier::create($data);

		return response()->json([
			'success' => true,
			'message' => 'Supplier Created',
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$supplier = Supplier::find($id);
		return $supplier;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$this->validate($request, [
			'name' => 'required|string|min:2',
			'address' => 'required|string|min:2',
			'email' => 'required|string|email|max:255|unique:suppliers,email,' . $id,
			'phone' => 'required|string|min:2',
		]);

		$supplier = Supplier::findOrFail($id);

		$supplier->update($request->all());

		return response()->json([
			'success' => true,
			'message' => 'Supplier Updated',
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$supplier = Supplier::findOrFail($id);
		$supplier->update(['archived' => true]);

		return response()->json([
			'success' => true,
			'message' => 'Supplier Archived',
		]);
	}

	public function apiSuppliers() {
		$suppliers = Supplier::where('archived', false)->get();

		return Datatables::of($suppliers)
			->addColumn('action', function ($suppliers) {
				return '<a onclick="editForm(' . $suppliers->id . ')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
				'<a onclick="archiveData(' . $suppliers->id . ')" class="btn btn-warning btn-xs"><i class="fa fa-archive"></i> Archive</a>';
			})
			->rawColumns(['action'])->make(true);
	}

	public function apiArchivedSuppliers() {
		$suppliers = Supplier::where('archived', true)->get();

		return Datatables::of($suppliers)
			->addColumn('action', function ($suppliers) {
				return '<a onclick="unarchiveData(' . $suppliers->id . ')" class="btn btn-success btn-xs"><i class="fa fa-undo"></i> Unarchive</a>';
			})
			->rawColumns(['action'])->make(true);
	}

	public function unarchive($id) {
		$supplier = Supplier::findOrFail($id);
		$supplier->update(['archived' => false]);

		return response()->json([
			'success' => true,
			'message' => 'Supplier Unarchived',
		]);
	}

	public function ImportExcel(Request $request) {
		//Validasi
		$this->validate($request, [
			'file' => 'required|mimes:xls,xlsx',
		]);

		if ($request->hasFile('file')) {
			//UPLOAD FILE
			$file = $request->file('file'); //GET FILE
			Excel::import(new SuppliersImport, $file); //IMPORT FILE
			return redirect()->back()->with(['success' => 'Upload file data suppliers !']);
		}

		return redirect()->back()->with(['error' => 'Please choose file before!']);
	}

	public function exportSuppliersAll() {
		$suppliers = Supplier::all();
		$pdf = PDF::loadView('suppliers.SuppliersAllPDF', compact('suppliers'));
		return $pdf->download('suppliers.pdf');
	}

	public function exportExcel() {
		return (new ExportSuppliers)->download('suppliers.xlsx');
	}
}
