# Zoox-test

Projeto criado como desafio da zoox smart data
Lista de cidades e estados com uma API e um Frontend simples

## Introdução

Estas instruções fornecerão uma cópia do projeto instalado e funcionando em sua máquina local para fins de desenvolvimento e teste. Consulte implantação para obter notas sobre como implantar o projeto em um sistema ativo.

### Pre requisitos

O que você precisa para instalar o software e como instalá-los


* php v7.2 ou superior
* extensão do mongodb instalada e ativada para seu ambiente PHP - [MongoDB PHP drivers](https://docs.mongodb.com/drivers/php)
* composer
* docker para subir uma instância do mongodb. Se você já possuir um rodando em outro local basta configurar essa conexão em config/database.php


### Instalação


1:

```
git clone https://github.com/wevertonteodorak/zoox-test.git zoox-test
cd zoox-test
composer install
```

2 - docker (pule se você já possuir uma instancia do mongodb para usar):

```
docker pull mongo
docker run -d -p 27017-27019:27017-27019 --name mongodb mongo
```

3 - entre no diretório public/ e suba um servidor http:

```
cd public/
php -S localhost:8000
```

4 - Abra seu browser (Chrome, Firefox, Opera ...) e acesse http://localhost:8000


## Testes
A partir do diretório raiz rode:

```
composer test
```


## Documentação da API
Após subir a aplicação acesse <IP_DA_APP>/docs


## Construido usando

* [PHP](https://www.php.net/docs.php) - The PHP
* [Slim PHP](http://www.slimframework.com/) - Framework PHP
* [VueJS](https://vuejs.org/) - The Progressive JavaScript Framework
