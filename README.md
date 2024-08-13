# Places

## Documentação de Teste da API

### 1. Obter um Token de Autenticação

Primeiro, você precisa obter um token de autenticação. Para isso, faça uma requisição POST para o endpoint `/api/login` com o e-mail e a senha do usuário.
Exemplo de Requisição:

```bash
curl -X POST http://127.0.0.1:8000/api/login \
-H "Content-Type: application/json" \
-d '{
  "email": "john.doe@example.com",
  "password": "password123"
}'
```

Resposta Esperada:

```json
{
  "token": "YOUR_VALID_TOKEN"
}
```

Copie o valor do token da resposta, pois você precisará dele para acessar as rotas protegidas.

### 2. Listar Todos os Lugares

Para listar todos os lugares, faça uma requisição GET para o endpoint `/api/places` com o token de autenticação no cabeçalho.
Exemplo de Requisição:

```bash
curl -X GET http://127.0.0.1:8000/api/places \
-H "Authorization: Bearer YOUR_VALID_TOKEN"
```

Resposta Esperada:

```json
{
  "data": []
}
```

### 3. Adicionar um Novo Lugar

Para adicionar um novo lugar, faça uma requisição POST para o endpoint `/api/places` com o token de autenticação e os dados do lugar no corpo da requisição.
Exemplo de Requisição:

```bash
curl -X POST http://127.0.0.1:8000/api/places \
-H "Authorization: Bearer YOUR_VALID_TOKEN" \
-H "Content-Type: application/json" \
-d '{
  "name": "Central Park",
  "city": "New York",
  "state": "NY"
}'
```

Resposta Esperada:
```json
{
  "id": 1,
  "name": "Central Park",
  "slug": "central-park",
  "city": "New York",
  "state": "NY",
  "created_at": "2024-08-10T00:00:00.000000Z",
  "updated_at": "2024-08-10T00:00:00.000000Z"
}
```

### 4. Visualizar um Lugar Específico

Para visualizar um lugar específico, faça uma requisição GET para o endpoint `/api/places/{place}` substituindo `{place}` pelo ID do lugar.
Exemplo de Requisição:

```bash
curl -X GET http://127.0.0.1:8000/api/places/1 \
-H "Authorization: Bearer YOUR_VALID_TOKEN"
```

Resposta Esperada:

```json
{
  "id": 1,
  "name": "Central Park",
  "slug": "central-park",
  "city": "New York",
  "state": "NY",
  "created_at": "2024-08-10T00:00:00.000000Z",
  "updated_at": "2024-08-10T00:00:00.000000Z"
}
```

### 5. Atualizar um Lugar Específico

Para atualizar um lugar específico, faça uma requisição PUT para o endpoint `/api/places/{place}` substituindo `{place}` pelo ID do lugar com o token de autenticação e os dados atualizados no corpo da requisição.
Exemplo de Requisição:

```bash
curl -X PUT http://127.0.0.1:8000/api/places/1 \
-H "Authorization: Bearer YOUR_VALID_TOKEN" \
-H "Content-Type: application/json" \
-d '{
  "name": "Updated Park",
  "city": "New York",
  "state": "NY"
}'
```

Resposta Esperada:

```json
{
  "id": 1,
  "name": "Updated Park",
  "slug": "updated-park",
  "city": "New York",
  "state": "NY",
  "created_at": "2024-08-10T00:00:00.000000Z",
  "updated_at": "2024-08-10T00:00:00.000000Z"
}
```

### 6. Deletar um Lugar Específico

Para deletar um lugar específico, faça uma requisição DELETE para o endpoint `/api/places/{place}` substituindo `{place}` pelo ID do lugar com o token de autenticação.
Exemplo de Requisição:

```bash
curl -X DELETE http://127.0.0.1:8000/api/places/1 \
-H "Authorization: Bearer YOUR_VALID_TOKEN"
```

Resposta Esperada:

```json
{}
```

Nota: A resposta pode ser um JSON vazio com status 204, indicando que o recurso foi removido com sucesso.

