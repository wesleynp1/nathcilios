<x-main-template>
        <h1>Edite sua marcação</h1>
        <h2>Escolha o serviço, data e horário desejados</h2>   
        <x-form-scheduling :datetimes="$datetimes"  :services="$services" :scheduling="$scheduling" action="/editarAgendamento/{{$scheduling->id}}"/>        
</x-main-template>