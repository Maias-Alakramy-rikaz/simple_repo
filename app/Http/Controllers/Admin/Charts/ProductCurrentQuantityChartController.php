<?php

namespace App\Http\Controllers\Admin\Charts;

use Backpack\CRUD\app\Http\Controllers\ChartController;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

/**
 * Class ProductCurrentQuantityChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCurrentQuantityChartController extends ChartController
{
    public function setup()
    {

        $this->chart = new Chart();

        // MANDATORY. Set the labels for the dataset points
        $this->chart->labels(\App\Models\Product::all()->sortByDesc('current_quantity')->pluck('code'));

        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(backpack_url('charts/product-current-quantity'));

        // OPTIONAL
        // $this->chart->minimalist(false);
        // $this->chart->displayLegend(true);
    }

    /**
     * Respond to AJAX calls with all the chart data points.
     *
     * @return json
     */
    public function data()
    {
        $Products = \App\Models\Product::all()->sortByDesc('current_quantity')->pluck('current_quantity');
        
        $this->chart->dataset('الكميات الحالية من المنتجات', 'bar', $Products)
            ->color('rgba(205, 32, 31, 1)')
            ->backgroundColor('rgba(205, 32, 31, 0.4)');
    }
}