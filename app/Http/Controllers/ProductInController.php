<?php

namespace App\Http\Controllers;


use App\Exports\ExportProductIn;
use App\Product;
use App\Product_In;
use App\Supplier;
use PDF;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class ProductInController extends Controller
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

        $suppliers = Supplier::orderBy('name','ASC')
            ->get()
            ->pluck('name','id');

        $invoice_data = Product_In::all();
        return view('product_in.index', compact('products','suppliers','invoice_data'));
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
            'supplier_id'    => 'required|exists:suppliers,id',
            'quantity'       => 'required|numeric|min:1',
            'date'          => 'required|date'
        ]);

        $data = $request->all();
        $data['archived'] = false; // Explicitly set archived to false for new entries

        Product_In::create($data);

        $product = Product::findOrFail($request->product_id);
        $product->quantity += $request->quantity;
        $product->save();

        return response()->json([
            'success'    => true,
            'message'    => 'Product In Created Successfully'
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
        $product_in = Product_In::find($id);
        return $product_in;
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
            'product_id'     => 'required',
            'supplier_id'    => 'required',
            'quantity'       => 'required',
            'date'           => 'required'
        ]);

        $product_in = Product_In::findOrFail($id);
        $product_in->update($request->all());

        $product = Product::findOrFail($request->product_id);
        $product->quantity += $request->quantity;
        $product->update();

        return response()->json([
            'success'    => true,
            'message'    => 'Product In Updated'
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
        $product_in = Product_In::findOrFail($id);
        $product_in->update(['archived' => true]);

        return response()->json([
            'success'    => true,
            'message'    => 'Product In Archived'
        ]);
    }



    public function apiProductsIn(){
        $product = Product_In::where('archived', false)->get();

        return Datatables::of($product)
            ->addColumn('products_name', function ($product){
                return $product->product->name;
            })
            ->addColumn('supplier_name', function ($product){
                return $product->supplier->name;
            })
            ->addColumn('action', function($product){
                return '<a onclick="editForm('. $product->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                    '<a onclick="archiveData('. $product->id .')" class="btn btn-warning btn-xs"><i class="fa fa-archive"></i> Archive</a>';
            })
            ->rawColumns(['products_name','supplier_name','action'])->make(true);
    }

    public function apiArchivedProductsIn(){
        $product = Product_In::where('archived', true)->get();

        return Datatables::of($product)
            ->addColumn('products_name', function ($product){
                return $product->product->name;
            })
            ->addColumn('supplier_name', function ($product){
                return $product->supplier->name;
            })
            ->addColumn('action', function($product){
                return '<a onclick="unarchiveData('. $product->id .')" class="btn btn-success btn-xs"><i class="fa fa-undo"></i> Unarchive</a>';
            })
            ->rawColumns(['products_name','supplier_name','action'])->make(true);
    }

    public function unarchive($id)
    {
        $product_in = Product_In::findOrFail($id);
        $product_in->update(['archived' => false]);

        return response()->json([
            'success'    => true,
            'message'    => 'Product In Unarchived'
        ]);
    }

    public function exportProductInAll()
    {
        $product_in = Product_In::all();
        $pdf = PDF::loadView('product_in.productInAllPDF',compact('product_in'));
        return $pdf->download('product_enter.pdf');
    }

    public function exportProductIn($id)
    {
        $product_in = Product_In::findOrFail($id);
        $pdf = PDF::loadView('product_in.productInPDF', compact('product_in'));
        return $pdf->download($product_in->id.'_product_enter.pdf');
    }

    public function exportExcel()
    {
        return (new ExportProdukIn)->download('product_.xlsx');
    }
}
