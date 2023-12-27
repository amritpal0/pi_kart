@php
    $total = 0;
    $carts = get_user_cart();
    if(count($carts) > 0) {
        foreach ($carts as $key => $cartItem) {
            $product = get_single_product($cartItem['product_id']);
            $total = $total + cart_product_price($cartItem, $product, false) * $cartItem['quantity'];
        }
    }
@endphp
<!-- Cart button with cart count -->
<a href="javascript:void(0)" class="d-flex align-items-center text-dark px-3 h-100" data-toggle="dropdown" data-display="static" title="{{translate('Cart')}}">
    <span class="mr-2">
    <svg class="icon-bag " aria-hidden="true" focusable="false" role="presentation" xmlns="http://www.w3.org/2000/svg" width="21" height="23" viewBox="0 0 22 24" fill="none">
    <path d="M6.91699 10.993V4.95104C6.91699 2.72645 8.70785 0.923065 10.917 0.923065C13.1261 0.923065 14.917 2.72645 14.917 4.95104V10.993" stroke="#000" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"></path>
    <path fill-rule="evenodd" clip-rule="evenodd" d="M18.131 23.0769C19.6697 23.0769 20.917 21.8209 20.917 20.2714C20.9174 20.1285 20.9067 19.9857 20.885 19.8445L19.221 8.95686C19.0463 7.81137 18.0679 6.96551 16.917 6.96503H4.917C3.76678 6.96536 2.78859 7.81016 2.613 8.95485L0.949001 19.8545C0.927336 19.9958 0.916636 20.1386 0.917001 20.2815C0.92251 21.827 2.16823 23.0769 3.703 23.0769H18.131Z" stroke="#000" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
    </span>
    <!-- <span class="d-none d-xl-block ml-2 fs-14 fw-700 text-white">{{ single_price($total) }}</span> -->
    <span class="nav-box-text cart_count_span d-none d-xl-block fs-12">

        (<span class="cart-count">{{count($carts) > 0 ? count($carts) : 0 }}</span>)

    </span>
</a>

<!-- Cart Items -->
<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg p-0 stop-propagation rounded-0">
    @if (isset($carts) && count($carts) > 0)
        <div class="fs-16 fw-700 text-soft-dark pt-4 pb-2 mx-4 border-bottom" style="border-color: #e5e5e5 !important;">
            {{ translate('Cart Items') }}
        </div>
        <!-- Cart Products -->
        <ul class="h-360px overflow-auto c-scrollbar-light list-group list-group-flush mx-1">
            @foreach ($carts as $key => $cartItem)
                @php
                    $product = get_single_product($cartItem['product_id']);
                @endphp
                @if ($product != null)
                    <li class="list-group-item border-0 hov-scale-img">
                        <span class="d-flex align-items-center">
                            <a href="{{ route('product', $product->slug) }}"
                                class="text-reset d-flex align-items-center flex-grow-1">
                                <img src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                    data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                    class="img-fit lazyload size-60px has-transition"
                                    alt="{{ $product->getTranslation('name') }}"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                <span class="minw-0 pl-2 flex-grow-1">
                                    <span class="fw-700 fs-13 text-dark mb-2 text-truncate-2" title="{{ $product->getTranslation('name') }}">
                                        {{ $product->getTranslation('name') }}
                                    </span>
                                    <span class="fs-14 fw-400 text-secondary">{{ $cartItem['quantity'] }}x</span>
                                    <span class="fs-14 fw-400 text-secondary">{{ cart_product_price($cartItem, $product) }}</span>
                                </span>
                            </a>
                            <span class="">
                                <button onclick="removeFromCart({{ $cartItem['id'] }})"
                                    class="btn btn-sm btn-icon stop-propagation">
                                    <i class="la la-close fs-18 fw-600 text-secondary"></i>
                                </button>
                            </span>
                        </span>
                    </li>
                @endif
            @endforeach
        </ul>
        <!-- Subtotal -->
        <div class="px-3 py-2 fs-15 border-top d-flex justify-content-between mx-4" style="border-color: #e5e5e5 !important;">
            <span class="fs-14 fw-400 text-secondary">{{ translate('Subtotal') }}</span>
            <span class="fs-16 fw-700 text-dark">{{ single_price($total) }}</span>
        </div>
        <!-- View cart & Checkout Buttons -->
        <div class="py-3 text-center border-top mx-4" style="border-color: #e5e5e5 !important;">
            <div class="row gutters-10 justify-content-center">
                <div class="col-sm-6 mb-2">
                    <a href="{{ route('cart') }}" class="btn btn-secondary-base btn-sm btn-block rounded-4 text-white">
                        {{ translate('View cart') }}
                    </a>
                </div>
                @if (Auth::check())
                <div class="col-sm-6">
                    <a href="{{ route('checkout.shipping_info') }}" class="btn btn-primary btn-sm btn-block rounded-4">
                        {{ translate('Checkout') }}
                    </a>
                </div>
                @endif
            </div>
        </div>
    @else
        <div class="text-center p-3">
            <i class="las la-frown la-3x opacity-60 mb-3"></i>
            <h3 class="h6 fw-700">{{ translate('Your Cart is empty') }}</h3>
        </div>
    @endif
</div>
