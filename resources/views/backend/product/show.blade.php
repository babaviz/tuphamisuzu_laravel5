@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.products.management'))

@section('after-styles')
    {{ Html::style("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}
@endsection

@section('page-header')
    <h1>
        {{ trans('labels.backend.products.management') }}
    </h1>
@endsection

@section('content')



    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.products.view') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.product.includes.partials.product-header-buttons')
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">

            <?php var_dump($product); ?>

        </div><!-- /.box-body -->
    </div><!--box-->
@endsection
