<?php
session_start();
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eletrônica Clara - Ordem de Serviço</title>
    <style>
        :root {
            --primary-color: #2c3e50;
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

        .os-container {
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

        .os-info-box {
            background-color: #e2e8f0;
            border: 1px solid var(--border-color);
            padding: 10px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            font-weight: bold;
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
            padding: 4px;
            width: 70%;
            border: 1px solid #ccc;
        }

        .cnpj-row {
            font-size: 13px;
            color: #444;
            padding-left: 175px;
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
            left: 175px;
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

        .btn-novo-cliente:hover {
            background-color: #1d4ed8 !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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

        td input::placeholder {
            color: #555;
        }

        td input:focus {
            background: #fffdf0;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-red {
            color: #dc2626 !important;
        }

        .warranty-section {
            font-size: 11px;
            line-height: 1.4;
            margin-bottom: 30px;
            border-top: 1px dashed #999;
            padding-top: 15px;
        }

        .technician {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .no-print {
            max-width: 950px;
            margin: 20px auto 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .control-group {
            display: flex;
            align-items: center;
            gap: 5px;
            background: #fff;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .control-group input {
            width: 50px;
            padding: 4px;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
        }

        button {
            padding: 10px 14px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            flex: 1;
            min-width: 110px;
        }

        .btn-add { background-color: #3b82f6; color: white; }
        .btn-print { background-color: #10b981; color: white; }
        .btn-clear { background-color: #ef4444; color: white; }
        .btn-nfe { background-color: #8b5cf6; color: white; }
        .btn-laudo { background-color: #0284c7; color: white; }
        .btn-simples { background-color: #0d9488; color: white; }
        .btn-history { background-color: #d97706; color: white; }
        .btn-logout { background-color: #475569; color: white; }
        .btn-delete { background-color: #ef4444; color: white; padding: 4px 8px; font-size: 11px; border-radius: 3px; flex: unset; min-width: unset; }

        button:hover { opacity: 0.9; }

        @media print {
            @page {
                margin: 10mm;
            }
            body {
                background: none;
                padding: 0;
            }
            .os-container {
                border: none;
                box-shadow: none;
                padding: 0;
                max-width: 100%;
            }
            .no-print {
                display: none;
            }
            #listaSugestoes {
                display: none !important;
            }
            td input, .client-row input, .cnpj-row input {
                border: none !important;
                background: transparent !important;
                color: #000 !important;
            }
        }
    </style>
</head>
<body>

<div class="os-container">
    <div class="header">
        <div class="logo-area">
            <div class="logo-box">⚡</div>
            <div class="company-name">Eletrônica<br>Clara</div>
        </div>
        <div class="company-details">
            André Antônio<br>
            Tel.: (71) 99244-9404<br>
            eletronicaclara@gmail.com<br>
            CNPJ: 23.024.997/0001-15<br>
            Rua Jardim Concórdia, 62 - Brotas - Salvador - Ba<br>
            CEP: 40.255.070
        </div>
    </div>

    <div class="os-info-box">
        <div>DATA: <input type="date" id="dataOs" style="border:none; background:transparent; font-weight:bold; color:#000;"></div>
        <div>Ordem de Serviço / Orçamento</div>
        <div>Nº: <input type="text" id="numOs" style="width: 105px; border:none; background:transparent; font-weight:bold; text-align:right; color:#000;"></div>
    </div>

    <div class="client-section">
        <div class="client-row">
            <span>Serviço destinado ao cliente:</span> 
            <input type="text" id="clienteInput" placeholder="Digite o nome ou CNPJ..." oninput="filtrarClientes()" onfocus="filtrarClientes()">
        </div>
        <div class="cnpj-row">
            CNPJ: <input type="text" id="cnpjInput" placeholder="CNPJ do estabelecimento">
        </div>
        <div id="listaSugestoes"></div>
    </div>

    <table id="tabelaItens">
        <thead>
            <tr>
                <th style="width: 29%;">Marca / Modelo</th>
                <th style="width: 29%;">Série / Identificação / Patrimônio</th>
                <th style="width: 18%;">Defeito</th>
                <th style="width: 8%;" class="text-center">QTD</th>
                <th style="width: 11%;">Valor Unit</th>
                <th style="width: 5%;" class="no-print text-center">Ação</th>
            </tr>
        </thead>
        <tbody id="corpoTabela">
            <tr>
                <td><input type="text" placeholder="Descrição/Modelo"></td>
                <td><input type="text" placeholder="Patrimônio/Serial"></td>
                <td><input type="text" placeholder="Defeito"></td>
                <td><input type="text" value="1" class="text-center" oninput="formatarCampoQtd(this); calcularTotal()"></td>
                <td><input type="text" value="0,00" oninput="formatarCampoMoeda(this); calcularTotal()"></td>
                <td class="no-print text-center"><button class="btn-delete" onclick="removerLinha(this)">X</button></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right" style="font-weight: bold;">Total</td>
                <td colspan="2" style="font-weight: bold;" id="valorTotal">R$ 0,00</td>
            </tr>
            <tr id="linhaDesconto" style="display: none;">
                <td colspan="4" class="text-right text-red" style="font-weight: bold;">Valor com Desconto (<span id="textoDescontoPct">0</span>%)</td>
                <td colspan="2" class="text-red" style="font-weight: bold;" id="valorComDesconto">R$ 0,00</td>
            </tr>
        </tfoot>
    </table>

    <div class="warranty-section">
        <strong>GARANTIA:</strong> Todos os aparelhos acima apresentados têm garantia de 90 dias a partir da data do reparo, caso haja reincidência do mesmo defeito apresentado na mesma placa reparada.<br><br>
        <strong>Atenção:</strong> para solicitar a garantia é necessário o envio por e-mail da ordem de serviço referente ao reparo bem como fotos do modelo da tv e número do patrimônio/serial da tv sinalizada.
    </div>

    <div class="technician">
        Técnico Responsável: <input type="text" id="tecnico" value="André Antônio" style="border:none; border-bottom: 1px solid #333; font-weight:normal; color:#000;">
    </div>
</div>

<div class="no-print">
    <div class="control-group">
        <label for="qtdItens" style="font-size: 13px; font-weight: bold;">Qtd:</label>
        <input type="number" id="qtdItens" value="1" min="1" max="50">
    </div>
    <button class="btn-add" onclick="adicionarMultiplasLinhas()">+ Adicionar</button>
    
    <div class="control-group">
        <label for="descontoPct" style="font-size: 13px; font-weight: bold;">Desc %:</label>
        <input type="number" id="descontoPct" value="0" min="0" max="100" step="1" oninput="calcularTotal()">
    </div>

    <button class="btn-clear" onclick="limparTabela()">🗑 Limpar</button>
    <button class="btn-nfe" onclick="irParaNFe()">📄 NFE</button>
    <button class="btn-laudo" onclick="irParaLaudo()">📋 Laudo</button>
    <button class="btn-simples" onclick="irParaSimplesNacional()">⚖️ Simples</button>
    <button class="btn-history" onclick="window.open('lista_os.php', '_blank')">📂 Histórico</button>
    <button class="btn-print" onclick="salvarEImprimir()">🖨️ Imprimir</button>
    <button class="btn-logout" onclick="fazerLogout()">🚪 Sair</button>
</div>

<script>
    let listaHoteisSistema = [];
    let baseOsGlobal = "00000";
    let editandoOsId = null;

    async function carregarDadosDoServidor() {
        try {
            let resposta = await fetch('api.php?acao=obter_dados');
            let dados = await resposta.json();
            if (dados.clientes) {
                listaHoteisSistema = dados.clientes;
            }
            if (dados.base_os) {
                baseOsGlobal = dados.base_os;
            }

            verificarModoEdicao();
        } catch (e) {
            console.error("Erro ao carregar dados do servidor:", e);
        }
    }

    function verificarModoEdicao() {
        const idEdit = localStorage.getItem('editar_os_id');
        if (idEdit) {
            editandoOsId = idEdit;
            document.getElementById('numOs').value = localStorage.getItem('editar_os_numero') || '';
            document.getElementById('clienteInput').value = localStorage.getItem('editar_os_cliente') || '';
            document.getElementById('cnpjInput').value = localStorage.getItem('editar_os_cnpj') || '';
            document.getElementById('dataOs').value = localStorage.getItem('editar_os_data') || new Date().toISOString().split('T')[0];
            document.getElementById('descontoPct').value = localStorage.getItem('editar_os_desconto') || 0;

            let itensJson = localStorage.getItem('editar_os_itens');
            if (itensJson) {
                try {
                    let itens = JSON.parse(itensJson);
                    const tbody = document.getElementById('corpoTabela');
                    tbody.innerHTML = '';
                    itens.forEach(item => {
                        let valFmt = parseFloat(item.valUnit || 0).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        let tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td><input type="text" value="${item.modelo || ''}" placeholder="Descrição/Modelo"></td>
                            <td><input type="text" value="${item.serie || ''}" placeholder="Patrimônio/Serial"></td>
                            <td><input type="text" value="${item.defeito || ''}" placeholder="Defeito"></td>
                            <td><input type="text" value="${item.qtd || 1}" class="text-center" oninput="formatarCampoQtd(this); calcularTotal()"></td>
                            <td><input type="text" value="${valFmt}" oninput="formatarCampoMoeda(this); calcularTotal()"></td>
                            <td class="no-print text-center"><button class="btn-delete" onclick="removerLinha(this)">X</button></td>
                        `;
                        tbody.appendChild(tr);
                    });
                } catch(e) {}
            }

            localStorage.removeItem('editar_os_id');
            localStorage.removeItem('editar_os_numero');
            localStorage.removeItem('editar_os_cliente');
            localStorage.removeItem('editar_os_cnpj');
            localStorage.removeItem('editar_os_data');
            localStorage.removeItem('editar_os_desconto');
            localStorage.removeItem('editar_os_itens');
        } else {
            document.getElementById('dataOs').valueAsDate = new Date();
            atualizarNumeroOS();
        }
        calcularTotal();
    }

    carregarDadosDoServidor();

    function atualizarNumeroOS() {
        if (editandoOsId) return;
        const linhas = document.querySelectorAll('#corpoTabela tr').length;
        let letra = "";
        let n = linhas;
        while (n > 0) {
            let resto = (n - 1) % 26;
            letra = String.fromCharCode(65 + resto) + letra;
            n = Math.floor((n - 1) / 26);
        }
        document.getElementById('numOs').value = baseOsGlobal + letra;
    }

    async function incrementarNumeroOS() {
        if (editandoOsId) return;
        try {
            let resposta = await fetch('api.php?acao=incrementar_os', { method: 'POST' });
            let dados = await resposta.json();
            if (dados.sucesso) {
                baseOsGlobal = dados.nova_base;
            }
        } catch (e) {
            console.error("Erro ao incrementar O.S:", e);
        }
    }

    function filtrarClientes() {
        const input = document.getElementById('clienteInput');
        const cnpjInput = document.getElementById('cnpjInput');
        const filtro = input.value.trim().toLowerCase();
        const container = document.getElementById('listaSugestoes');
        
        container.innerHTML = '';
        const filtrados = listaHoteisSistema.filter(h => 
            h.nome.toLowerCase().includes(filtro) || h.cnpj.toLowerCase().includes(filtro)
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
                    cnpjInput.value = hotel.cnpj;
                    container.style.display = 'none';
                };
                div.appendChild(infoDiv);

                const acoesDiv = document.createElement('div');
                acoesDiv.className = 'acoes-item';

                const btnEditar = document.createElement('button');
                btnEditar.className = 'btn-acao';
                btnEditar.innerHTML = '✏';
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
            await carregarDadosDoServidor();
            document.getElementById('clienteInput').value = nomeFormatado;
            document.getElementById('listaSugestoes').style.display = 'none';
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
                await carregarDadosDoServidor();
                document.getElementById('clienteInput').value = novoNome.trim().toUpperCase();
                document.getElementById('cnpjInput').value = novoCnpj.trim();
                filtrarClientes();
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
                await carregarDadosDoServidor();
                filtrarClientes();
            }
        }
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.client-section')) {
            document.getElementById('listaSugestoes').style.display = 'none';
        }
    });

    function formatarCampoQtd(input) {
        let valor = input.value.replace(/\D/g, '');
        input.value = valor ? parseInt(valor, 10) : '';
    }

    function formatarCampoMoeda(input) {
        let valor = input.value.replace(/\D/g, '');
        if (!valor) {
            input.value = '';
            return;
        }
        let numero = (parseInt(valor, 10) / 100).toFixed(2);
        let partes = numero.split('.');
        partes[0] = partes[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        input.value = partes.join(',');
    }

    function converterMoedaParaFloat(str) {
        if (!str) return 0;
        let limpo = str.toString().replace(/\./g, '').replace(',', '.');
        return parseFloat(limpo) || 0;
    }

    function adicionarMultiplasLinhas() {
        const qtd = parseInt(document.getElementById('qtdItens').value) || 1;
        const tbody = document.getElementById('corpoTabela');
        
        for (let i = 0; i < qtd; i++) {
            const novaLinha = document.createElement('tr');
            novaLinha.innerHTML = `
                <td><input type="text" placeholder="Descrição/Modelo"></td>
                <td><input type="text" placeholder="Patrimônio/Serial"></td>
                <td><input type="text" placeholder="Defeito"></td>
                <td><input type="text" value="1" class="text-center" oninput="formatarCampoQtd(this); calcularTotal()"></td>
                <td><input type="text" value="0,00" oninput="formatarCampoMoeda(this); calcularTotal()"></td>
                <td class="no-print text-center"><button class="btn-delete" onclick="removerLinha(this)">X</button></td>
            `;
            tbody.appendChild(novaLinha);
        }
        atualizarNumeroOS();
        calcularTotal();
    }

    function limparTabela() {
        if (confirm("Deseja realmente limpar todos os campos e itens da O.S.?")) {
            editandoOsId = null;
            document.getElementById('clienteInput').value = '';
            document.getElementById('cnpjInput').value = '';
            const tbody = document.getElementById('corpoTabela');
            tbody.innerHTML = `
                <tr>
                    <td><input type="text" placeholder="Descrição/Modelo"></td>
                    <td><input type="text" placeholder="Patrimônio/Serial"></td>
                    <td><input type="text" placeholder="Defeito"></td>
                    <td><input type="text" value="1" class="text-center" oninput="formatarCampoQtd(this); calcularTotal()"></td>
                    <td><input type="text" value="0,00" oninput="formatarCampoMoeda(this); calcularTotal()"></td>
                    <td class="no-print text-center"><button class="btn-delete" onclick="removerLinha(this)">X</button></td>
                </tr>
            `;
            document.getElementById('descontoPct').value = 0;
            atualizarNumeroOS();
            calcularTotal();
        }
    }

    function removerLinha(botao) {
        const linha = botao.closest('tr');
        const tbody = document.getElementById('corpoTabela');
        
        if (tbody.rows.length > 1) {
            linha.remove();
            atualizarNumeroOS();
            calcularTotal();
        } else {
            alert("A ordem de serviço deve conter ao menos um item.");
        }
    }

    function calcularTotal() {
        const linhas = document.querySelectorAll('#corpoTabela tr');
        let totalGeral = 0;

        linhas.forEach(linha => {
            const inputs = linha.querySelectorAll('input');
            if (inputs.length >= 5) {
                const qtdInput = inputs[3];
                const valInput = inputs[4];
                
                const qtd = parseFloat(qtdInput.value.replace(/\./g, '')) || 0;
                const valUnit = converterMoedaParaFloat(valInput.value);
                
                totalGeral += (qtd * valUnit);
            }
        });

        let totalFormatado = totalGeral.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        document.getElementById('valorTotal').innerText = `R$ ${totalFormatado}`;

        const descontoPct = parseFloat(document.getElementById('descontoPct').value) || 0;
        const linhaDesconto = document.getElementById('linhaDesconto');

        if (descontoPct > 0) {
            let valorDesconto = totalGeral * (descontoPct / 100);
            let totalComDesconto = totalGeral - valorDesconto;

            document.getElementById('textoDescontoPct').innerText = descontoPct;
            document.getElementById('valorComDesconto').innerText = `R$ ${totalComDesconto.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            linhaDesconto.style.display = '';
        } else {
            linhaDesconto.style.display = 'none';
        }
    }

    function obterIniciais(nome) {
        if (!nome) return "CLI";
        const ignorar = ["DE", "DA", "DO", "E", "LTDA", "HOTEIS", "HOTEL"];
        const palavras = nome.trim().toUpperCase().split(/\s+/).filter(p => !ignorar.includes(p));
        
        if (palavras.length === 1) {
            return palavras[0].substring(0, 3);
        }
        return palavras.map(p => p[0]).join('');
    }

    function irParaNFe() {
        const cliente = document.getElementById('clienteInput').value;
        const cnpj = document.getElementById('cnpjInput').value;
        const numOs = document.getElementById('numOs').value;
        
        const linhas = document.querySelectorAll('#corpoTabela tr');
        let equipamentosTexto = [];
        let totalGeral = 0;

        linhas.forEach((linha, index) => {
            const inputs = linha.querySelectorAll('input');
            if (inputs.length >= 5) {
                const modelo = inputs[0].value.trim() || 'N/D';
                const serie = inputs[1].value.trim() || 'SEM SERIAL';
                const defeito = inputs[2].value.trim() || 'N/D';
                const qtd = parseFloat(inputs[3].value.replace(/\./g, '')) || 0;
                const valUnit = converterMoedaParaFloat(inputs[4].value);

                totalGeral += (qtd * valUnit);

                equipamentosTexto.push(`Equipamento ${index + 1}: \n${modelo}    SERIE/PATRIMONIO: ${serie} DEFEITO: ${defeito}`);
            }
        });

        let equipamentosBloco = equipamentosTexto.join('\n\n');

        localStorage.setItem('nfe_cliente', cliente);
        localStorage.setItem('nfe_cnpj', cnpj);
        localStorage.setItem('nfe_num_os', numOs);
        localStorage.setItem('nfe_equipamentos_texto', equipamentosBloco);
        localStorage.setItem('nfe_total', totalGeral.toFixed(2));

        window.open('nfe.php', '_blank');
    }

    function irParaLaudo() {
        const cliente = document.getElementById('clienteInput').value;
        const cnpj = document.getElementById('cnpjInput').value;
        const dataInput = document.getElementById('dataOs').value;
        let dataFormatada = "03/10/2026";
        
        if (dataInput) {
            const partes = dataInput.split('-');
            if (partes.length === 3) {
                dataFormatada = `${partes[2]}/${partes[1]}/${partes[0]}`;
            }
        }

        const linhas = document.querySelectorAll('#corpoTabela tr');
        let itens = [];

        linhas.forEach(linha => {
            const inputs = linha.querySelectorAll('input');
            if (inputs.length >= 5) {
                const modelo = inputs[0].value.trim();
                const serie = inputs[1].value.trim();
                const defeito = inputs[2].value.trim();
                const valUnit = converterMoedaParaFloat(inputs[4].value);

                itens.push({ modelo, serie, defeito, valUnit });
            }
        });

        localStorage.setItem('laudo_cliente', cliente);
        localStorage.setItem('laudo_cnpj', cnpj);
        localStorage.setItem('laudo_data', dataFormatada);
        localStorage.setItem('laudo_itens', JSON.stringify(itens));

        window.open('laudo.php', '_blank');
    }

    function irParaSimplesNacional() {
        const cliente = document.getElementById('clienteInput').value.trim() || 'NOME DO ESTABELECIMENTOAQUI';
        
        const dataAtual = new Date();
        const dia = dataAtual.getDate();
        const meses = ["janeiro", "fevereiro", "março", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro"];
        const mes = meses[dataAtual.getMonth()];
        const ano = dataAtual.getFullYear();
        
        const dataFormatada = `${dia} de ${mes} de ${ano}`;

        localStorage.setItem('simples_cliente', cliente);
        localStorage.setItem('simples_data', dataFormatada);

        window.open('simples_nacional.php', '_blank');
    }

    async function salvarOuAtualizarOsNoBanco(dadosOs) {
        try {
            let acaoApi = editandoOsId ? 'atualizar_os' : 'salvar_os';
            if (editandoOsId) {
                dadosOs.id = editandoOsId;
            }

            await fetch(`api.php?acao=${acaoApi}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dadosOs)
            });
        } catch (e) {
            console.error("Erro ao salvar/atualizar O.S no banco:", e);
        }
    }

    async function salvarEImprimir() {
        const nomeCliente = document.getElementById('clienteInput').value || "CLIENTE";
        const cnpjCliente = document.getElementById('cnpjInput').value || "";
        const iniciais = obterIniciais(nomeCliente);
        const numOs = document.getElementById('numOs').value;
        const dataInput = document.getElementById('dataOs').value;
        let dataFormatada = "2026-10-03";
        let dataExibicao = "03.10.2026";
        
        if (dataInput) {
            dataFormatada = dataInput;
            const partes = dataInput.split('-');
            if (partes.length === 3) {
                dataExibicao = `${partes[2]}.${partes[1]}.${partes[0]}`;
            }
        }

        const linhas = document.querySelectorAll('#corpoTabela tr');
        let itens = [];
        let totalBruto = 0;

        linhas.forEach(linha => {
            const inputs = linha.querySelectorAll('input');
            if (inputs.length >= 5) {
                const modelo = inputs[0].value.trim();
                const serie = inputs[1].value.trim();
                const defeito = inputs[2].value.trim();
                const qtd = parseFloat(inputs[3].value.replace(/\./g, '')) || 0;
                const valUnit = converterMoedaParaFloat(inputs[4].value);

                totalBruto += (qtd * valUnit);
                itens.push({ modelo, serie, defeito, qtd, valUnit });
            }
        });

        const descontoPct = parseFloat(document.getElementById('descontoPct').value) || 0;
        let valorDesconto = totalBruto * (descontoPct / 100);
        let valorComDesconto = totalBruto - valorDesconto;

        await salvarOuAtualizarOsNoBanco({
            numero_os: numOs,
            cliente: nomeCliente,
            cnpj: cnpjCliente,
            data_os: dataFormatada,
            valor_total: totalBruto,
            desconto_pct: descontoPct,
            valor_com_desconto: valorComDesconto,
            itens: itens
        });

        document.title = `O.S - ${iniciais} - N${numOs} - ${dataExibicao}`;

        if (!editandoOsId) {
            await incrementarNumeroOS();
        }
        
        window.print();

        setTimeout(async () => {
            editandoOsId = null;
            await carregarDadosDoServidor();
        }, 1000);
    }

    function fazerLogout() {
        if (confirm("Deseja realmente sair da Área do Colaborador?")) {
            window.location.href = 'logout.php';
        }
    }
</script>

</body>
</html>