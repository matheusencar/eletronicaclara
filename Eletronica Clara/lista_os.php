<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eletrônica Clara - Histórico de O.S.</title>
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

        .container {
            max-width: 1100px;
            background: #fff;
            margin: 0 auto;
            padding: 30px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .title-box {
            font-size: 20px;
            font-weight: bold;
            color: var(--primary-color);
        }

        .search-box {
            margin-bottom: 15px;
            display: flex;
            gap: 10px;
        }

        .search-box input {
            flex: 1;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid var(--border-color);
            padding: 8px;
            text-align: left;
            font-size: 13px;
            vertical-align: middle;
        }

        th {
            background-color: #f0f0f0;
            color: #000;
            font-weight: bold;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }

        .linha-paga {
            background-color: #f0fdf4 !important;
        }

        .checkbox-pago {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #10b981;
        }

        .checkbox-ocultar {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #ef4444;
        }

        .btn-action-icon {
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 4px 6px;
        }

        .btn-action-icon:hover {
            background: #e2e8f0;
            border-radius: 4px;
        }

        .btn-nfe-row {
            background-color: #8b5cf6;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 11px;
            padding: 5px 8px;
            border-radius: 4px;
            font-weight: bold;
            white-space: nowrap;
        }

        .btn-nfe-row:hover {
            opacity: 0.9;
        }

        .actions-cell {
            display: flex;
            flex-direction: row;
            gap: 6px;
            justify-content: center;
            align-items: center;
        }

        .actions-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
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
        button:hover { opacity: 0.9; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <div class="title-box">📋 Histórico de Ordens de Serviço Criadas</div>
        <div>Eletrônica Clara</div>
    </div>

    <div class="search-box">
        <input type="text" id="filtroInput" placeholder="Pesquisar por número da O.S. ou nome do estabelecimento..." oninput="filtrarTabela()">
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Nº O.S.</th>
                <th style="width: 22%;">Estabelecimento / Cliente</th>
                <th style="width: 33%;">Descrição / Equipamentos</th>
                <th style="width: 11%;" class="text-center">Data</th>
                <th style="width: 11%;" class="text-right">Valor Total</th>
                <th style="width: 5%;" class="text-center">Pago</th>
                <th style="width: 5%;" class="text-center">Ocultar</th>
                <th style="width: 13%;" class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody id="tabelaHistorico">
            <tr>
                <td colspan="8" class="text-center">Carregando histórico...</td>
            </tr>
        </tbody>
    </table>

    <div class="actions-bottom">
        <button class="btn-back" onclick="window.close()">✕ Fechar Guia</button>
    </div>
</div>

<script>
    let listaOsGlobal = [];

    async function carregarHistorico() {
        try {
            let resposta = await fetch('api.php?acao=listar_os');
            let dados = await resposta.json();
            listaOsGlobal = dados.filter(os => parseInt(os.ocultar || os.oculta || 0) === 0);
            renderizarTabela(listaOsGlobal);
        } catch (e) {
            console.error("Erro ao carregar histórico:", e);
            document.getElementById('tabelaHistorico').innerHTML = `<tr><td colspan="8" class="text-center" style="color:red;">Erro de conexão com o servidor.</td></tr>`;
        }
    }

    function gerarTextoDescricao(os) {
        let itens = [];
        try {
            itens = JSON.parse(os.detalhes_json);
        } catch(e) { itens = []; }

        let equipamentosTexto = [];
        itens.forEach((item, index) => {
            let modelo = item.modelo || 'N/D';
            let serie = item.serie || 'SEM SERIAL';
            let defeito = item.defeito || 'N/D';
            equipamentosTexto.push(`Equipamento ${index + 1}: ${modelo} | Série: ${serie} | Defeito: ${defeito}`);
        });

        let cabecalho = `Serviço de reparo de acordo com a ordem de serviço N${os.numero_os}`;
        return cabecalho + (equipamentosTexto.length > 0 ? "\n" + equipamentosTexto.join('\n') : "");
    }

    function renderizarTabela(dados) {
        const tbody = document.getElementById('tabelaHistorico');
        tbody.innerHTML = '';

        if (dados.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="text-center">Nenhuma Ordem de Serviço encontrada.</td></tr>`;
            return;
        }

        dados.forEach(os => {
            let dataFormatada = os.data_os;
            if (os.data_os) {
                let partes = os.data_os.split('-');
                if (partes.length === 3) {
                    dataFormatada = `${partes[2]}/${partes[1]}/${partes[0]}`;
                }
            }

            let valorExibir = parseFloat(os.valor_com_desconto || os.valor_total).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            let isPaga = parseInt(os.paga) === 1;
            let descricaoResumida = gerarTextoDescricao(os).replace(/\n/g, '<br>');

            let tr = document.createElement('tr');
            if (isPaga) {
                tr.className = 'linha-paga';
            }

            tr.innerHTML = `
                <td><strong>${os.numero_os}</strong></td>
                <td>${os.cliente}</td>
                <td style="font-size: 11px; line-height: 1.3;">${descricaoResumida}</td>
                <td class="text-center">${dataFormatada}</td>
                <td class="text-right">R$ ${valorExibir}</td>
                <td class="text-center">
                    <input type="checkbox" class="checkbox-pago" ${isPaga ? 'checked' : ''} onchange="atualizarStatusPagamento(${os.id}, this)">
                </td>
                <td class="text-center">
                    <input type="checkbox" class="checkbox-ocultar" title="Ocultar linha" onclick="confirmarOcultar(${os.id}, '${os.numero_os}', this)">
                </td>
                <td class="text-center">
                    <div class="actions-cell">
                        <button class="btn-action-icon" title="Visualizar O.S." onclick='abrirVisualizacao(${JSON.stringify(os)})'>👁️</button>
                        <button class="btn-nfe-row" title="Gerar NFe com esta O.S." onclick='gerarNFeDoHistorico(${JSON.stringify(os)})'>Gerar NFe</button>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    async function atualizarStatusPagamento(idOs, checkbox) {
        let statusPago = checkbox.checked ? 1 : 0;
        try {
            let resposta = await fetch('api.php?acao=atualizar_pagamento', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: idOs, paga: statusPago })
            });
            let res = await resposta.json();
            if (res.sucesso) {
                let osItem = listaOsGlobal.find(o => o.id == idOs);
                if (osItem) osItem.paga = statusPago;
                renderizarTabela(listaOsGlobal);
            } else {
                alert('Erro ao atualizar status de pagamento.');
                checkbox.checked = !checkbox.checked;
            }
        } catch (e) {
            checkbox.checked = !checkbox.checked;
            alert('Erro de conexão com o servidor.');
        }
    }

    async function confirmarOcultar(idOs, numeroOs, checkbox) {
        checkbox.checked = false; 

        if (confirm(`Tem certeza de que deseja ocultar a Ordem de Serviço Nº ${numeroOs}? Ela deixará de aparecer no histórico.`)) {
            try {
                let resposta = await fetch('api.php?acao=ocultar_os', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: idOs })
                });
                let res = await resposta.json();
                if (res.sucesso) {
                    listaOsGlobal = listaOsGlobal.filter(os => os.id != idOs);
                    renderizarTabela(listaOsGlobal);
                } else {
                    alert('Erro ao ocultar a Ordem de Serviço.');
                }
            } catch (e) {
                alert('Erro de conexão com o servidor.');
            }
        }
    }

    function gerarNFeDoHistorico(os) {
        let itens = [];
        try {
            itens = JSON.parse(os.detalhes_json);
        } catch(e) { itens = []; }

        let equipamentosTexto = [];
        itens.forEach((item, index) => {
            let modelo = item.modelo || 'N/D';
            let serie = item.serie || 'SEM SERIAL';
            let defeito = item.defeito || 'N/D';
            equipamentosTexto.push(`Equipamento ${index + 1}: \n${modelo}    SERIE/PATRIMONIO: ${serie} DEFEITO: ${defeito}`);
        });

        let equipamentosBloco = equipamentosTexto.join('\n\n');
        let totalComDesconto = parseFloat(os.valor_com_desconto || os.valor_total);

        localStorage.setItem('nfe_cliente', os.cliente);
        localStorage.setItem('nfe_cnpj', os.cnpj || '');
        localStorage.setItem('nfe_num_os', os.numero_os);
        localStorage.setItem('nfe_equipamentos_texto', equipamentosBloco);
        localStorage.setItem('nfe_total', totalComDesconto.toFixed(2));

        window.open('nfe.php', '_blank');
    }

    function filtrarTabela() {
        const termo = document.getElementById('filtroInput').value.toLowerCase();
        const filtrados = listaOsGlobal.filter(os => 
            os.numero_os.toLowerCase().includes(termo) || os.cliente.toLowerCase().includes(termo)
        );
        renderizarTabela(filtrados);
    }

    function abrirVisualizacao(os) {
        let itens = [];
        try {
            itens = JSON.parse(os.detalhes_json);
        } catch(e) { itens = []; }

        let itensHtml = '';
        if (Array.isArray(itens) && itens.length > 0) {
            itens.forEach(item => {
                let valUnitFmt = parseFloat(item.valUnit || 0).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                itensHtml += `
                    <tr>
                        <td>${item.modelo || ''}</td>
                        <td>${item.serie || ''}</td>
                        <td>${item.defeito || ''}</td>
                        <td class="text-center">${item.qtd || 1}</td>
                        <td>R$ ${valUnitFmt}</td>
                    </tr>
                `;
            });
        } else {
            itensHtml = `<tr><td colspan="5" class="text-center">Nenhum item detalhado.</td></tr>`;
        }

        let totalFmt = parseFloat(os.valor_total).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        let descontoFmt = parseFloat(os.valor_com_desconto).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        let novaJanela = window.open('', '_blank');
        novaJanela.document.write(`
            <!DOCTYPE html>
            <html lang="pt-BR">
            <head>
                <meta charset="UTF-8">
                <title>O.S. - ${os.numero_os} - ${os.cliente}</title>
                <style>
                    body { font-family: Arial, sans-serif; font-size: 14px; color: #000; padding: 20px; max-width: 800px; margin: 0 auto; }
                    .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 20px; }
                    .logo-area { display: flex; align-items: center; gap: 15px; }
                    .logo-box { width: 70px; height: 70px; border: 2px solid #333; display: flex; align-items: center; justify-content: center; font-size: 28px; background: #ffeb3b; font-weight: bold; }
                    .company-name { font-size: 22px; font-weight: bold; line-height: 1.2; }
                    .company-details { font-size: 12px; line-height: 1.4; text-align: right; }
                    .os-info-box { background-color: #e2e8f0; border: 1px solid #333; padding: 10px 15px; display: flex; justify-content: space-between; font-weight: bold; margin-bottom: 15px; }
                    .client-section { margin-bottom: 15px; font-weight: bold; }
                    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; table-layout: fixed; }
                    th, td { border: 1px solid #333; padding: 8px; text-align: left; font-size: 13px; word-wrap: break-word; }
                    th { background-color: #f0f0f0; color: #000; }
                    .text-right { text-align: right; }
                    .text-center { text-align: center; }
                    .text-red { color: #dc2626 !important; }
                    .warranty-section { font-size: 11px; line-height: 1.4; margin-bottom: 30px; border-top: 1px dashed #999; padding-top: 15px; }
                    .technician { font-weight: bold; margin-bottom: 20px; }
                    .print-btn { text-align: center; margin-top: 20px; }
                    button { padding: 10px 20px; font-size: 14px; font-weight: bold; background: #10b981; color: white; border: none; border-radius: 4px; cursor: pointer; }
                    @media print { .print-btn { display: none; } @page { margin: 10mm; } }
                </style>
            </head>
            <body>
                <div class="header">
                    <div class="logo-area">
                        <div class="logo-box">⚡</div>
                        <div class="company-name">Eletrônica<br>Clara</div>
                    </div>
                    <div class="company-details">
                        André Antônio<br>Tel.: (71) 99244-9404<br>eletronicaclara@gmail.com<br>CNPJ: 23.024.997/0001-15<br>Rua Jardim Concórdia, 62 - Brotas - Salvador - Ba<br>CEP: 40.255.070
                    </div>
                </div>

                <div class="os-info-box">
                    <div>DATA: ${os.data_os}</div>
                    <div>Ordem de Serviço / Orçamento</div>
                    <div>Nº: ${os.numero_os}</div>
                </div>

                <div class="client-section">
                    <div>Serviço destinado ao cliente: ${os.cliente}</div>
                    <div style="font-size: 13px; color: #444; font-weight: normal; margin-top: 4px;">CNPJ: ${os.cnpj || 'Não informado'}</div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th style="width: 29%;">Marca / Modelo</th>
                            <th style="width: 29%;">Série / Identificação / Patrimônio</th>
                            <th style="width: 18%;">Defeito</th>
                            <th style="width: 8%;" class="text-center">QTD</th>
                            <th style="width: 16%;">Valor Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${itensHtml}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right" style="font-weight: bold;">Total Bruto</td>
                            <td style="font-weight: bold;">R$ ${totalFmt}</td>
                        </tr>
                        ${os.desconto_pct > 0 ? `
                        <tr>
                            <td colspan="4" class="text-right text-red" style="font-weight: bold;">Valor com Desconto (${os.desconto_pct}%)</td>
                            <td class="text-red" style="font-weight: bold;">R$ ${descontoFmt}</td>
                        </tr>` : ''}
                    </tfoot>
                </table>

                <div class="warranty-section">
                    <strong>GARANTIA:</strong> Todos os aparelhos acima apresentados têm garantia de 90 dias a partir da data do reparo, caso haja reincidência do mesmo defeito apresentado na mesma placa reparada.<br><br>
                    <strong>Atenção:</strong> para solicitar a garantia é necessário o envio por e-mail da ordem de serviço referente ao reparo bem como fotos do modelo da tv e número do patrimônio/serial da tv sinalizada.
                </div>

                <div class="technician">Técnico Responsável: André Antônio</div>

                <div class="print-btn">
                    <button onclick="window.print()">🖨️ Imprimir / Salvar PDF</button>
                </div>
            </body>
            </html>
        `);
        novaJanela.document.close();
    }

    carregarHistorico();
</script>

</body>
</html>