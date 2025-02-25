# Sistema de Enquetes

Este é um sistema simples de enquetes desenvolvido em PHP e MySQL. Ele permite criar enquetes, votar e visualizar os resultados em tempo real.

## Requisitos
- PHP 7+
- MySQL
- Servidor Apache ou similar

## Instalação
1. Clone este repositório ou baixe os arquivos.
2. Crie um banco de dados MySQL chamado `enquetes`.
3. Execute o seguinte SQL para criar as tabelas necessárias:

```sql
CREATE TABLE enquetes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pergunta VARCHAR(255) NOT NULL
);

CREATE TABLE opcoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_enquete INT,
    opcao VARCHAR(255) NOT NULL,
    votos INT DEFAULT 0,
    FOREIGN KEY (id_enquete) REFERENCES enquetes(id)
);
