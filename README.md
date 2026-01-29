# Viamatica API (Laravel)

API REST para gestión de películas y salas de cine, construida en Laravel con estructura por capas (Controllers, Model, Services, Repository), Swagger y colección de Postman.

## Requisitos

- PHP 8.2+ (recomendado por Laravel 12)
- Composer
- MySQL 8+

## Instalación

1) Clona el repositorio y entra al proyecto:

```bash
cd viamatica-api
```

2) Instala dependencias:

```bash
composer install
```

3) Configura el entorno `.env` (ya creado). Asegúrate de que los datos de MySQL estén correctos:

```dotenv
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=viamatica_api
DB_USERNAME=root
DB_PASSWORD=
```

4) Crea la base de datos en MySQL:

```sql
CREATE DATABASE viamatica_api;
```

## Migraciones (incluye stored procedure)

Ejecuta las migraciones para crear tablas y el procedimiento almacenado:

```bash
php artisan migrate
```

Esto crea:
- `pelicula`
- `sala_cine`
- `pelicula_salacine`
- Stored procedure `sp_contar_peliculas_sala` (requisito de la prueba)

## Swagger (documentación)

Se usa `darkaonline/l5-swagger`.

1) Genera la documentación:

```bash
php artisan l5-swagger:generate
```

2) Accede a Swagger UI:

```
http://localhost:8000/api/documentation
```

## Ejecutar el servidor

```bash
php artisan serve
```

Por defecto:
```
http://localhost:8000
```

## Estructura del proyecto

```
app/
  Controllers/   -> Endpoints
  Model/         -> Modelos y DTOs
    DTOs/
  Services/      -> Lógica de negocio
  Repository/    -> Acceso a datos / DB
```

## Endpoints

Base URL: `http://localhost:8000`

### Películas

- **Listar películas**
  - `GET /api/peliculas`

- **Obtener película por ID**
  - `GET /api/peliculas/{id}`

- **Crear película**
  - `POST /api/peliculas`
  - Body JSON:
    ```json
    {
      "nombre": "Matrix",
      "duracion": 136
    }
    ```

- **Actualizar película**
  - `PUT /api/peliculas/{id}`
  - Body JSON:
    ```json
    {
      "nombre": "Matrix Reloaded",
      "duracion": 138
    }
    ```

- **Eliminar película (soft delete)**
  - `DELETE /api/peliculas/{id}`

- **Buscar película por nombre**
  - `GET /api/peliculas/buscar/nombre?nombre=Matrix`

- **Buscar películas por fecha de publicación**
  - `GET /api/peliculas/buscar/fecha-publicacion?fecha_publicacion=YYYY-MM-DD`
  - Validación: formato `Y-m-d`

### Salas

- **Disponibilidad por nombre de sala**
  - `GET /api/salas/disponibilidad?nombre=Sala 1`

Reglas de negocio:
- Si la sala tiene **menos de 3 películas** → “Sala disponible”
- Si tiene **entre 3 y 5** → “Sala con [n] películas asignadas”
- Si tiene **más de 5** → “Sala no disponible”

## Postman

La colección está en el proyecto:

```
postman_collection.json
```

Importa el archivo en Postman y asegúrate de que `baseUrl` apunte a `http://localhost:8000`.

## Notas

- Se usan **soft deletes** en las entidades (eliminaciones lógicas).
- ORM: Eloquent.
- Stored procedure usado en la lógica de disponibilidad de salas.

## Scripts útiles

- Migrar: `php artisan migrate`
- Generar Swagger: `php artisan l5-swagger:generate`
- Servir app: `php artisan serve`
