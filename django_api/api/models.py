"""
Modelos Django mapeados a las tablas MySQL que ya existen.

IMPORTANTE: usamos managed = False para que Django NO intente
crear ni modificar estas tablas (las maneja el PHP).
Si prefieres que Django gestione las migraciones, cambia a managed = True.
"""

from django.db import models


class Libro(models.Model):
    idlibros   = models.AutoField(primary_key=True)
    titulo     = models.CharField(max_length=255)
    autor      = models.CharField(max_length=255, blank=True, null=True)
    created_at = models.DateTimeField(auto_now_add=True, null=True)

    class Meta:
        db_table = 'libros'
        managed  = False
        ordering = ['titulo']

    def __str__(self):
        return f"{self.titulo} — {self.autor}"


class Cliente(models.Model):
    """
    Mapea la tabla `clientes` existente en MySQL.
    Campos: id, name, email, phone_number, address, idlibros (FK)
    """
    id           = models.IntegerField(primary_key=True)
    name         = models.CharField(max_length=255)
    email        = models.EmailField(max_length=255)
    phone_number = models.CharField(max_length=50, blank=True, null=True)
    address      = models.CharField(max_length=255, blank=True, null=True)
    idlibros     = models.ForeignKey(
        Libro,
        db_column='idlibros',   # nombre de la columna en la tabla
        on_delete=models.SET_NULL,
        null=True,
        blank=True,
        related_name='clientes'
    )
    created_at = models.DateTimeField(auto_now_add=True, null=True)

    class Meta:
        db_table = 'clientes'
        managed  = False
        ordering = ['id']

    def __str__(self):
        return f"{self.name} ({self.email})"
