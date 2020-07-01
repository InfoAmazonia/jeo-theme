# JEO Theme
## Clonando o repositório
Clone o repositório e seus submódulos recursivamente:

```
$ git clone git@github.com:EarthJournalismNetwork/jeo-theme.git --recursive
```
## Desenvolvimento
### Editor
Para o desenvolvimento recomenda-se a utilização do editor Visual Studio Code com as seguintes extenções:

- EditorConfig for VS Code
- PHP Intelephense
- Docker
- Beautify
- Beautify css/sass/scss/less
- GitLens
- ...
## Requisitos
Para o desenvolvimento é requisito ter instaladas ao menos as seguintes ferramentas:
- **Git**
- **Docker** e **Docker Compose** - Docker é a ferramenta recomendada para desenvolver localmente. Para instalá-lo siga [estas instruções](https://docs.docker.com/install/#supported-platforms).
- **node** e **npm**
## Subindo o ambiente
Abra outro terminal e na raíz do repositório execute o comando abaixo:

```
docker-compose up
```
Acesse http://localhost para ver o site.

### Compilando os assets do tema
Os assets serão automaticamente compilados pelo `watcher`, mas se preferir, abra um terminar, vá até a a pasta `themes/jeo-theme/` e execute os comandos abaixo:

```
$ npm install
$ npm run watch # vai ficar observando as mudanças nos assets
```

## Scripts para desenvolvimento
Há uma série de scripts úteis na pasta `dev-scripts`
- **dump** - faz um dump do banco de desenvolvimento<br>
    exemplo de uso: `dev-scripts/$ ./dump > dump.sql`
- **mysql** - entra no shell do mysql com o usuário wordpress
- **mysql-root** - entra no shell do mysql com o usuário root
- **wp** - executa o comando wp-cli dentro do container wordpress<br>
    exemplo de uso: `dev-scripts/$ ./wp search-replace https:// http://`

## Importar um dump de banco de dados
Se você tem um dump de banco de dados `.sql` ou `.sql.gz`, para importá-lo em sua versão local, copie o arquivo para `compose/local/mariadb/data` e execute:

```
docker-compose down -v # o parametro -v apaga os dados do mariadb
docker-compose up 
```

# Instalando plugins e temas

## Copiando arquivos para dentro do repositório
O conteúdo de `wp-content` está excluído do versionamento por padrão. Para adicionar seu plugin ou tema como parte do repositório, você deve colocá-los nas pastas `plugins` ou `themes` que estão na raiz do repositório.

<br>