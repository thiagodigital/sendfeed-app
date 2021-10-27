@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.preview') => false,
  ];
  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
	<section class="container-fluid d-print-none">
    	<a href="javascript: window.print();" class="btn float-right"><i class="la la-print"></i></a>
		<h2>
	        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
	        <small>{!! $crud->getSubheading() ?? mb_ucfirst(trans('backpack::crud.preview')).' '.$crud->entity_name !!}.</small>
	        @if ($crud->hasAccess('list'))
	          <small class=""><a href="{{ url($crud->route) }}" class="font-sm"><i class="la la-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
	        @endif
	    </h2>
    </section>
@endsection
{{-- {{ dd($data['subscriber']) }} --}}
@section('content')
<div class="row">
	<div class="{{ $crud->getShowContentClass() }}">

	<!-- Default box -->
	  <div class="">
	  	@if ($crud->model->translationEnabled())
			<div class="row">
				<div class="col-md-12 mb-2">
					<!-- Change translation button group -->
					<div class="btn-group float-right">
					<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{{trans('backpack::crud.language')}}: {{ $crud->model->getAvailableLocales()[request()->input('locale')?request()->input('locale'):App::getLocale()] }} &nbsp; <span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						@foreach ($crud->model->getAvailableLocales() as $key => $locale)
							<a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/show') }}?locale={{ $key }}">{{ $locale }}</a>
						@endforeach
					</ul>
					</div>
				</div>
			</div>
	    @endif
	    <div class="card no-padding no-border">
			<table class="table table-striped mb-0">
		        <tbody>
                    <tr>
		                <td><strong>Nome:</strong></td>
                        <td>{{ $data['subscriber']->name }}</td>
		            </tr>
                    <tr>
                        <td><strong>Telefone:</strong></td>
                        <td>{{ $data['subscriber']->phone }}</td>
		            </tr>
                    <tr>
		                <td><strong>Status:</strong></td>
                        <td>{{ $data['subscriber']->status == 1 ? 'Ativo' : 'Inativo' }}</td>
		            </tr>

            </tbody>
        </table>
        @if ($data['feed_count'] > 0)
        <table class="table table-striped mb-0">
            <tbody>
        <tr>
            <td><strong>Imagem</strong></td>
            <td><strong>Titulo</strong></td>
            <td><strong>Audiencia</strong></td>
        </tr>
        @foreach ($data['feeds'] as $index => $feed)
        <tr>
            <td>
                <span>
                    <img style="width: 25px" src="{{ $feed['image'] }}" alt="" srcset="">
                </span>
            </td>
            <td>
                <a href="{{ $feed['url'] }}" target="_blank">
                    {{ Str::limit($feed['title'], 60, ' [...]') }}
                </a>
            </td>
            <td><strong>{{ $feed['count'] }} click</strong></td>
        </tr>
        @endforeach
            </tbody>
        </table>
        @endif
	    </div><!-- /.box-body -->
	  </div><!-- /.box -->


	</div>
</div>
@endsection


@section('after_styles')
	<link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/crud.css').'?v='.config('backpack.base.cachebusting_string') }}">
	<link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/show.css').'?v='.config('backpack.base.cachebusting_string') }}">
@endsection

@section('after_scripts')
	<script src="{{ asset('packages/backpack/crud/js/crud.js').'?v='.config('backpack.base.cachebusting_string') }}"></script>
	<script src="{{ asset('packages/backpack/crud/js/show.js').'?v='.config('backpack.base.cachebusting_string') }}"></script>
@endsection
