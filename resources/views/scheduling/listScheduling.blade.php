<x-main-template>
    <div class="container">
        <div class="table-responsive">

            @can('isAdmin')   
                <h2>Clique no nome para conversar via WhatsApp</h2>
            @endcan

            <table class="text-center table table-striped table-bordered table-dark mt-2">
                <thead>
                    <th>Nome da cliente</th>
                    <th>Data e Hora marcada</th>
                    <th>Serviço</th>
                    <th>Tipo</th>
                    <th colspan="2">Opções</th>
                </thead>

                @foreach ($schedules as $schedule)
                    <tr>
                        @can('isAdmin')                                
                                <td>                                    
                                    <a href={{ "https://wa.me/".$schedule->phone_number }}>
                                        <u>
                                            {{  $schedule->client_name }}
                                        </u>
                                    </a>
                                </td>
                        @endcan

                        @cannot('isAdmin')
                                <td>{{  $schedule->client_name }}</td>
                        @endcannot

                        <td>{{ date_format($schedule->scheduled_time," d/m/Y H:i") }}</td>
                        <td>{{ $schedule->service_name }}</td>
                        <td>{{ $schedule->maintenance ? "Manutenção" : "Aplicação" }}</td>

                        <td><a href="editarAgendamento/{{ $schedule->id }}" class="btn btn-primary">editar</a></td>
                        <td><a href="deletarAgendamento/{{ $schedule->id }}"class="btn btn-danger ">delete</a></td>
                    </tr>
                @endforeach
            </table>

            <a href="/novaMarcacao" class="btn btn-success my-2">NOVA MARCAÇÃO</a>
        </div>
    </div>
</x-main-template>