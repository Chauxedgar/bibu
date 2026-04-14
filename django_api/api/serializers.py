"""
Serializers: convierten los modelos Django a/desde JSON.

- LibroSerializer        → serializa un libro (solo sus campos)
- ClienteSerializer      → serializa un cliente con datos del libro anidado
- ClienteWriteSerializer → para crear/actualizar, acepta idlibros como entero
"""

from rest_framework import serializers
from .models import Cliente, Libro


class LibroSerializer(serializers.ModelSerializer):
    """
    Serializer completo de Libro.
    Usado para GET (lectura) y POST/PUT (escritura).
    """
    # Campo extra calculado: cuántos clientes tienen asignado este libro
    total_clientes = serializers.SerializerMethodField()

    class Meta:
        model  = Libro
        fields = ['idlibros', 'titulo', 'autor', 'total_clientes']
        # idlibros es solo lectura (lo genera MySQL con AUTO_INCREMENT)
        read_only_fields = ['idlibros', 'total_clientes']

    def get_total_clientes(self, obj):
        """Cuenta cuántos clientes tienen asignado este libro."""
        return obj.clientes.count()


class LibroResumenSerializer(serializers.ModelSerializer):
    """
    Versión reducida de Libro, usada al anidar dentro de ClienteSerializer.
    Solo muestra título y autor, sin el contador de clientes.
    """
    class Meta:
        model  = Libro
        fields = ['idlibros', 'titulo', 'autor']


class ClienteSerializer(serializers.ModelSerializer):
    """
    Serializer de lectura para Cliente.
    Incluye los datos del libro anidado (titulo, autor).
    """
    # Anidar el libro completo en la respuesta GET
    libro = LibroResumenSerializer(source='idlibros', read_only=True)

    class Meta:
        model  = Cliente
        fields = ['id', 'name', 'email', 'phone_number', 'address', 'libro']


class ClienteWriteSerializer(serializers.ModelSerializer):
    """
    Serializer de escritura para Cliente.
    Acepta idlibros como número entero en POST y PUT.

    Ejemplo de body JSON:
    {
        "id": 10,
        "name": "Ana Torres",
        "email": "ana@mail.com",
        "phone_number": "3001234567",
        "address": "Calle 5 #10-20",
        "idlibros": 2
    }
    """
    # Hacemos idlibros opcional (un cliente puede no tener libro asignado)
    idlibros = serializers.PrimaryKeyRelatedField(
        queryset=Libro.objects.all(),
        required=False,
        allow_null=True
    )

    class Meta:
        model  = Cliente
        fields = ['id', 'name', 'email', 'phone_number', 'address', 'idlibros']
        read_only_fields = ['id']  # El ID se genera automáticamente en MySQL

    def validate_email(self, value):
        """Verifica que el email no esté ya registrado en otro cliente."""
        instance = self.instance  # None en POST, objeto existente en PUT
        qs = Cliente.objects.filter(email=value)
        if instance:
            qs = qs.exclude(pk=instance.pk)
        if qs.exists():
            raise serializers.ValidationError("Ya existe un cliente con ese email.")
        return value

    def validate_id(self, value):
        """En creación (POST), verifica que el ID no exista ya."""
        if self.instance is None:   # solo valida en POST
            if Cliente.objects.filter(pk=value).exists():
                raise serializers.ValidationError(f"Ya existe un cliente con ID {value}.")
        return value
