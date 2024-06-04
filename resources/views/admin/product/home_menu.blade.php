<div class="card-body">
    <div class="row">
        <div class="@if (request()->routeIs('product.index') || request()->routeIs('category.index') || request()->routeIs('units.index')) col-md-12 @else col-md-4 @endif col-sm-6 col-4">
            <a href="{{ route('product.index') }}" style="text-decoration: none" class="text-dark">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card bg-info">
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <span class=""><i style="font-size: 25px" class="fas fa-barcode"></i></span>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="">
                                            <span class="info-box-text">قائمة الاصناف</span>
                                            <span class="info-box-number">{{ $product_count }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="@if (request()->routeIs('product.index') || request()->routeIs('category.index') || request()->routeIs('units.index')) col-md-12 @else col-md-4 @endif col-sm-6 col-4">
            <a href="{{ route('category.index') }}" style="text-decoration: none" class="text-dark">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card bg-success">
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <span class=""><i style="font-size: 25px" class="fa fa-list"></i></span>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="">
                                            <span class="info-box-text">مجموعات الاصناف</span>
                                            <span class="info-box-number">{{ $category_count }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="@if (request()->routeIs('product.index') || request()->routeIs('category.index') || request()->routeIs('units.index')) col-md-12 @else col-md-4 @endif col-sm-6 col-4">
            <a href="{{ route('units.index') }}" style="text-decoration: none" class="text-dark">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card bg-warning">
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <span class=""><i style="font-size: 25px" class="fa fa-group-arrows-rotate"></i></span>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="">
                                            <span class="info-box-text">الوحدات</span>
                                            <span class="info-box-number">{{ $unit_count }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>




{{--        <div class="col-md-12 col-sm-6 col-12">--}}
{{--            <a href="{{ route('category.index') }}" style="text-decoration: none" class="text-dark">--}}
{{--                <div class="info-box">--}}
{{--                    <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>--}}
{{--                    <div class="info-box-content">--}}
{{--                        <span class="info-box-text">مجموعات الأصناف</span>--}}
{{--                        <span class="info-box-number">{{ $category_count }}</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </a>--}}
{{--        </div>--}}

{{--        <div class="col-md-12 col-sm-6 col-12">--}}
{{--            <a href="{{ route('units.index') }}" style="text-decoration: none" class="text-dark">--}}
{{--                <div class="info-box">--}}
{{--                    <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>--}}
{{--                    <div class="info-box-content">--}}
{{--                        <span class="info-box-text">الوحدات</span>--}}
{{--                        <span class="info-box-number">{{ $unit_count }}</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </a>--}}
{{--        </div>--}}
    </div>
</div>
