<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eletrônica Clara - Declaração Simples Nacional</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #000;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            background: #fff;
            margin: 0 auto;
            padding: 40px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-box {
            width: 70px;
            height: 70px;
            border: 2px solid #333;
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

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 25px;
            text-decoration: underline;
        }

        .content {
            text-align: justify;
            font-size: 13.5px;
            margin-bottom: 30px;
        }

        .content p {
            margin-bottom: 15px;
            text-indent: 30px;
        }

        .client-edit-area {
            position: relative;
            display: inline-block;
            width: 320px;
            vertical-align: middle;
        }

        .client-edit-area input {
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-weight: bold;
            border: 1px solid #ccc;
            padding: 4px 6px;
            width: 100%;
            background: #fffdf0;
        }

        /* Dropdown flutuante posicionado dinamicamente via JS na tela */
        #listaSugestoes {
            position: fixed;
            width: 350px;
            background: #fff;
            border: 1px solid #999;
            max-height: 220px;
            overflow-y: auto;
            z-index: 99999;
            display: none;
            box-shadow: 0 6px 16px rgba(0,0,0,0.2);
        }

        .sugestao-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 10px;
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
            gap: 4px;
        }

        .btn-acao {
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 13px;
            padding: 2px 4px;
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
            padding: 8px 10px !important;
            cursor: pointer;
        }

        .footer-date {
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .print-btn {
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
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-print { background: #10b981; color: white; }
        .btn-back { background: #64748b; color: white; }
        button:hover { opacity: 0.9; }

        @media print {
            body { background: none; padding: 0; }
            .container { border: none; box-shadow: none; padding: 0; max-width: 100%; }
            .print-btn { display: none; }
            .client-edit-area input { border: none; background: transparent; font-weight: bold; padding: 0; }
            @page { margin: 20mm; }
        }
    </style>
</head>
<body>

<div class="container">
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

    <div class="title">DECLARAÇÃO</div>

    <div class="content">
        <p>Ilmo. Sr.<br>
        <span class="client-edit-area">
            <input type="text" id="clienteInput" placeholder="Digite o nome..." oninput="filtrarClientes()" onfocus="filtrarClientes()">
        </span>,</p>
        
        <p>A empresa André Antônio de Carvalho Sena, com sede na rua Jardim Concórdia, nº 62, cidade Salvador, inscrita no CNPJ sob o nº 23.024.997/0001-15 DECLARA ao <span id="lblClienteTexto">NOME DO ESTABELECIMENTOAQUI</span>, para fins de não incidência na fonte do IRPJ, da Contribuição Social sobre o Lucro Líquido (CSLL), da Contribuição para o Financiamento da Seguridade Social (Cofins), e da Contribuição para o PIS/Pasep, a que se refere o art. 64 da Lei nº 9.430, de 27 de dezembro de 1996, que é regularmente inscrita no Regime Especial Unificado de Arrecadação de Tributos e Contribuições devidos pelas Microempresas e Empresas de Pequeno Porte - Simples Nacional, de que trata o art. 12 da Lei Complementar 123, de 14 de dezembro de 2006.</p>

        <p>Para esse efeito, a declarante informa que:</p>
        
        <p><strong>I</strong> - preenche os seguintes requisitos:<br>
        <strong>a)</strong> conserva em boa ordem, pelo prazo de 5 (cinco) anos, contado da data da emissão, os documentos que comprovam a origem de suas receitas e a efetivação de suas despesas, bem como a realização de quaisquer outros atos ou operações que venham a modificar sua situação patrimonial; e<br>
        <strong>b)</strong> cumpre as obrigações acessórias a que está sujeita, em conformidade com a legislação pertinente;</p>

        <p><strong>II</strong> - o signatário é representante legal desta empresa, assumindo o compromisso de informar à Secretaria da Receita Federal do Brasil e à pessoa jurídica pagadora, imediatamente, eventual desenquadramento da presente situação e está ciente de que a falsidade na prestação dessas informações, sem prejuízo do disposto no art. 32 da Lei 9.430, de 1996, o sujeitará, com as demais pessoas que para ela concorrem, às penalidades previstas na legislação criminal e tributária, relativas à falsidade ideológica (art. 299 do Decreto-Lei nº 2.848, de 7 de dezembro de 1940 - Código Penal) e ao crime contra a ordem tributária (art. 1º da Lei nº 8.137, de 27 de dezembro de 1990).</p>
    </div>

    <div class="footer-date">
        Salvador, <span id="lblData">3 de outubro de 2026</span>.
    </div>

    <div class="print-btn">
        <button class="btn-back" onclick="window.close()">✕ Fechar Guia</button>
        <button class="btn-print" onclick="window.print()">🖨️ Imprimir / Salvar PDF</button>
    </div>
</div>

<!-- Div de sugestões solta no body para posicionamento fixo perfeito -->
<div id="listaSugestoes"></div>

<script>
    let listaHoteisSistema = [];

    async function carregarDadosDoServidor() {
        try {
            let resposta = await fetch('api.php?acao=obter_dados');
            let dados = await resposta.json();
            if (dados.clientes) {
                listaHoteisSistema = dados.clientes;
            }
        } catch (e) {
            console.error("Erro ao carregar dados:", e);
        }
    }

    carregarDadosDoServidor();

    function carregarDadosDeclaracao() {
        const clienteSalvo = localStorage.getItem('simples_cliente') || 'HOSPITAL SANTA IZABEL';
        const dataHoje = localStorage.getItem('simples_data') || '3 de outubro de 2026';

        document.getElementById('clienteInput').value = clienteSalvo;
        document.getElementById('lblClienteTexto').innerText = clienteSalvo;
        document.getElementById('lblData').innerText = dataHoje;
    }

    carregarDadosDeclaracao();

    function posicionarDropdown() {
        const input = document.getElementById('clienteInput');
        const container = document.getElementById('listaSugestoes');
        const rect = input.getBoundingClientRect();

        // Posiciona a lista logo abaixo do input com base nas coordenadas da tela
        container.style.top = (rect.bottom + 4) + 'px';
        container.style.left = rect.left + 'px';
        container.style.width = Math.max(rect.width, 350) + 'px';
    }

    function filtrarClientes() {
        const input = document.getElementById('clienteInput');
        const filtro = input.value.trim().toLowerCase();
        const container = document.getElementById('listaSugestoes');
        
        document.getElementById('lblClienteTexto').innerText = input.value.toUpperCase();

        container.innerHTML = '';
        const filtrados = listaHoteisSistema.filter(h => 
            h.nome.toLowerCase().includes(filtro) || h.cnpj.toLowerCase().includes(filtro)
        );
        
        const existeExato = listaHoteisSistema.some(h => h.nome.toLowerCase() === filtro);

        if (filtrados.length > 0 || filtro.length > 0) {
            posicionarDropdown();
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
                    document.getElementById('lblClienteTexto').innerText = hotel.nome;
                    container.style.display = 'none';
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

        let resposta = await fetch('api.php?acao=salvar_cliente', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nome: nomeFormatado, cnpj: '' })
        });
        let res = await resposta.json();

        if (res.sucesso) {
            await carregarDadosDoServidor();
            document.getElementById('clienteInput').value = nomeFormatado;
            document.getElementById('lblClienteTexto').innerText = nomeFormatado;
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
                document.getElementById('lblClienteTexto').innerText = novoNome.trim().toUpperCase();
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
        if (!e.target.closest('.client-edit-area') && !e.target.closest('#listaSugestoes')) {
            document.getElementById('listaSugestoes').style.display = 'none';
        }
    });

    window.addEventListener('resize', function() {
        if (document.getElementById('listaSugestoes').style.display === 'block') {
            posicionarDropdown();
        }
    });
</script>

</body>
</html>