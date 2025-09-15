<x-main-template>
    <div class="p-4" style="background-color: #201e1e;">
        <div class="container">
            <h2>DISPONIBILIZAR HORÁRIOS</h2>

            <input type="date" value="{{ date('Y-m-d')}}" min="{{ date('Y-m-d')}}" name="" id="dateInput">
            <input type="time" value="{{ date('H:00')}}" min="{{ date('H:i')}}" class="time-picker" id="timeInput">
            <div class="d-inline-block">
                <button class="btn btn-success" id="botaoAdicionar">ADICIONAR</button>
            </div>
        </div>

        <form action="/agenda/disponibilizar" style="margin-top: 16px" method="post" id="formDisponibilizar">
            @csrf
            <div class="container mt-4">
                <div class="table-responsive">
                    <table class=" table table-striped  table-dark table-bordered">
                        <thead>
                            <th>Datas</th>
                            <th>Horários</th>
                            <th>Remover</th>
                        </thead>
                        <tbody id="tabelaDisponibilizar">
                        </tbody>
                    </table>
                </div>
            </div>

            <input type="submit" value="SALVAR" class="btn btn-primary mt-2">
        </form>
    </div>





    <div class="container" style="margin-top: 48px">
        <h3>Horários com clientes marcados(futuro)</h3>

        <div class="table-responsive">
            <table class=" table table-striped  table-dark table-bordered">
                <thead>
                    <th>Datas</th>
                    <th>Horários</th>
                </thead>

                <tbody>
                    @foreach ($scheduledDatetimes as $key=>$scheduledDatetime)
                    <tr>
                        <td>{{ date_format($scheduledDatetime,"d/m/Y") }}</td>
                        <td>{{ date_format($scheduledDatetime,"H:i") }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <h3>Horários Já diponiveis</h3>
    <div class="container">
        <div class="container table-responsive">
            <table class="text-center table table-striped table-dark table-bordered ">
                <thead>
                    <th>Datas</th>
                    <th>Horários</th>
                </thead>
                <tbody>
                    @foreach ($availableDatetimes as $key=>$availableDatetime)
                    <tr>
                        <td>{{ date_format($availableDatetime,"d/m/Y") }}</td>
                        <td>{{ date_format($availableDatetime,"H:i") }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <a href="/agenda" class="btn btn-secondary mt-2">VOLTAR</a>

        <script>
            contador = 0;

            let horariosJaDisponiveis =     @json($availableDatetimes->map(function($d){return date_format($d,"Y-m-d\TH:i");}));
            let horariosComClienteMarcada = @json($scheduledDatetimes->map(function($d){return date_format($d,"Y-m-d\TH:i");}))

            function remover() {
                document.getElementById("linha" + this.numero).remove();
                document.getElementById("input" + this.numero).remove();
            }

            function incluirNovoInputDataHora(valorNovaDataHora) {
                novoInput = document.createElement("input");
                novoInput.id = "input" + contador;
                novoInput.type = "datetime-local";
                novoInput.value = valorNovaDataHora;
                novoInput.name = "datetimeToAvailable[]";
                novoInput.className = "inputDatetime";
                novoInput.hidden = true;

                document.getElementById("formDisponibilizar").appendChild(novoInput);
            }

            function incluirNovaLinha(valorData,valorTime) {
                //DATA
                TdData = document.createElement("td");
                TdData.innerHTML = valorData[2] + '/' + valorData[1] + '/' + valorData[0];

                //HORA
                TdTime = document.createElement("td");
                TdTime.innerHTML = valorTime;

                //BOTAO REMOVER
                botao = document.createElement("div");
                botao.innerHTML = "X";
                botao.numero = contador;
                botao.id = "remover" + botao.numero;
                botao.onclick = remover;
                botao.className = "btn btn-danger";

                //LINHA
                novaLinha = document.createElement("tr");
                novaLinha.className = "table-info";
                novaLinha.id = "linha" + contador;
                novaLinha.appendChild(TdData);
                novaLinha.appendChild(TdTime);
                novaLinha.appendChild(document.createElement("td")).appendChild(botao);

                //adiciona a nova linha ao formulário
                document.getElementById("tabelaDisponibilizar").appendChild(novaLinha);
            }

            botaoAdicionar.onclick = () => {
                try {
                    let valorData = document.getElementById("dateInput").value.split("-");
                    let valorTime = document.getElementById("timeInput").value;
                    let valorNovaDataHora = valorData[0] + '-' + valorData[1] + '-' + valorData[2] + "T" + valorTime;
                    let datasHorasSelecionados = Array.from(document.getElementsByClassName("inputDatetime")).map(i => i.value);

                    if(horariosJaDisponiveis.includes(valorNovaDataHora))     throw "Este horário já esta disponível!";
                    if(horariosComClienteMarcada.includes(valorNovaDataHora)) throw "Este horário já tem cliente marcado!";
                    if (datasHorasSelecionados.includes(valorNovaDataHora))   throw "Esta Data e Horário já foram selecionados!";
                    if (new Date(valorNovaDataHora) < new Date())             throw "Esta data e horário já passaram!";

                    incluirNovaLinha(valorData,valorTime);
                    incluirNovoInputDataHora(valorNovaDataHora);
                    contador++;
                } catch (err) {
                    alert(err);
                }
            }
        </script>
</x-main-template>