"""
Vistas de la API usando ModelViewSet de DRF.

Un ViewSet define automáticamente los métodos:
  list()     → GET  /api/libros/
  create()   → POST /api/libros/
  retrieve() → GET  /api/libros/{id}/
  update()   → PUT  /api/libros/{id}/
  destroy()  → DELETE /api/libros/{id}/
"""

from rest_framework import viewsets, status
from rest_framework.response import Response

from .models import Libro, Cliente
from .serializers import (
    LibroSerializer,
    ClienteSerializer,
    ClienteWriteSerializer,
)


class LibroViewSet(viewsets.ModelViewSet):
    """
    CRUD completo de libros.

    GET    /api/libros/        → lista todos los libros
    POST   /api/libros/        → crea un libro
    GET    /api/libros/{id}/   → detalle de un libro
    PUT    /api/libros/{id}/   → actualiza un libro
    DELETE /api/libros/{id}/   → elimina un libro
    """
    queryset         = Libro.objects.all()
    serializer_class = LibroSerializer

    def destroy(self, request, *args, **kwargs):
        """
        Al eliminar un libro, primero desasigna a los clientes que lo tienen.
        Así no rompe la integridad referencial.
        """
        libro = self.get_object()

        # Contar y desasignar clientes
        clientes_afectados = libro.clientes.count()
        if clientes_afectados > 0:
            libro.clientes.update(idlibros=None)

        libro.delete()

        mensaje = 'Libro eliminado correctamente.'
        if clientes_afectados > 0:
            mensaje += f' Se desasignó de {clientes_afectados} cliente(s).'

        return Response({'success': mensaje}, status=status.HTTP_200_OK)


class ClienteViewSet(viewsets.ModelViewSet):
    """
    CRUD completo de clientes.

    GET    /api/clientes/        → lista todos los clientes (con datos del libro)
    POST   /api/clientes/        → crea un cliente
    GET    /api/clientes/{id}/   → detalle de un cliente
    PUT    /api/clientes/{id}/   → actualiza un cliente
    DELETE /api/clientes/{id}/   → elimina un cliente
    """
    queryset = Cliente.objects.select_related('idlibros').all()

    def get_serializer_class(self):
        """
        Usa serializers diferentes según la operación:
        - Lectura  (GET)             → ClienteSerializer      (muestra libro anidado)
        - Escritura (POST, PUT)      → ClienteWriteSerializer (acepta idlibros como int)
        """
        if self.action in ['list', 'retrieve']:
            return ClienteSerializer
        return ClienteWriteSerializer

    def create(self, request, *args, **kwargs):
        """POST: crea un cliente y devuelve sus datos completos."""
        serializer = self.get_serializer(data=request.data)
        serializer.is_valid(raise_exception=True)
        cliente = serializer.save()

        # Responder con la representación de lectura (libro anidado)
        read_serializer = ClienteSerializer(cliente)
        return Response(
            {'success': 'Cliente creado correctamente.', 'data': read_serializer.data},
            status=status.HTTP_201_CREATED
        )

    def update(self, request, *args, **kwargs):
        """PUT: actualiza un cliente y devuelve sus datos completos."""
        partial = kwargs.pop('partial', False)
        instance = self.get_object()
        serializer = self.get_serializer(instance, data=request.data, partial=partial)
        serializer.is_valid(raise_exception=True)
        cliente = serializer.save()

        read_serializer = ClienteSerializer(cliente)
        return Response(
            {'success': 'Cliente actualizado correctamente.', 'data': read_serializer.data},
            status=status.HTTP_200_OK
        )

    def destroy(self, request, *args, **kwargs):
        """DELETE: elimina un cliente."""
        cliente = self.get_object()
        cliente.delete()
        return Response(
            {'success': 'Cliente eliminado correctamente.'},
            status=status.HTTP_200_OK
        )
