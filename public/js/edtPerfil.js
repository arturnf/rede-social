document.addEventListener('DOMContentLoaded', () => {
    // 1. Lógica de Pré-visualização da Imagem
    const imageUpload = document.getElementById('imageUpload');
    const profileImage = document.getElementById('profileImage');
    const editImageText = document.getElementById('editImageText');

    // Funções para simular o clique no input de arquivo
    const activateFileInput = () => {
        imageUpload.click();
    };

    // Adiciona evento de clique ao texto "Editar Imagem"
    editImageText.addEventListener('click', (e) => {
        e.preventDefault(); // Evita que a página recarregue
        activateFileInput();
    });


    // Lógica para pré-visualizar a imagem ao selecionar um arquivo
    imageUpload.addEventListener('change', function() {
        const file = this.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                // Define o src da imagem com o Data URL do arquivo selecionado
                profileImage.src = e.target.result;
            };
            
            // Lê o arquivo como Data URL (Base64)
            reader.readAsDataURL(file);
        }
    });

    // 2. Lógica do Contador de Caracteres da Bio
    const bioTextarea = document.getElementById('bio');
    const charCountSpan = document.getElementById('charCount');
    const maxLength = bioTextarea.getAttribute('maxlength');

    // Inicializa o contador (com o texto 'Programador back-end' do seu exemplo)
    const initialLength = bioTextarea.value.length;
    charCountSpan.textContent = `${initialLength}/${maxLength}`;

    // Atualiza o contador de caracteres a cada entrada de texto
    bioTextarea.addEventListener('input', () => {
        const currentLength = bioTextarea.value.length;
        charCountSpan.textContent = `${currentLength}/${maxLength}`;
    });

    // Oculta o ícone 'U' do avatar padrão se houver uma imagem padrão (opcional)
    // Se você estiver usando uma imagem padrão real, remova as propriedades CSS de texto do #profileImage e esta linha pode não ser necessária.
    // profileImage.style.backgroundColor = 'transparent'; 
});