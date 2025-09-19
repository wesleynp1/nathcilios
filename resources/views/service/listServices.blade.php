<x-main-template extraStyle="/css/list_service.css">

    <h1>Serviços e Técnicas Oferecidas</h1>
    <p>Clique em um dos serviços para realizar uma marcação</p>

    @can('isAdmin')
    <a href="/novoServico">        
            <p id="newServiceButton">+ Cadastrar Novo Servico</p>        
    </a> 
    @endcan

    <div class="fluid-container">
        <div id="container-services" class="row m-0 justify-content-evenly">        
                @foreach ($services as $service)
                <div class="p-1 col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
                    <div class="service h-100">
                        <div class="d-flex flex-column">
                            <div class="row h-100 container-fluid text-wrap text-break text-start ">
                                <div class="col-6 d-flex align-items-center">
                                    <img src="{{ asset($service->image) }}" alt="" class="img-fluid"/>
                                </div>
                                <div class="col-6 d-flex flex-column justify-content-between">
                                    <h2>{{$service->name}}</h2>
                                    <div class="text-justify">{!! str_replace("\n","<br>",$service->description) !!}</div>
                                    <p class="text-center">
                                        <a class="btn btn-secondary p-2" href="/novaMarcacao/{{ $service->id }}/0">Aplicação: R$ {{ str_replace(".",",",$service->price) }}</a>
                                    </p>
                                    @if(!empty($service->maintenance_price))
                                        <p class="text-center">
                                            <a class="btn btn-secondary p-2" href="/novaMarcacao/{{ $service->id }}/1">Manutenção: R$ {{ str_replace(".",",",$service->maintenance_price) }}</a>
                                        </p>                                    
                                    @endif
                                </div>                      
                            </div>
                            
                            @can('isAdmin')
                                <div>
                                    <a href="/deletarServico/{{ $service->id }} " class="btn btn-danger">deletar</a>
                                    <a href="/editarServico/{{ $service->id }}"   class="btn btn-primary">editar</a>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</x-main-template>