<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\category;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

class productController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = category::all();
        $product = product::all();
        return view('produk.p_index', compact('product','categories'));
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
        Session::flash('nama_produk', $request->nama_produk);
        Session::flash('deskripsi', $request->deskripsi);
        Session::flash('harga', $request->harga);
        Session::flash('jumlah', $request->jumlah);
        Session::flash('category_id', $request->category_id);

        // validate the form data
    $validatedData = $request->validate([
        'nama_produk' => 'required|max:50',
        'deskripsi' => 'required|max:255',
        // 'foto_produk' => 'required',
        'harga' => 'required|numeric',
        'jumlah' => 'required|numeric',
        'category_id' => 'required|exists:categories,id'
    ],[
        'nama_produk' => 'produk harus diisi',
        'deskripsi' => 'deskripsi harus diisi',
        'harga' => 'harga harus diisi',
        'jumlah' => 'jumlah harus diisi',
        'category_id' => ' kategori harus diisi',
        
    ]);

    // create a new product with the validated data
    $product = new Product;
    $product->nama_produk = $validatedData['nama_produk'];
    $product->deskripsi = $validatedData['deskripsi'];
    $product->harga = $validatedData['harga'];
    $product->jumlah = $validatedData['jumlah'];
    $product->category_id = $validatedData['category_id'];

    // save the new product to the database
    $product->save();

    // redirect the user to the product index page with a success message
    return redirect()->route('product.index')->with('success', 'produk berhasil ditambahkan');

        
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
        //
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
        //
        $product =[
            'nama_produk' =>$request->nama_produk,
            'deskripsi' =>$request->deskripsi,
            'harga' =>$request->harga,
            'jumlah' =>$request->jumlah,
            'category_id' =>$request->category_id,
        ];
        product::where('id',$id)->update($product);
        return redirect()->to('product')->with('success', 'Berhasil melakukan update data ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        product::where('id', $id)->delete();
        return redirect()->to('product')->with('success', 'Berhasil melakukan hapus ');
    }
}
