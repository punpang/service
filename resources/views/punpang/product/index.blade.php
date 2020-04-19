@extends('layouts.main')
@section('body')

<h3>รายการสินค้า</h3>
<h6 class="text-muted">สั่งซื้อวันนี้ รับราคาพิเศษ</h6>
<div class="card-columns">
  @foreach ($products as $product)
    <div class="card">
      <img class="card-img-top" src="https://www.punpang.ml/admin_system/home/product/img-products/{{ $product->img }}" alt="Card image cap">
      <div class="card-body pb-0 pt-3 pl-3 pr-3">
        <h5 class="card-title mb-1">{{ $product->products }}</h5>
        <small class="text-muted">รหัสสินค้า : {{ $product->id }}</small>
        <div class="table-resonsive">
          <table class="table table-hover text-center mb-0">
            <tr>
              <td>#</td>
              <td>ราคาปกติ</td>
              <td>ราคาพิเศษ</td>
            </tr>
          @foreach ($product->prices as $price)
            <tr>
                <td>{{ $price->Size->size }}</td>
                <td>
                  @if ($price->price_normal == $price->price)
                    {{ number_format($price->price_normal,2) }}
                  @else
                    <strike class="text-danger">{{ number_format($price->price_normal,2) }}</strike>
                  @endif
                </td>
                <td>
                  @if ($price->price_normal == $price->price)
                    -
                  @else
                    {{ number_format($price->price,2) }}
                  @endif
                </td>
            </tr>
          @endforeach
          </table>
        </div>

      </div>
      @if (count($product->pics) > 0)
        <div class="card-footer p-0 border-0">
          <a class="text-center btn btn-block btn-lg btn-orange border-0 rounded-0" href="{{ action('Punpang\ProductController@ProductId',['id' => $product->id]) }}">รูปเพิ่มเติม</a>
        </div>
      @endif
    </div>
  @endforeach
</div>

@endsection
