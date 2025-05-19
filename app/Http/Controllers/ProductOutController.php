<?php

namespace App\Http\Controllers;

use App\Category;
use App\Customer;
use App\Exports\ExportProductOut;
use App\Product;
use App\Product_Out;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use PDF;


class ProductOutController extends Controller
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
        $products = Product::orderBy('name','ASC')
            ->get()
            ->pluck('name','id');

        $customers = Customer::orderBy('name','ASC')
            ->get()
            ->pluck('name','id');

        $invoice_data = Product_Out::all();
        return view('product_out.index', compact('products','customers', 'invoice_data'));
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
           'product_id'     => 'required|exists:products,id',
           'customer_id'    => 'required|exists:customers,id',
           'quantity'       => 'required|numeric|min:1',
           'date'          => 'required|date'
        ]);

        // Check if product has sufficient quantity
        $product = Product::findOrFail($request->product_id);
        if ($product->quantity < $request->quantity) {
            return response()->json([
                'success'    => false,
                'message'    => 'Insufficient product quantity. Available: ' . $product->quantity
            ], 422);
        }

        $data = $request->all();
        $data['archived'] = false;

        Product_Out::create($data);

        // Update product quantity
        $product->quantity -= $request->quantity;
        $product->save();

        return response()->json([
            'success'    => true,
            'message'    => 'Product Out Created Successfully'
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
        $product_out = Product_Out::find($id);
        return $product_out;
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
            'product_id'     => 'required|exists:products,id',
            'customer_id'    => 'required|exists:customers,id',
            'date'          => 'required|date'
        ]);

        $product_out = Product_Out::findOrFail($id);
        
        // Only update allowed fields
        $data = $request->only(['product_id', 'customer_id', 'date']);
        $product_out->update($data);

        return response()->json([
            'success'    => true,
            'message'    => 'Product Out Updated Successfully'
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
        $product_out = Product_Out::findOrFail($id);
        $product_out->update(['archived' => true]);

        return response()->json([
            'success'    => true,
            'message'    => 'Product Out Archived'
        ]);
    }



    public function apiProductsOut(){
        $product = Product_Out::where('archived', false)->get();

        return Datatables::of($product)
            ->addColumn('products_name', function ($product){
                return $product->product->name;
            })
            ->addColumn('customer_name', function ($product){
                return $product->customer->name;
            })
            ->addColumn('action', function($product){
                return '<a onclick="editForm('. $product->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                    '<a onclick="archiveData('. $product->id .')" class="btn btn-warning btn-xs"><i class="fa fa-archive"></i> Archive</a>';
            })
            ->rawColumns(['products_name','customer_name','action'])->make(true);
    }

    public function apiArchivedProductsOut(){
        $product = Product_Out::where('archived', true)->get();

        return Datatables::of($product)
            ->addColumn('products_name', function ($product){
                return $product->product->name;
            })
            ->addColumn('customer_name', function ($product){
                return $product->customer->name;
            })
            ->addColumn('action', function($product){
                return '<a onclick="unarchiveData('. $product->id .')" class="btn btn-success btn-xs"><i class="fa fa-undo"></i> Unarchive</a>';
            })
            ->rawColumns(['products_name','customer_name','action'])->make(true);
    }

    public function unarchive($id)
    {
        $product_out = Product_Out::findOrFail($id);
        $product_out->update(['archived' => false]);

        return response()->json([
            'success'    => true,
            'message'    => 'Product Out Unarchived'
        ]);
    }

    public function exportProductOutAll()
    {
        $product_out = Product_Out::with(['product', 'customer'])->get();
        $pdf = PDF::loadView('product_out.productOutAllPDF',compact('product_out'));
        return $pdf->download('product_out.pdf');
    }

    public function exportProductOut($id)
    {
        $product_out = Product_Out::findOrFail($id);
        $pdf = PDF::loadView('product_out.productOutPDF', compact('product_out'));
        return $pdf->download($product_out->id.'_product_out.pdf');
    }

    public function exportExcel()
    {
        return (new ExportProdukKeluar)->download('product_out.xlsx');
    }
}
