document.addEventListener("DOMContentLoaded", function() {

    // Validação de Cadastro e Alteração
    function validarFormulario(formId) {
        let form = document.getElementById(formId);
        if (!form) return;

        form.addEventListener("submit", function(e) {
            let nome = form.querySelector("#nome_prod")?.value.trim();
            let preco = form.querySelector("#preco")?.value.trim();
            let quantidade = form.querySelector("#quantidade")?.value.trim();

            if(nome === "") {
                alert("O nome do produto é obrigatório!");
                e.preventDefault();
                return;
            }

            if(preco === "" || isNaN(preco) || Number(preco) <= 0) {
                alert("Informe um preço válido maior que zero!");
                e.preventDefault();
                return;
            }

            if(quantidade === "" || isNaN(quantidade) || Number(quantidade) < 0) {
                alert("Informe uma quantidade válida (0 ou mais)!");
                e.preventDefault();
                return;
            }
        });
    }

    // Validação de exclusão
    function confirmarExclusao(formId) {
        let form = document.getElementById(formId);
        if (!form) return;

        form.addEventListener("submit", function(e) {
            if(!confirm("Tem certeza que deseja excluir este produto?")) {
                e.preventDefault();
            }
        });
    }

    // Aplicar validações
    validarFormulario("buscar_produto.php");
    validarFormulario("alterar_produto.php");
    confirmarExclusao("formExcluirProduto");

});



