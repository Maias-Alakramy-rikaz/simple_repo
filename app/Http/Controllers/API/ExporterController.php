<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exporter;

class ExporterController extends Controller
{
    public function show($id){
        $exporter = Exporter::with(['exports.product'])
        ->findOrFail($id);
        
        $totalPayments = $exporter->exports->sum(function ($export){
            return $export->quantity * $export->product->price;
        });
        $data = [
            'exporter_info'=>[
                'name' => $exporter->full_name,
                'phone_number' => $exporter->phone_number,
                'email' => $exporter->email,
            ],
            'exports'=>
                $exporter->exports->map(function ($export) {
                    return [
                        'exp_date' => $export->exp_date->toDateString(),
                        'product' => $export->product->name,
                        'quantity' => $export->quantity,
                        'product_price' => $export->product->price,
                        'total_price' => $export->quantity * $export->product->price
                    ];
                }),
            "total_payments"=> $totalPayments

        ];

        
        return response()->json([$data]);
    }
}
