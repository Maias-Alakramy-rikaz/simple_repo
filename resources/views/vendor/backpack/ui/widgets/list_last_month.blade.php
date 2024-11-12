@php
    use Carbon\Carbon;
    $Products = App\Models\Product::with([
            'imports'=> function($query){
                $query->whereBetween('imp_date', [Carbon::now()->subMonth(), Carbon::now()]);
            },
            'exports'=> function($query){
                $query->whereBetween('exp_date', [Carbon::now()->subMonth(), Carbon::now()]);
            }])->get()->map(function ($product) {
            $totalExports = $product->exports->sum('quantity');
            $product->total_exports = $totalExports;
        
            $totalImports = $product->imports->sum('quantity');
            $product->total_imports = $totalImports;

            return $product;
        });
@endphp

<div class="col-sm-6 col-md-4">
	<div class="card text-white bg-primary">
	  <div class="card-header">المواد ومجموع صادراتها ووارداتها في الشهر الأخير</div>
	  <div class="card-body">
          <ul>
            @foreach($Products as $product)
                @if(!($product->total_exports==0 && $product->total_imports==0))
                    <li>{{$product->name.":"}}
                        <ul>
                        <li>{{"كمية الصادرات: ".$product->total_exports}}</li>
                        <li>{{"كمية الواردات: ".$product->total_imports}}</li>
                        </ul>
                    </li>
                @endif
            @endforeach
        </ul>

	  </div>
	</div>
  </div>