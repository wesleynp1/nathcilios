<x-main-template>
     <h1>Realize sua marcação</h1>
    <h2>Escolha o serviço, data e horário desejados</h2>    
    <x-form-scheduling :serviceIntentedId="$serviceIntentedId" :datetimes="$datetimes" :services="$services" action="/novaMarcacao"/>
</x-main-template>