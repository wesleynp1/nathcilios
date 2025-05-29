<x-main-template>

    @can('isAdmin')
        <h2>HORÁRIOS COM CLIENTES MARCADOS</h2>
        <div class="container">
            <div class="table-responsive">
                <table class="text-center table table-striped table-dark table-responsive table-bordered ">
                    <thead>
                        <th>Datas</th>
                        <th>Horários</th>
                    </thead>

                    <tbody>
                        @foreach ($scheduledDatetimes as $key=>$scheduledDatetime)
                            <tr>
                                <td>{{ $scheduledDatetime->format("d/m/Y") }}</td>
                                <td>{{ $scheduledDatetime->format("H:i") }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endcan

    <h2>HORÁRIOS DISPONÍVEIS</h2>
    
    @can('isAdmin')
        <p>desmarque e depois salve para indisponibilizar os horários</p>

        <form action="/agenda" method="post">
            @csrf
            <div class="container">
                <div class="container table-responsive">
                    <table class="text-center table table-striped table-dark table-bordered ">
                        <thead>
                            <th>Datas</th>
                            <th>Horários</th>
                            <th>Indisponibilizar</th>
                        </thead>
                        <tbody>
                            @foreach ($availableDatetimes as $key=>$availableDatetime)
                                <tr>
                                    <td>{{ $availableDatetime->format("d/m/Y") }}</td>
                                    <td>{{ $availableDatetime->format("H:i") }}</td>
                                    <td>
                                        <input type="checkbox" name="{{ 'datesToUnavailable[' . $key . ']' }}" value="{{ $availableDatetime->format('Y-m-d H:i:s') }}" id="{{ 'date'. $key }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <input type="submit" value="SALVAR" class="btn btn-primary mt-2">
        </form>

        <a href="agenda/disponibilizar" class="btn btn-success mt-2">DISPONIBILIZAR NOVOS HORÁRIOS</a>
    @endcan

    @cannot('isAdmin')
        <div class="container">
            <div class="container table-responsive">
                <table class="text-center table table-striped table-dark table-bordered ">
                    <thead>
                        <th>Datas</th>
                        <th>Horários</th>
                    </thead>
                    <tbody>
                        @foreach ($availableDatetimes as $availableDatetime)
                            <tr>
                                <td>{{ $availableDatetime->format("d/m/Y") }}</td>
                                <td>{{ $availableDatetime->format("H:i") }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endcannot

</x-main-template>