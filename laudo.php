<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="tituloPagina">Eletrônica Clara - Laudo Técnico</title>
    <style>
        :root {
            --border-color: #333;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #000;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .laudo-container {
            max-width: 800px;
            background: #fff;
            margin: 0 auto;
            padding: 30px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-box {
            width: 70px;
            height: 70px;
            border: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            background: #ffeb3b;
            font-weight: bold;
        }

        .company-name {
            font-size: 22px;
            font-weight: bold;
            line-height: 1.2;
        }

        .company-details {
            font-size: 12px;
            line-height: 1.4;
            text-align: right;
        }

        .laudo-title-box {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .client-section {
            margin-bottom: 15px;
            font-weight: bold;
            position: relative;
        }

        .client-row {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 4px;
        }

        .client-row input {
            font-weight: normal;
            padding: 5px;
            width: 70%;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .cnpj-row {
            font-size: 13px;
            color: #444;
            padding-left: 195px;
            margin-bottom: 8px;
        }

        .cnpj-row input {
            font-weight: normal;
            padding: 2px 4px;
            width: 40%;
            border: 1px solid #ddd;
            background: #fafafa;
            font-size: 12px;
        }

        #listaSugestoes {
            position: absolute;
            top: 100%;
            left: 195px;
            width: 70%;
            background: #fff;
            border: 1px solid #ccc;
            max-height: 220px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .sugestao-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 13px;
            font-weight: normal;
            border-bottom: 1px solid #eee;
        }

        .sugestao-item:hover {
            background-color: #f0f0f0;
        }

        .sugestao-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
            flex: 1;
        }

        .sugestao-cnpj {
            font-size: 11px;
            color: #666;
        }

        .acoes-item {
            display: flex;
            gap: 5px;
        }

        .btn-acao {
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 14px;
            padding: 2px 6px;
            border-radius: 3px;
        }

        .btn-acao:hover {
            background-color: #e2e8f0;
        }

        .btn-novo-cliente {
            background-color: #2563eb !important;
            color: white !important;
            font-weight: bold !important;
            text-align: center;
            display: block !important;
            padding: 9px 12px !important;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .form-group textarea {
            width: 100%;
            height: 120px;
            padding: 10px;
            font-family: Arial, sans-serif;
            font-size: 13px;
            border: 1px solid #ccc;
            resize: vertical;
            line-height: 1.4;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            table-layout: fixed;
        }

        th, td {
            border: 1px solid var(--border-color);
            padding: 8px;
            text-align: left;
            font-size: 13px;
            vertical-align: middle;
            word-wrap: break-word;
        }

        th {
            background-color: #f0f0f0;
            color: #000;
            font-weight: bold;
        }

        td input {
            width: 100%;
            border: none;
            background: transparent;
            font-size: 13px;
            outline: none;
            color: #000;
        }

        td input:focus {
            background: #fffdf0;
        }

        .text-center { text-align: center; }

        .technician {
            font-weight: bold;
            margin-bottom: 30px;
        }

        .footer-company {
            font-size: 11px;
            line-height: 1.4;
            border-top: 1px dashed #999;
            padding-top: 15px;
        }

        .no-print {
            text-align: center;
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        button {
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            border-radius: 4px;
        }

        .btn-back { background-color: #64748b; color: white; }
        .btn-print { background-color: #10b981; color: white; }
        button:hover { opacity: 0.9; }

        @media print {
            @page { margin: 10mm; }
            body { background: none; padding: 0; }
            .laudo-container { border: none; box-shadow: none; padding: 0; max-width: 100%; }
            .no-print { display: none; }
            #listaSugestoes { display: none !important; }
            textarea { border: none !important; background: transparent !important; resize: none; }
            td input { border: none !important; background: transparent !important; }
            .cnpj-row input { border: none !important; background: transparent !important; }
        }
    </style>
</head>
<body>

<div class="laudo-container">
    <div class="header">
        <div class="logo-area">
            <div class="logo-box">⚡</div>
            <div class="company-name">Eletrônica<br>Clara</div>
        </div>
        <div class="company-details">
            André Antônio<br>
            Tel.: (71) 99244-9404<br>
            eletronicaclara@gmail.com
        </div>
    </div>

    <div class="laudo-title-box">
        LAUDO TÉCNICO
    </div>

    <div class="client-section">
        <div class="client-row">
            <span>Serviço destinado ao cliente:</span> 
            <input type="text" id="clienteInput" oninput="filtrarClientes(); atualizarTitulo()" onfocus="filtrarClientes()" placeholder="Digite o nome do cliente...">
        </div>
        <div class="cnpj-row">
            CNPJ: <input type="text" id="cnpjInput" placeholder="CNPJ do estabelecimento">
        </div>
        <div id="listaSugestoes"></div>
        <div style="margin-top: 8px;"><strong>Data:</strong> <span id="lblData">03/10/2026</span></div>
    </div>

    <div class="form-group">
        <label for="txtMotivo">Parecer Técnico / Motivo:</label>
        <textarea id="txtMotivo">O equipamento apresentado acima apresenta defeito em seus componentes internos, constatado após testes que a placa principal não está funcionando adequadamente e que o reparo em placa pode não solucionar o problema, sendo mais viável o descarte ou a troca completa do item.</textarea>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 28%;">Marca / Modelo</th>
                <th style="width: 28%;">Série / Patrimônio</th>
                <th style="width: 24%;">Defeito</th>
                <th style="width: 20%;">Custo + Mão de Obra</th>
            </tr>
        </thead>
        <tbody id="tabelaLaudoItens">
            <!-- Preenchido via JS -->
        </tbody>
    </table>

    <div class="technician">
        Técnico Responsável: André Antônio
    </div>

    <div class="footer-company">
        Eletrônica Clara CNPJ - 23.024.997/0001-15<br>
        Rua Jardim Concórdia, 62 - Brotas - Salvador - Ba<br>
        CEP: 40.255.070
    </div>
</div>

<div class="no-print">
    <button class="btn-back" onclick="window.close()">✕ Fechar Guia</button>
    <button class="btn-print" onclick="imprimirLaudo()">🖨️ Imprimir / Salvar PDF</button>
</div>

<script>
    let listaHoteisSistema = [];
    let dataOsGlobal = "03/10/2026";

    async function carregarClientesServidor() {
        try {
            let resposta = await fetch('api.php?acao=obter_dados');
            let dados = await resposta.json();
            if (dados.clientes) {
                listaHoteisSistema = dados.clientes;
            }
        } catch (e) {
            console.error("Erro ao carregar clientes:", e);
        }
    }

    carregarClientesServidor();

    function filtrarClientes() {
        const input = document.getElementById('clienteInput');
        const cnpjInput = document.getElementById('cnpjInput');
        const filtro = input.value.trim().toLowerCase();
        const container = document.getElementById('listaSugestoes');
        
        container.innerHTML = '';
        const filtrados = listaHoteisSistema.filter(h => 
            h.nome.toLowerCase().includes(filtro) || (h.cnpj && h.cnpj.toLowerCase().includes(filtro))
        );
        
        const existeExato = listaHoteisSistema.some(h => h.nome.toLowerCase() === filtro);

        if (filtrados.length > 0 || filtro.length > 0) {
            container.style.display = 'block';

            if (filtro.length > 0 && !existeExato) {
                const divNovo = document.createElement('div');
                divNovo.className = 'btn-novo-cliente';
                divNovo.textContent = `+ Cadastrar novo: "${input.value}"`;
                divNovo.onclick = function() {
                    cadastrarNovoEstabelecimento(input.value.trim());
                };
                container.appendChild(divNovo);
            }

            filtrados.forEach(hotel => {
                const div = document.createElement('div');
                div.className = 'sugestao-item';
                
                const infoDiv = document.createElement('div');
                infoDiv.className = 'sugestao-info';
                
                const spanNome = document.createElement('span');
                spanNome.style.fontWeight = 'bold';
                spanNome.textContent = hotel.nome;
                
                const spanCnpj = document.createElement('span');
                spanCnpj.className = 'sugestao-cnpj';
                spanCnpj.textContent = hotel.cnpj ? `CNPJ: ${hotel.cnpj}` : 'CNPJ não informado';
                
                infoDiv.appendChild(spanNome);
                infoDiv.appendChild(spanCnpj);
                
                infoDiv.onclick = function() {
                    input.value = hotel.nome;
                    cnpjInput.value = hotel.cnpj || '';
                    container.style.display = 'none';
                    atualizarTitulo();
                };
                div.appendChild(infoDiv);

                const acoesDiv = document.createElement('div');
                acoesDiv.className = 'acoes-item';

                const btnEditar = document.createElement('button');
                btnEditar.className = 'btn-acao';
                btnEditar.innerHTML = '✏️';
                btnEditar.title = 'Editar estabelecimento';
                btnEditar.onclick = function(e) {
                    e.stopPropagation();
                    editarEstabelecimento(hotel.nome);
                };
                acoesDiv.appendChild(btnEditar);

                const btnLixeira = document.createElement('button');
                btnLixeira.className = 'btn-acao';
                btnLixeira.innerHTML = '🗑';
                btnLixeira.title = 'Apagar estabelecimento';
                btnLixeira.onclick = function(e) {
                    e.stopPropagation();
                    apagarEstabelecimento(hotel.nome);
                };
                acoesDiv.appendChild(btnLixeira);

                div.appendChild(acoesDiv);
                container.appendChild(div);
            });
        } else {
            container.style.display = 'none';
        }
    }

    async function cadastrarNovoEstabelecimento(nomeNovo) {
        if (!nomeNovo) return;
        let nomeFormatado = nomeNovo.toUpperCase();
        let cnpjAtual = document.getElementById('cnpjInput').value.trim();

        let resposta = await fetch('api.php?acao=salvar_cliente', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nome: nomeFormatado, cnpj: cnpjAtual })
        });
        let res = await resposta.json();

        if (res.sucesso) {
            await carregarClientesServidor();
            document.getElementById('clienteInput').value = nomeFormatado;
            document.getElementById('listaSugestoes').style.display = 'none';
            atualizarTitulo();
        }
    }

    async function editarEstabelecimento(nomeHotel) {
        let hotel = listaHoteisSistema.find(h => h.nome === nomeHotel);
        if (hotel) {
            let novoNome = prompt("Editar nome do estabelecimento:", hotel.nome);
            if (novoNome === null) return;
            let novoCnpj = prompt("Editar CNPJ do estabelecimento:", hotel.cnpj);
            if (novoCnpj === null) return;

            let resposta = await fetch('api.php?acao=editar_cliente', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ nomeAntigo: hotel.nome, novoNome: novoNome, novoCnpj: novoCnpj })
            });
            let res = await resposta.json();

            if (res.sucesso) {
                await carregarClientesServidor();
                document.getElementById('clienteInput').value = novoNome.trim().toUpperCase();
                document.getElementById('cnpjInput').value = novoCnpj.trim();
                filtrarClientes();
                atualizarTitulo();
            }
        }
    }

    async function apagarEstabelecimento(nomeHotel) {
        if (confirm(`Deseja realmente apagar o estabelecimento "${nomeHotel}"?`)) {
            let resposta = await fetch('api.php?acao=deletar_cliente', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ nome: nomeHotel })
            });
            let res = await resposta.json();
            if (res.sucesso) {
                await carregarClientesServidor();
                filtrarClientes();
            }
        }
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.client-section')) {
            document.getElementById('listaSugestoes').style.display = 'none';
        }
    });

    function obterIniciais(nome) {
        if (!nome) return "CLI";
        const ignorar = ["DE", "DA", "DO", "E", "LTDA", "HOTEIS", "HOTEL"];
        const palavras = nome.trim().toUpperCase().split(/\s+/).filter(p => !ignorar.includes(p));
        
        if (palavras.length === 1) {
            return palavras[0].substring(0, 3);
        }
        return palavras.map(p => p[0]).join('');
    }

    function atualizarTitulo() {
        const cliente = document.getElementById('clienteInput').value || 'CLIENTE';
        let iniciais = obterIniciais(cliente);
        let dataTitulo = dataOsGlobal.replace(/\//g, '.');
        document.title = `Laudo Tecnico - ${iniciais} - ${dataTitulo}`;
        document.getElementById('tituloPagina').innerText = document.title;
    }

    function formatarCustoMaoDeObraInput(input) {
        let val = input.value.trim();
        if (val === "0" || val === "0,00" || val === "0.00" || val.toLowerCase() === "irreparavel") {
            input.value = "IRREPARAVEL";
            input.style.color = "#dc2626";
            input.style.fontWeight = "bold";
        } else {
            input.style.color = "#000";
            input.style.fontWeight = "normal";
        }
    }

    function carregarDadosLaudo() {
        const cliente = localStorage.getItem('laudo_cliente') || 'CLIENTE';
        const cnpj = localStorage.getItem('laudo_cnpj') || '';
        dataOsGlobal = localStorage.getItem('laudo_data') || '03/10/2026';
        const itensJson = localStorage.getItem('laudo_itens') || '[]';
        
        let itens = [];
        try {
            itens = JSON.parse(itensJson);
        } catch(e) { itens = []; }

        document.getElementById('clienteInput').value = cliente;
        document.getElementById('cnpjInput').value = cnpj;
        document.getElementById('lblData').innerText = dataOsGlobal;

        const tbody = document.getElementById('tabelaLaudoItens');
        tbody.innerHTML = '';

        if (itens.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td><input type="text" value="N/D"></td>
                    <td><input type="text" value="SEM SERIAL"></td>
                    <td><input type="text" value="N/D"></td>
                    <td><input type="text" value="IRREPARAVEL" style="color:#dc2626; font-weight:bold;" oninput="formatarCustoMaoDeObraInput(this)"></td>
                </tr>
            `;
        } else {
            itens.forEach(item => {
                let custoStr = "";
                let estiloCss = "";
                let valNum = parseFloat(item.valUnit) || 0;

                if (valNum === 0) {
                    custoStr = "IRREPARAVEL";
                    estiloCss = "color:#dc2626; font-weight:bold;";
                } else {
                    custoStr = "R$ " + valNum.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }

                let tr = document.createElement('tr');
                tr.innerHTML = `
                    <td><input type="text" value="${item.modelo || 'N/D'}"></td>
                    <td><input type="text" value="${item.serie || 'SEM SERIAL'}"></td>
                    <td><input type="text" value="${item.defeito || 'N/D'}"></td>
                    <td><input type="text" value="${custoStr}" style="${estiloCss}" oninput="formatarCustoMaoDeObraInput(this)"></td>
                `;
                tbody.appendChild(tr);
            });
        }

        atualizarTitulo();
    }

    function imprimirLaudo() {
        window.print();
    }

    carregarDadosLaudo();
</script>

</body>
</html>