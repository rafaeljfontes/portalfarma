
        function setSelectUf(select_estado, select_cidade, estadoVal, cidadeVal){
            new dgCidadesEstados({
                estado: document.getElementById(select_estado),
                cidade: document.getElementById(select_cidade),
                estadoVal,
                cidadeVal,
            });
        }