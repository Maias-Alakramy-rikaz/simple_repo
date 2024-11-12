<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Importer;

class ImporterController extends Controller
{
    public function show($id){
        $importer = Importer::with(['imports.product'])
        ->findOrFail($id);
        
        $totalPayments = $importer->imports->sum(function ($import){
            return $import->quantity * $import->product->price;
        });
        $data = [
            'importer_info'=>[
                'name' => $importer->full_name,
                'phone_number' => $importer->phone_number,
                'email' => $importer->email,
            ],
            'imports'=>
                $importer->imports->map(function ($import) {
                    return [
                        'imp_date' => $import->imp_date->toDateString(),
                        'product' => $import->product->name,
                        'quantity' => $import->quantity,
                        'product_price' => $import->product->price,
                        'total_price' => $import->quantity * $import->product->price
                    ];
                }),
            "total_payments"=> $totalPayments

        ];

        
        return response()->json([$data]);
    }
}
