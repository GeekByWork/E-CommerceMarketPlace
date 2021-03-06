@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Cart</div>

                <div class="panel-body">
                    <div class="col-md-8">
                    {{ empty($product_ids) ? "Your cart is empty" : ""}}
                    <table class="table bottomborder">
                      @php $total_price = 0.0; @endphp
                      @foreach ($product_ids as $product_id)
                           @php
                              $product = $products[$product_id];
                              $product_details = json_decode($product->cached_api_response, true);
                              $price = (float)str_replace(["$"], [""], $product_details['price']);
                              $quantity =(int)($cart_items[$product_id]);
                              $total_price += $price * $quantity;
                              $price ='$' . number_format($price, 2);
                           @endphp
                             <tr>
                                <td>
                                  <a href="/sellers/{{$product->seller_id}}/products/{{$product->seller_product_id}}">
                                  <img src="{{ urldecode($product_details['image_url']) }}" alt="Avatar" style="width:80px; height: 108px; margin-left:10px;">
                                  </a>
                                </td>
                                <td>
                                  <a href="/sellers/{{$product->seller_id}}/products/{{$product->seller_product_id}}">
                                    <b>{{ (strlen($product_details['name']) <= 18 ? $product_details['name'] : substr($product_details['name'], 0, 18) . " ...") }}</b>
                                  </a>
                                </td>
                                <td>
                                  <a href="/sellers/{{ $product->seller_id }}">{{ $product->seller->name }}</a>
                                </td>
                                <td>
                                  <b>{{ $price }} &#x2a2f {{ $quantity }}</b>
                                </td>
                                <td>
                                  <form action="/cart" method="post">
                                        {{ method_field('PATCH') }}
                                        {{ csrf_field() }}
                                        <input type="hidden" name="product_id" value={{$product_id}} />
                                        <button type="submit" class="btn btn-danger">
                                          <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                          Remove item
                                        </button>
                                  </form>
                                </td>
                            </tr>
                      @endforeach
                    </table>
                    </div>
                    <div class="col-md-4">
                      <h3>Total Price</h3>
                      <h3>{{ /*money_format('%.2n', $total_price)*/'$' . number_format($total_price, 2) }}</h3>
                      <form action="/orders/create">
                            <button type="submit" class="btn btn-success">
                              <span class="glyphicon glyphicon-barcode" aria-hidden="true"></span>
                              Checkout
                            </button>
                      </form>
                      <br/>
                      <a href="/home">
                      <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Back to products
                      </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

