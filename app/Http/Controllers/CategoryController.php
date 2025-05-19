<?php

namespace App\Http\Controllers;

use App\Category;
use App\Exports\ExportCategories;
use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use PDF;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories.index');
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
           'name'   => 'required|string|min:2|unique:categories,name'
        ]);

        $input = $request->all();
        $input['is_archived'] = false;

        Category::create($input);

        return response()->json([
           'success'    => true,
           'message'    => 'Category Created'
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
        $category = Category::find($id);
        return $category;
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
            'name'   => 'required|string|min:2'
        ]);

        $category = Category::findOrFail($id);

        $category->update($request->all());

        return response()->json([
            'success'    => true,
            'message'    => 'Categories Update'
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
        $category = Category::findOrFail($id);
        $category->is_archived = true;
        $category->save();
        return response()->json([
            'success'    => true,
            'message'    => 'Category Archived'
        ]);
    }

    public function apiCategories()
    {
        $categories = Category::where('is_archived', false)->get();
        return Datatables::of($categories)
            ->addColumn('action', function($categories){
                return '<a onclick="editForm('. $categories->id .')" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a> ' .
                    '<a onclick="archiveData('. $categories->id .')" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-folder-close"></i> Archive</a>';
            })
            ->rawColumns(['action'])->make(true);
    }

    public function apiArchivedCategories()
    {
        $categories = Category::where('is_archived', true)->get();
        return Datatables::of($categories)
            ->addColumn('action', function($categories){
                return '<a onclick="unarchiveData('. $categories->id .')" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-folder-open"></i> Unarchive</a>';
            })
            ->rawColumns(['action'])->make(true);
    }

    public function unarchive($id)
    {
        $category = Category::findOrFail($id);
        $category->is_archived = false;
        $category->save();
        return response()->json([
            'success'    => true,
            'message'    => 'Category Unarchived'
        ]);
    }

    public function exportCategoriesAll()
    {
        $categories = Category::all();
        $pdf = PDF::loadView('categories.CategoriesAllPDF',compact('categories'));
        return $pdf->download('categories.pdf');
    }

    public function exportExcel()
    {
        return (new ExportCategories())->download('categories.xlsx');
    }
}
