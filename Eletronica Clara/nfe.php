<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eletrônica Clara - Faturamento / NFE</title>
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

        .nfe-container {
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

        .nfe-title-box {
            background-color: #e2e8f0;
            border: 1px solid var(--border-color);
            padding: 10px 15px;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .client-box {
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
            padding: 12px;
            background: #fafafa;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .client-info-left {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .oc-input-group {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: bold;
        }

        .oc-input-group input {
            padding: 5px 8px;
            font-size: 14px;
            font-weight: bold;
            border: 1px solid #ccc;
            width: 150px;
            background: #fff;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group textarea {
            width: 100%;
            height: 160px;
            padding: 10px;
            font-family: monospace;
            font-size: 13px;
            border: 1px solid #ccc;
            resize: vertical;
            white-space: pre-wrap;
        }

        .values-box {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 20px;
            background: #f8fafc;
            border: 1px solid var(--border-color);
            padding: 15px;
        }

        .value-item {
            flex: 1;
            text-align: center;
        }

        .value-item span {
            display: block;
            font-size: 12px;
            color: #555;
            margin-bottom: 5px;
        }

        .value-item strong {
            font-size: 20px;
        }

        .discount-control {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .discount-control input {
            width: 60px;
            text-align: center;
            padding: 4px;
            font-weight: bold;
            font-size: 16px;
        }

        .text-red {
            color: #dc2626 !important;
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
        button:hover { opacity: 0.9; }

        @media print {
            @page { margin: 10mm; }
            body { background: none; padding: 0; }
            .nfe-container { border: none; box-shadow: none; padding: 0; max-width: 100%; }
            .no-print { display: none; }
            .oc-input-group input { border: none !important; background: transparent !important; }
            textarea { border: none !important; background: transparent !important; resize: none; }
        }
    </style>
</head>
<body>

<div class="nfe-container">
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

    <div class="nfe-title-box">
        DOCUMENTO DE FATURAMENTO / DESCRIÇÃO DE SERVIÇO - NFE
    </div>

    <div class="client-box">
        <div class="client-info-left">
            <div><strong>Cliente:</strong> <span id="lblCliente">-</span></div>
            <div><strong>CNPJ:</strong> <span id="lblCnpj">-</span></div>
        </div>
        <div class="oc-input-group">
            <label for="inputOc">OC:</label>
            <input type="text" id="inputOc" placeholder="Ex: 423444" oninput="atualizarCabecalhoDescricao()">
        </div>
    </div>

    <div class="form-group">
        <label for="txtDescricao">Descrição dos Serviços e Equipamentos Prestados:</label>
        <textarea id="txtDescricao"></textarea>
    </div>

    <div class="values-box">
        <div class="value-item">
            <span>Valor Total Bruto</span>
            <strong id="lblTotalBruto">R$ 0,00</strong>
        </div>
        <div class="value-item">
            <span>Desconto Aplicado</span>
            <div class="discount-control">
                <input type="number" id="inputDescPct" value="2" min="0" max="100" step="0.1" oninput="calcularNFe()">
                <strong>%</strong>
            </div>
        </div>
        <div class="value-item">
            <span>Valor com Desconto</span>
            <strong class="text-red" id="lblTotalComDesconto">R$ 0,00</strong>
        </div>
    </div>
</div>

<div class="no-print">
    <button class="btn-back" onclick="window.close()">✕ Fechar Guia</button>
</div>

<script>
    let valorBrutoGlobal = 0;
    let equipamentosTextoGlobal = "";
    let numOsGlobal = "";

    function carregarDadosNFe() {
        const cliente = localStorage.getItem('nfe_cliente') || '';
        const cnpj = localStorage.getItem('nfe_cnpj') || '';
        numOsGlobal = localStorage.getItem('nfe_num_os') || '';
        const total = parseFloat(localStorage.getItem('nfe_total')) || 0;
        equipamentosTextoGlobal = localStorage.getItem('nfe_equipamentos_texto') || '';

        let descricaoSalva = localStorage.getItem('nfe_descricao') || '';
        if (!equipamentosTextoGlobal && descricaoSalva) {
            let partes = descricaoSalva.split('Equipamento 1:');
            if (partes.length > 1) {
                equipamentosTextoGlobal = 'Equipamento 1:' + partes[1];
            } else {
                equipamentosTextoGlobal = descricaoSalva;
            }
        }

        document.getElementById('lblCliente').innerText = cliente;
        document.getElementById('lblCnpj').innerText = cnpj;
        
        valorBrutoGlobal = total;
        atualizarCabecalhoDescricao();
        calcularNFe();
    }

    function atualizarCabecalhoDescricao() {
        const ocVal = document.getElementById('inputOc').value.trim();
        let cabecalho = "";

        if (ocVal) {
            cabecalho = `Serviço de reparo de acordo com OC ${ocVal} e O.S N${numOsGlobal}`;
        } else {
            cabecalho = `Serviço de reparo de acordo com a ordem de serviço N${numOsGlobal}`;
        }

        let textoFinal = cabecalho + "\n\n" + equipamentosTextoGlobal;
        document.getElementById('txtDescricao').value = textoFinal;
    }

    function calcularNFe() {
        const descPct = parseFloat(document.getElementById('inputDescPct').value) || 0;
        
        let valorDesconto = valorBrutoGlobal * (descPct / 100);
        let valorFinal = valorBrutoGlobal - valorDesconto;

        document.getElementById('lblTotalBruto').innerText = `R$ ${valorBrutoGlobal.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        document.getElementById('lblTotalComDesconto').innerText = `R$ ${valorFinal.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    }

    carregarDadosNFe();
</script>

</body>
</html>