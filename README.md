# 🐳 Dockerización — CRUD Clientes (PHP + MySQL)

## Estructura de carpetas

```
tu-proyecto/
├── docker-compose.yml
├── Dockerfile
├── db/
│   └── init.sql          ← esquema inicial de la BD
└── src/                  ← aquí va TODO tu proyecto PHP
    ├── index.php
    ├── config.php        ← usa el config.php nuevo (host: 'db')
    ├── libros.php
    ├── dashboard.php
    ├── scripts.js
    └── assets/           ← carpeta con CSS/JS del template Mazer
```

---

## Pasos para levantar el proyecto

### 1. Copia los archivos Docker
Coloca `docker-compose.yml`, `Dockerfile` y la carpeta `db/` en la raíz de tu proyecto.

### 2. Mueve tu código a la carpeta `src/`
```bash
mkdir src
# Copia/mueve todos tus archivos PHP, JS, assets, etc. dentro de src/
```

### 3. Reemplaza tu config.php
Usa el `config.php` incluido en esta entrega — el único cambio es:
```php
$host = 'db';  // antes era 'localhost'
```

### 4. (Opcional) Importa tu BD existente
Si ya tienes un `.sql` exportado desde phpMyAdmin en XAMPP:
- Reemplaza el contenido de `db/init.sql` con tu propio dump.
- O déjalo vacío y luego importa desde phpMyAdmin en el navegador.

### 5. Levanta los contenedores
```bash
docker compose up -d
```

### 6. Accede a la aplicación

| Servicio    | URL                        |
|-------------|----------------------------|
| Tu app PHP  | http://localhost:8080       |
| phpMyAdmin  | http://localhost:8081       |

---

## Comandos útiles

```bash
# Ver logs de todos los contenedores
docker compose logs -f

# Ver logs solo del contenedor PHP
docker compose logs -f app

# Detener todo
docker compose down

# Detener y borrar la BD (¡cuidado!)
docker compose down -v

# Reconstruir la imagen PHP (si cambias el Dockerfile)
docker compose build app
docker compose up -d
```

---

## Notas importantes

- **El volumen `db_data`** guarda los datos de MySQL aunque apagues los contenedores.
- **`src/`** está montado como volumen, así que los cambios en tu código se reflejan **en vivo** sin reconstruir la imagen.
- Si ves error de conexión a la BD al arrancar, espera 5-10 segundos y recarga — MySQL tarda un momento en inicializar.
