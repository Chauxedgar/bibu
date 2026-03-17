<!DOCTYPE html>
<html>
<head>
    <title>Agregar Cliente</title>
    <link rel="stylesheet" href="Styles/stylesAgregar.css">
</head>
<body>
    <div class="container">
        <h2>Agregar Nuevo Cliente</h2>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">ID:</label>
                <input type="number" id="id" name="id" required>
            </div>

            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Teléfono:</label>
                <input type="tel" id="phone" name="phone">
            </div>
            
            <div class="form-group">
                <label for="address">Dirección:</label>
                <textarea id="address" name="address" rows="3"></textarea>
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn-submit">Guardar Cliente</button>
                <button type="button" class="btn-cancelar" onclick="window.parent.cerrarModal()">Cancelar</button>
            </div>
        </form>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Funcionalidad desactivada - Solo interfaz visual');
            window.parent.cerrarModal(); 
        });
    </script>
</body>
</html>