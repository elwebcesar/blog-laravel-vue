# Blog Laravel - Vue

Proyecto desarrollado de manera independiente Backend y  Frontend.

- Laravel 12.
- Vue 3.
---
### Estructura
/
-  backend-laravel/
	- /docker --> (configuraciones de Docker)
    - /src -> (Proyecto de Laraval)
	- docker-compose.yml (configuración de Docker)
	- laravel_backup_20250611.sql (backup base de datos)
	- Laravel blog.postman_collection.json (backup json postman)
-  frontend-vue/
	- / --> (configuraciones de Vue)
    - /src -> (Proyecto de Vue)

> En backend-laravel en este caso, utiliza un contenedor de Docker, pero se puede instalar de manera independiente.

Volumenes:
- mysql:8.0
- php:8.2
---

## Instalación

### 1. Backend

#### Contenedor Docker (si se usa)

Montar contenedor (solo si se usa docker)
`docker-compose up -d`

Ver contenedor interactivo (solo si se usa docker)
`docker ps`

Entrar al contenedor interactivo
`docker exec -it <nombre_o_id_del_contenedor> /bin/sh`

En mi caso el contenedor interactivo
`docker exec -it laravel-vue-app /bin/bash`

---

#### Laravel

Si se uso el contenedor suministrado, se debe acceder al contenedor de la aplicación.*
 _Punto anterior._

docker exec -it laravel-vue-app /bin/bash

Instalar Composer
`composer install`

Verificar la instalación de Composer
`composer --version`

Generar la clave de la aplicación
`php artisan key:generate`

Configurar datase.php según los parámetros.

#####Se suministra SQL con datos: laravel_backup_20250611.sql

---
### 2. Frontend
#### Vue
Proyecto creado con Vue CLI 

`npm run serve`

---
### Endpoints
|Acción  | URL  | Autorización |
| :------------ |:---------------:| -----:|
| Todos los Posts      | http://127.0.0.1:8000/api/posts | NO |
| Post paginados     | http://127.0.0.1:8000/api/posts/paginated?page=3&per_page=1        |   NO |
| Un Post | http://127.0.0.1:8000/api/posts/4       |    NO |
| Login | http://127.0.0.1:8000/api/v1/auth/login      |    SI |
| Crear / Editar Post | http://127.0.0.1:8000/api/v1/post/save        |   SI |
| Borrar Post | http://127.0.0.1:8000/api/v1/post/delete        |    SI |

##### Se suministra Colección de Postman: Laravel blog.postman_collection.json

---
## Credenciales de Acceso al Admin
##### elwebcesar@gmail.com
##### holamundo


---

### Proyecto by Cesar Fernandez
https://www.linkedin.com/in/cesar-design/
https://www.behance.net/cesarfernandezdesign
