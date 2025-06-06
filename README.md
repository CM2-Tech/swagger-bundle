# CM2 Swagger Bundle

Bundle para gerar e servir automaticamente a documentação OpenAPI (`swagger.json`) com base em anotações do pacote [`zircote/swagger-php`](https://github.com/zircote/swagger-php), para projetos Symfony.

## Instalação

1. Adicione o bundle via `composer`:

composer require cm2-tech/swagger-bundle:^1.0

2. Habilite o bundle (se necessário):

Symfony Flex já deve fazer isso automaticamente. Caso contrário, edite config/bundles.php:

return [
    // ...
    CM2\SwaggerBundle\CM2SwaggerBundle::class => ['all' => true],
];

3. Adicione a variável de ambiente SWAGGER_TOKEN no seu arquivo .env ou .env.local:

SWAGGER_TOKEN=seu_token_secreto

Esta variável é obrigatória para proteger o acesso ao endpoint /\_swagger.
Sem ela, o acesso será negado.

4. Importe os endpoints do bundle, só tem 1 (/\_swagger):

swagger_bundle:
  resource: '@SwaggerBundle/Controller/'
  type: annotation

5. O controller precisa de argumentos, importe-os no services.yaml:

services:
  CM2\SwaggerBundle\Controller\SwaggerController:
    arguments:
      $sources:
        - '%kernel.project_dir%/src/Controller'
        - '%kernel.project_dir%/src/Entity'
    tags: ['controller.service_arguments']

## Uso

Acesse a URL:

/\_swagger?token=seu_token_secreto

Ela retornará o conteúdo do swagger.json com base nas anotações presentes em:

- src/Controller
- src/Entity

## Requisitos

- PHP >= 8.1
- Symfony >= 6.4
- zircote/swagger-php