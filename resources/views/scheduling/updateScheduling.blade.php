<x-main-template>

        <x-form-scheduling :datetimes="$datetimes"  :services="$services" :scheduling="$scheduling" action="/editarAgendamento/{{$scheduling->id}}"/>
        
</x-main-template>