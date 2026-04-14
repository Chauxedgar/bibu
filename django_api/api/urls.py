"""
URLs de la app `api`.
El Router de DRF genera automáticamente todas las rutas CRUD.

Rutas generadas:
  GET    /api/libros/          → lista
  POST   /api/libros/          → crear
  GET    /api/libros/{id}/     → detalle
  PUT    /api/libros/{id}/     → actualizar
  DELETE /api/libros/{id}/     → eliminar

  GET    /api/clientes/        → lista
  POST   /api/clientes/        → crear
  GET    /api/clientes/{id}/   → detalle
  PUT    /api/clientes/{id}/   → actualizar
  DELETE /api/clientes/{id}/   → eliminar
"""

from django.urls import path, include
from rest_framework.routers import DefaultRouter
from .views import LibroViewSet, ClienteViewSet

# El router crea automáticamente todas las URLs CRUD
router = DefaultRouter(trailing_slash=True)
router.register(r'libros',   LibroViewSet,   basename='libro')
router.register(r'clientes', ClienteViewSet, basename='cliente')

urlpatterns = [
    path('', include(router.urls)),
]
