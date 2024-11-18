<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductsCompareExport implements FromView
{
    protected $product1;
    protected $product2;
    protected $product3;
    protected $compareCates;
    protected $valueCompares;
    protected $compareProduct1;
    protected $compareProduct2;
    protected $compareProduct3;

    public function __construct($product1, $product2, $product3,
                $compareCates, $valueCompares,
                $compareProduct1, $compareProduct2, $compareProduct3)
    {
        $this->product1 = $product1;
        $this->product2 = $product2;
        $this->product3 = $product3;
        $this->compareCates = $compareCates;
        $this->valueCompares = $valueCompares;
        $this->compareProduct1 = $compareProduct1;
        $this->compareProduct2 = $compareProduct2;
        $this->compareProduct3 = $compareProduct3;
    }

    public function view(): View
    {
        return view('exports.products_compare', [
            'product1' => $this->product1,
            'product2' => $this->product2,
            'product3' => $this->product3,
            'compareCates' => $this->compareCates,
            'valueCompares' => $this->valueCompares,
            'compareProduct1' => $this->compareProduct1,
            'compareProduct2' => $this->compareProduct2,
            'compareProduct3' => $this->compareProduct3,
        ]);
    }
}
