# symfony-user-api

## Описание

User API предоставляет набор RESTful методов для управления пользователями. API поддерживает операции создания, чтения, обновления и удаления пользователей, а также аутентификацию с помощью JWT токенов.

## Методы

### 1. Получить список пользователей

**URL**: `/api/user/`  
**Name**: `api_user_list`  
**Метод**: `GET`  
**Описание**: Возвращает список всех пользователей.

**Запрос**:

```curl
curl --location 'http://api.user.local//api/user/'
```
**Ответ**:
- 200:
```json
{
  "users": [
    {
      "id": 15,
      "name": "Иван Иванов",
      "login": "ivanivanov-1",
      "password": "$2y$13$B2mZ6l/Jizgg704GGvlDw.TA4.gRgF8tiVDgySbEMVIWj4Toqs00a",
      "sex": "0",
      "createdAt": "2024-08-05T00:01:41+03:00",
      "phone": "1234567890",
      "UpdatedAt": "2024-08-05T00:01:41+03:00",
      "email": "ivan@example.com",
      "birthday": "1990-01-01T00:00:00+03:00",
      "userIdentifier": "ivanivanov-1",
      "roles": [
        "ROLE_USER"
      ]
    },
    ...
  ]
}
```

### 2. Детальная пользователя информация по id

**URL**: `/api/user/{id}`  
**Name**: `api_user_show`  
**Метод**: `GET`  
**Описание**: Детальная пользователя информация по id

**Запрос**:

```curl
curl --location 'http://api.user.local//api/user/1'
```
**Ответ**:
- 200:
```json
{
  "id": 15,
  "name": "Иван Иванов",
  "login": "ivanivanov-1",
  "password": "$2y$13$B2mZ6l/Jizgg704GGvlDw.TA4.gRgF8tiVDgySbEMVIWj4Toqs00a",
  "sex": "0",
  "createdAt": "2024-08-05T00:01:41+03:00",
  "phone": "1234567890",
  "UpdatedAt": "2024-08-05T00:01:41+03:00",
  "email": "ivan@example.com",
  "birthday": "1990-01-01T00:00:00+03:00",
  "userIdentifier": "ivanivanov-1",
  "roles": [
    "ROLE_USER"
  ]
}
```
- 404:
```json
{
  "message": "Пользователь не найден"
}
```


### 3. Создание пользователя

**URL**: `/api/user/`  
**Name**: `api_user_create`  
**Метод**: `POST`  
**Описание**: Создание пользователя 

**Запрос**:

```curl
curl --location 'http://api.user.local//api/user/' \
--header 'Content-Type: application/json' \
--header 'Authorization: Bearer s' \
--data-raw '{
    "name": "Иван Иванов",
    "login": "ivanivanov-1",
    "password": "securepassword123",
    "email": "ivan@example.com",
    "sex": 0,
    "phone": "1234567890",
    "birthday": "1990-01-01"
}'
```
**Ответ**:
- 201:
```json
{
  "id": 15,
  "name": "Иван Иванов",
  "login": "ivanivanov-1",
  "password": "$2y$13$B2mZ6l/Jizgg704GGvlDw.TA4.gRgF8tiVDgySbEMVIWj4Toqs00a",
  "sex": "0",
  "createdAt": "2024-08-05T00:01:41+03:00",
  "phone": "1234567890",
  "UpdatedAt": "2024-08-05T00:01:41+03:00",
  "email": "ivan@example.com",
  "birthday": "1990-01-01T00:00:00+03:00"
}
```
- 400:
```json
{
  "message": [
    "Такой логин уже используется"
  ]
}
```


### 4. Обновление данных пользователя

**URL**: `/api/user/`  
**Name**: `api_user_update`  
**Метод**: `PUT`, `PATCH`  
**Описание**: Создание пользователя

**Запрос**:

```curl
curl --location --request PUT 'http://api.user.local/api/user/1' \
--form 'name="Vita"' \
--form 'phone="8945985463"' \
--form 'sex="1"' \
--form 'birthday="1990-05-15"'
```
**Ответ**:
- 200:
```json
{
  "id": 15,
  "name": "Иван Иванов",
  "login": "ivanivanov-1",
  "password": "$2y$13$B2mZ6l/Jizgg704GGvlDw.TA4.gRgF8tiVDgySbEMVIWj4Toqs00a",
  "sex": "0",
  "createdAt": "2024-08-05T00:01:41+03:00",
  "phone": "1234567890",
  "UpdatedAt": "2024-08-05T00:01:41+03:00",
  "email": "ivan@example.com",
  "birthday": "1990-01-01T00:00:00+03:00"
}
```
- 404:
```json
{
  "message": "Пользователь не найден"
}
```


### 5. Удаление пользователя

**URL**: `/api/user/{id}`  
**Name**: `api_user_delete`  
**Метод**: `DELETE`   
**Описание**: Удаление пользователя

**Запрос**:

```curl
curl --location --request DELETE 'http://api.user.local//api/user/1'
```
**Ответ**:
- 200:
```json
[]
```
- 404:
```json
{
  "message": "Пользователь не найден"
}
```

### 5. Авторизация пользователя

**URL**: `/api/user/auth`  
**Name**: `api_user_auth`  
**Метод**: `POST`
**Описание**: Авторизация пользователя

**Запрос**:

```curl
curl --location 'http://api.user.local//api/user/auth' \
--header 'Content-Type: application/json' \
--header 'Authorization: Bearer s' \
--data '{
    "login": "ivanivanov-1",
    "password": "securepassword123"
}'
```
**Ответ**:
- 200:
```json
{
  "user": {
    "id": 16,
    "name": "Иван Иванов",
    "login": "ivanivanov-1",
    "password": "$2y$13$XWYdSSWwvxbSNSeKTOhWa./FOjoJ90T9CORs6YbdfMLjrv9J9nsaG",
    "sex": "0",
    "createdAt": "2024-08-05T01:34:06+03:00",
    "phone": "1234567890",
    "UpdatedAt": "2024-08-05T01:34:06+03:00",
    "email": "ivan@example.com",
    "birthday": "1990-01-01T00:00:00+03:00",
    "userIdentifier": "ivanivanov-1",
    "roles": [
      "ROLE_USER"
    ]
  },
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MjI4MTA4NDksImV4cCI6MTcyMjgxNDQ0..."
}
```
- 404:
```json
{
  "message": "Логин или пароль не верный"
}
```