@php
	[$locationParam] = $this->getParams();
@endphp
	<div class="row-fluid">

    @if (count($this->getLocations()) > 1)
	<div class="list-filter" id="filter-list-filter">

	    <form id="filter-form" class="form-inline" accept-charset="utf-8" method="GET" action="<?= admin_url('thoughtco/customerdisplay/summary'); ?>" role="form">

	        <div class="d-sm-flex flex-sm-wrap w-100 no-gutters">

				<div class="col col-11">

					<div class="filter-scope date form-group">

						<select name="location" class="form-control select2-hidden-accessible">
							@foreach ($this->getLocations() as $key=>$location)
                            <option value="{{ $key }}" @if ($key == $locationParam) selected @endif>{{ $location }}</option>
                            @endforeach
            			</select>

            		</div>

		        </div>

				<div class="col col-1">

					<button type="submit" class="btn btn-primary float-right">@lang('lang:thoughtco.customerdisplay::default.btn_view')</button>

				</div>

	    	</div>

		</form>

	</div>
    @endif

	<div class="row">

		@foreach ($this->renderResults() as $order)
		 <div class="col col-12">
			<div class="card w-100">
				<div class="card-body" style="background-color: {{ $order->status_color }}">
					<h2 class="card-title mb-1 fa-5x text-center">{!! sprintf(lang('lang:thoughtco.customerdisplay::default.text_'.$order->status), $order->name, $order->id) !!}</h2>
				</div>
			</div>
		 </div>
         @endforeach

	</div>

</div>
