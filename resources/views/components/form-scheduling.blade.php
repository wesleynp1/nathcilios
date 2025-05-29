@php
    //SET THE FIRST SERVICE SHOWN

    if( isset($scheduling->serviceId) || isset($serviceIntentedId) )
    {
        $criterion= isset($scheduling->serviceId) ? $scheduling->serviceId : $serviceIntentedId;

        $oldFirst = $services[0];

        foreach ($services as $key=>$service){
            if($service->id == $criterion){
                $services[0] = $service;
                $services[$key] = $oldFirst;
            } 
        }
    }
@endphp

<form class="form container mt-2" id="formScheduling" action="{{ $action }}" method="post" enctype="multipart/form-data">
    @csrf
    
    <div class="mb-3">
        <label for="serviceId" class="form-label m-0">Servico</label>
        <select name="serviceId" id="serviceId" class="form-select">
            @foreach ($services as $service)
                <option value="{{ $service->id }}">{{ $service->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="select_date" class="form-label m-0">Data</label>
        <select name="scheduled_time" id="select_date" class="form-select">
            @if(isset($scheduling->scheduled_time))
                <option value="{{ $scheduling->scheduled_time }}">{{ $scheduling->scheduled_time }}</option>
            @endif

            @foreach($datetimes as $datetime)
                @if(empty($scheduling) || $datetime != $scheduling->scheduled_time)
                    <option value="{{ $datetime }}">{{ date_format(date_create($datetime),"d/m/Y - H:i") }}</option>
                @endif
            @endforeach
        </select>
    </div>

    <input type="submit" id="botaoSubmit" value="CADASTRAR" class="btn btn-primary mt-2">
</form> 