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

# API

## POST /wp-json/api/award_medal
Atribui uma medalha (`medal_slug`) a um usuário (`target_id`)· 
Todos os argumentos são validados. 
O usuário atualmente logado é verificado antes do processamento. Se o `source_id` diferir do usuario logado a não ocorrerá processamento.
Obs.: O header `X-WP-Nonce` é requerido para autenticação. 

### parâmetros
- **target_id** - usuário que está dando a medalha. obrigatório
- **source_id** - usuário que está recebendo a medalha. obrigatório
- **medal_slug** - A medalha a ser atribuida seguindo o padrão `categoria_tipo`. Ex.: `competencias_cria`. obrigatório

### retorno
- **post_id** - o `post_id` do post criado ou -1 caso a medalha já exista (em status: pedding ou published) e não suporte duplicata

```JSON
{
  "post_id": 131
}
```

```JSON
{
  "post_id": -1
}
```


## GET /wp-json/api/medals/`{$user_id}`
Lista todas as medalhas (com status 'published') de um usuário (`user_id`).

### parâmetros
- **user_id** - identificador do usuário

### retorno
```JSON
[
  {
    "post_id": 127,
    "medal_slug": "competencias_cria",
    "source_id": "1",
    "target_id": "2"
  },
  {
    "post_id": 126,
    "medal_slug": "competencias_inova",
    "source_id": "1",
    "target_id": "2"
  },
  {
    "post_id": 125,
    "medal_slug": "oculta_gambiarra",
    "source_id": "1",
    "target_id": "2"
  },
  {
    "post_id": 124,
    "medal_slug": "oculta_desobediencia",
    "source_id": "1",
    "target_id": "2"
  }
]
```

## Para listagem de usuários:
[Users | REST API Handbook | WordPress Developer Resources](https://developer.wordpress.org/rest-api/reference/users/)

## Listagem generica de posts:
[Posts | REST API Handbook | WordPress Developer Resources](https://developer.wordpress.org/rest-api/reference/posts/)


## Erros comuns
### Usuário não logado, `X-WP-Nonce` não fornecido, usuário sem permissões para executar ação:
```JSON
{
  "code": "rest_forbidden",
  "message": "Sorry, you are not allowed to do that.",
  "data": {
    "status": 403
  }
}
```

### `X-WP-Nonce` inválido:
```JSON
{
  "code": "rest_cookie_invalid_nonce",
  "message": "Cookie nonce is invalid",
  "data": {
    "status": 403
  }
}
```
