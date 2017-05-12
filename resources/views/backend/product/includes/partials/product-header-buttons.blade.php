<div class="pull-right mb-10 hidden-sm hidden-xs">
    {{ link_to_route('admin.product.index', trans('menus.backend.products.all'), [], ['class' => 'btn btn-primary btn-xs']) }}
    {{ link_to_route('admin.product.create', trans('menus.backend.products.create'), [], ['class' => 'btn btn-success btn-xs']) }}
    {{--{{ link_to_route('admin.product.deactivated', trans('menus.backend.access.products.deactivated'), [], ['class' => 'btn btn-warning btn-xs']) }}--}}
    {{ link_to_route('admin.product.deleted', trans('menus.backend.products.deleted'), [], ['class' => 'btn btn-danger btn-xs']) }}
</div><!--pull right-->

<div class="pull-right mb-10 hidden-lg hidden-md">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            {{ trans('menus.backend.products.main') }} <span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu">
            <li>{{ link_to_route('admin.product.index', trans('menus.backend.products.all')) }}</li>
            <li>{{ link_to_route('admin.product.create', trans('menus.backend.products.create')) }}</li>
            <li class="divider"></li>
            {{--<li>{{ link_to_route('admin.product.deactivated', trans('menus.backend.access.products.deactivated')) }}</li>--}}
            {{--<li>{{ link_to_route('admin.product.deleted', trans('menus.backend.access.products.deleted')) }}</li>--}}
        </ul>
    </div><!--btn group-->
</div><!--pull right-->

<div class="clearfix"></div>