@php
    $Products = App\Models\Product::with(['imports','exports'])->get()->map(function ($product) {
            $totalExports = $product->exports->sum('quantity');
            $product->total_exports = $totalExports;
        
            $totalImports = $product->imports->sum('quantity');
            $product->total_imports = $totalImports;

            return $product;
        });
@endphp

<div class="col-sm-6 col-md-4">
	<div class="card text-white bg-primary">
	  <div class="card-header">المواد ومجموع صادراتها ووارداتها</div>
	  <div class="card-body">
        <ul>
            @foreach($Products as $product)
                <li>{{$product->name.":"}}
                    <ul>
                    <li>{{"كمية الصادرات: ".$product->total_exports}}</li>
                    <li>{{"كمية الواردات: ".$product->total_imports}}</li>
                    </ul>
                </li>
            @endforeach
        </ul>

	  </div>
	</div>
  </div>