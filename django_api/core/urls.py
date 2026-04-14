"""
URLs principales del proyecto.

Estructura de endpoints disponibles:
  http://localhost:8000/api/clientes/       GET (listar), POST (crear)
  http://localhost:8000/api/clientes/{id}/  GET (detalle), PUT (actualizar), DELETE (eliminar)
  http://localhost:8000/api/libros/         GET (listar), POST (crear)
  http://localhost:8000/api/libros/{id}/    GET (detalle), PUT (actualizar), DELETE (eliminar)
"""

from django.contrib import admin
from django.urls import path, include

urlpatterns = [
    path('admin/', admin.site.urls),
    path('api/', include('api.urls')),   # todas las rutas de la API van en api/urls.py
]
