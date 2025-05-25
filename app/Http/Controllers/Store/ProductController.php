<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Products;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use App\Rules\SafeInput;

class ProductController extends Controller
{
    public function index()
    {
        $products = Products::where('store_id',session('store_id'))->get();
        return view('dashboard.product.index',compact('products'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', new SafeInput],
            'varian' => ['required', 'string','max:255', new SafeInput],
            'size' => ['required', 'numeric', new SafeInput],
            'unit' => ['required', 'string','max:255', new SafeInput],
            'barcode_text' => ['required', 'string','max:255', new SafeInput],
            'harga_beli' => ['required', 'numeric','max:1000', new SafeInput],
            'harga_jual' => ['required', 'numeric','max:1000', new SafeInput],
            'stock' => ['required', 'numeric','max:1000', new SafeInput],
        ]);

        $name = $validated['name'];
        $varian = $validated['varian'];
        $size = $validated['size'];
        $unit = $validated['unit'];
        $unit = $validated['unit'];
        $barcode_text = $validated['barcode_text'];
        $harga_beli = $validated['harga_beli'];
        $harga_jual = $validated['harga_jual'];
        $stock = $validated['stock'];
        
        DB::beginTransaction();
        try {
            if ($request->has('image_data')) {
                $imageData = $request->input('image_data');

                // Remove the prefix (data:image/png;base64,)
                [$type, $data] = explode(';', $imageData);
                [, $data] = explode(',', $data);

                // Decode the base64
                $decodedData = base64_decode($data);

                // Create image resource from string
                $sourceImage = imagecreatefromstring($decodedData);

                if ($sourceImage === false) {
                    return back()->with('error', 'Invalid image data.');
                }

                // Generate filename
                $filename = 'product_' . time() . '.jpg';
                $path = public_path('uploads/products/' . $filename); // Adjust the path as needed

                // Save as JPG
                imagejpeg($sourceImage, $path, 90); // 90 is quality

                // Clean up memory
                imagedestroy($sourceImage);

                // Save to database if needed
                $product = new Products();
                $product->store_id = session('store_id');
                $product->name = $request->name;
                $product->varian = $request->varian;
                $product->size = $request->size;
                $product->unit = $request->unit;
                $product->barcode = $request->barcode_text;
                $product->photo = 'uploads/products/' . $filename;
                $product->save();
                

                return redirect()->back()->with('success', 'Product saved!');
            }
        } catch (\Exception $e) {
            // In case of error, roll back the transaction
            DB::rollBack();

            // Handle the error (e.g., log it or show a user-friendly message)
            return redirect()->back()->with('error',   'There was an error creating the product.');
        }

    }
    public function edit($id)
    {
        $product = Products::where('id',$id)->first();
        return view('dashboard.product.edit',compact('product'));
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => ['required', 'numeric', 'max:255', new SafeInput],
            'name' => ['required', 'string', 'max:255', new SafeInput],
            'varian' => ['required', 'string', 'max:255', new SafeInput],
            'size' => ['required', 'numeric', new SafeInput],
            'unit' => ['required', 'string', 'max:255', new SafeInput],
            'barcode_text' => ['required', 'string', 'max:255', new SafeInput],
        ]);

        $product = Products::findOrFail($validated['id']);

        // Update fields
        $product->name = $request->name;
        $product->varian = $request->varian;
        $product->size = $request->size;
        $product->unit = $request->unit;
        $product->barcode = $request->barcode_text;

        if ($request->filled('image_data')) {
            $imageData = $request->input('image_data');

            // Remove the prefix
            [$type, $data] = explode(';', $imageData);
            [, $data] = explode(',', $data);

            // Decode and create image
            $decodedData = base64_decode($data);
            $sourceImage = imagecreatefromstring($decodedData);

            if ($sourceImage === false) {
                return back()->with('error', 'Invalid image data.');
            }

            // Delete old photo if exists
            if ($product->photo && File::exists(public_path($product->photo))) {
                File::delete(public_path($product->photo));
            }

            // Save new photo
            $filename = 'product_' . time() . '.jpg';
            $path = public_path('uploads/products/' . $filename);
            imagejpeg($sourceImage, $path, 90);
            imagedestroy($sourceImage);

            // Update path in DB
            $product->photo = 'uploads/products/' . $filename;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }
    public function delete(Request $request)
    {
        $validated = $request->validate([
            'id' => ['required', 'string', new SafeInput]
        ]);

        $product = Products::find($validated['id']);
        // Delete old photo if exists
        if ($product->photo && File::exists(public_path($product->photo))) {
            File::delete(public_path($product->photo));
        }
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
