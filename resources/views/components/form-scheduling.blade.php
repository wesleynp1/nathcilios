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

<form class="formularioComTelefone formulario container mt-2" id="formScheduling" action="{{ $action }}" method="post" enctype="multipart/form-data">
    @csrf

    @guest
        <div class="mb-3">
            <label for="clientName" class="form-label m-0">Seu nome:</label>
            <input type="text" name="clientName" id="inputClientName" placeholder="Digite seu nome aqui" class="form-control">
        </div>

        <div class="mb-3">
            <label for="clientName" class="form-label m-0">Seu número de telefone:</label>
            <input type="text" name="clientNumber" id="inputClientNumber" inputmode="numeric" placeholder="Digite seu número aqui" class="form-control telefone">
        </div>        
    @endguest

    <div class="mb-3">
        <label for="serviceId" class="form-label m-0">Qual Serviço desejado?</label>
        <select name="serviceId" id="serviceId" class="form-select">
            @foreach ($services as $service)
            <option value="{{ $service->id }}">{{ $service->name }}</option>
            @endforeach
        </select>
    </div>


    <div class="my-4">
        <label for="maintenance">Aplicação ou Manutenção?</label>
        <div class="row p-1" style="background: black; border: white solid 1px;border-radius: 6px;margin:4px 0px">
            <div class="col-6">
                <label for="InputMaintenanceFalse">Aplicação</label>
                <input class="form-check-input" type="radio" name="maintenance" id="InputMaintenanceFalse" value="false" {{ $maintenance==0 ? "checked" : "" }}>
            </div>

            <div class="col-6">
                <label for="InputMaintenanceTrue">Manutenção</label>
                <input class="form-check-input" type="radio" name="maintenance" id="InputMaintenanceTrue" value="true" {{ $maintenance==1 ? "checked" : "" }}>
                <div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label for="select_date" class="form-label m-0">Qual Data e Horário?</label>
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

@guest
    <div>
        <br>
        <h4 class="m-0">DICA</h4>
        
        <a href="/registrar">
            <p class="m-0">
                <U>Clique aqui</U> para criar sua conta
            </p>
            <p class="m-0">
                facilita agendar e pode acompanhar seus agendamentos
            </p>
        </a>
        
    </div>
@endguest

<script src="/js/inputTelefone.js"></script>