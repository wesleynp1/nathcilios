<x-main-template>
    <div class="container">
        <div class="table-responsive">
            <table class="text-center table table-striped table-bordered table-dark mt-2">
                <thead>
                    <th>Nome da cliente</th>
                    <th>Data e Hora marcada</th>
                    <th>Serviço</th>
                    <th colspan="2">Opções</th>
                </thead>

                @foreach ($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->client_name }}</td>
                        <td>{{ date_format($schedule->scheduled_time," d/m/Y H:i") }}</td>
                        <td>{{ $schedule->service_name }}</td>

                        <td><a href="editarAgendamento/{{ $schedule->id }}" class="btn btn-primary">editar</a></td>
                        <td><a href="deletarAgendamento/{{ $schedule->id }}"class="btn btn-danger ">delete</a></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</x-main-template>