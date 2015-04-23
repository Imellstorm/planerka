<div class="col-md-4">
    <div class="block">
        <div class="block_header"><i class="fa fa-search icon"></i>{{ Lang::get('main.searchlots') }}</div>
        {{ Form::open(array('role'=>'form', 'url'=>'/', 'class'=>'search_form', 'method' => 'GET')) }}
            <div class='form-group'>
                {{ Form::select('ownership', $ownerships,null,array('class'=>'form-control')); }}
            </div>
            <div class='form-group'>
                {{ Form::select('nds', $nds,null,array('class'=>'form-control')); }}
            </div>
            <div class='form-group'>
                {{ Form::select('region', $regions,null,array('class'=>'form-control','onChange'=>'getCityList(this.selectedIndex)')); }}
            </div>
            <div class="form-group city_list">
            </div>
            <div class='form-group'>
                {{ Form::text('name', null, array('placeholder' => Lang::get('main.title'), 'class' => 'form-control')) }}
            </div> 
            <div class='form-group'>
                <div class="layout-slider">
                    <label style="margin-bottom:20px">{{ Lang::get('main.price') }}</label>
                    <input name="price" type="hidden" class="range-slider" value="{{ $price['min'] }},{{ $price['max'] }}" />
                </div>
            </div>
            @if(!empty($licenses))
                <div class='form-group licenses'>
                    <label class="pointer toggle_licenses" style="margin-top:20px"><i class="fa fa-plus-circle"></i> {{ Lang::get('main.license') }}</label>
                    <div class="licenses_box">
                        @foreach($licenses as $key => $val)
                            <div>
                                <label class="license_label">
                                    <div style="float:left">
                                        <input name="license[]" type="checkbox" value="{{ $val->id }}">
                                    </div>
                                    <div data-toggle="tooltip" data-placement="top" title="{{ $locale=='ru'?$val->name:$val->name_ukr }}">
                                        {{ $locale=='ru'?$val->abr:$val->abr_ukr }}
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>                                          
                </div>
            @endif
            <div class='form-group' style="text-align:center">
                {{ Form::submit( Lang::get('main.search'), array('class' => 'btn btn-success')) }}
            </div>                                                                             
        {{ Form::close() }}
    </div>
</div>