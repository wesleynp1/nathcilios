<x-main-template extraStyle="/css/list_service.css">

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
                            <a href="/novaMarcacao/{{ $service->id }}" class="row h-100 container-fluid text-wrap text-break text-start ">
                                <div class="col-6 d-flex align-items-center">
                                    <img src="{{ asset($service->image) }}" alt="" class="img-fluid"/>
                                </div>
                                <div class="col-6 d-flex flex-column justify-content-between">
                                    <h2>{{$service->name}}</h2>
                                    <p class="text-justify">{!! $service->description !!}</p>                        
                                    <h2>R$ {{ str_replace(".",",",$service->price) }}</h2>
                                </div>                            
                            </a>
                            
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