<x-main-template extraStyle="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css">
    <x-form-service :service="$service" action="/editarServico/{{$service->id}}"/>
</x-main-template>