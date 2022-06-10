
    <div class="sticky-top z-3 row gutters-10">
        @php
            $photos = explode(',', $product_variant_image->image);
        @endphp
        <div class="col order-1 order-md-2">
            <div class="aiz-carousel product-gallery" data-nav-for='.product-gallery-thumb' data-fade='true' data-auto-height='true'>
                @foreach ($photos as $key => $photo)
                    <div class="carousel-box img-zoom rounded">
                        <img
                            class="img-fluid lazyload"
                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                            data-src="{{ uploaded_asset($photo) }}"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                        >
                    </div>
                @endforeach
                
            </div>
        </div>
        <div class="col-12 col-md-auto w-md-80px order-2 order-md-1 mt-3 mt-md-0">
            <div class="aiz-carousel product-gallery-thumb" data-items='5' data-nav-for='.product-gallery' data-vertical='true' data-vertical-sm='false' data-focus-select='true' data-arrows='true'>
                @foreach ($photos as $key => $photo)
                <div class="carousel-box c-pointer border p-1 rounded">
                    <img
                        class="lazyload mw-100 size-50px mx-auto"
                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                        data-src="{{ uploaded_asset($photo) }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                    >
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <script src="{{ static_asset('assets/js/aiz-core.js') }}" ></script>