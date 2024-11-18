<!-- resources/views/exports/products_compare.blade.php -->
<table>
    <thead>
        <tr>
            <th colspan="{{ !empty($product3) ? 4 : 3 }}" style="text-align: center; background-color: #76b900;">
                <strong>SO SÁNH SẢN PHẨM</strong>
            </th>        
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>TÊN SẢN PHẨM</td>
            <td><strong>{{ $product1->name }}</strong></td>
            <td><strong>{{ $product2->name }}</strong></td>
            @if(!empty($product3))
            <td><strong>{{ $product3->name }}</strong></td>
            @endif
        </tr>
        @foreach($compareCates as $cates)
        <tr>
            <td style="background-color: #76b900;">
                <strong>{{ $cates->name }}</strong>
            </td>
            <td colspan="{{ !empty($product3) ? 3 : 2 }}"></td>
        </tr>
        @foreach($valueCompares[$cates->id] as $compare)
        <tr>
            <td style="text-transform: uppercase;">
                <strong>{{ $compare->key_word }}</strong>
            </td>
            <td>
                @if(isset($compareProduct1[$compare->id]))
                {{ $compareProduct1[$compare->id]->display_compare }}
                @endif
            </td>
            <td>
                @if(isset($compareProduct2[$compare->id]))
                {{ $compareProduct2[$compare->id]->display_compare }}
                @endif
            </td>
            @if(isset($compareProduct3[$compare->id]))
            <td>
                {{ $compareProduct3[$compare->id]->display_compare }}
            </td>
            @endif
        </tr>
        @endforeach
        @endforeach
    </tbody>
</table>