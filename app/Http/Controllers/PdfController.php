<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function downloadpdf($id){
        $path = Resource::find($id);

        return response()->download(storage_path( $path->resource), $path->resource);
        
    }
}
