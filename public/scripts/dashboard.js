// Script para hacer las filas de la tabla seleccionables
document.addEventListener('DOMContentLoaded', function() {
    // Seleccionar todas las filas con la clase 'selectable-row'
    const selectableRows = document.querySelectorAll('.selectable-row');
    
    // Agregar evento de clic a cada fila
    selectableRows.forEach(row => {
        row.addEventListener('click', function() {
            // Si la fila ya está seleccionada, deseleccionarla
            if (this.classList.contains('selected')) {
                this.classList.remove('selected');
            } else {
                // Opcional: deseleccionar todas las demás filas (para selección única)
                // selectableRows.forEach(r => r.classList.remove('selected'));
                
                // Seleccionar la fila actual
                this.classList.add('selected');
            }
            
            // Obtener datos de la fila seleccionada
            const pedido = this.cells[0].textContent;
            const precio = this.cells[1].textContent;
            const fecha = this.cells[2].textContent;
            const estado = this.cells[3].textContent;
            
            console.log('Fila seleccionada:', { pedido, precio, fecha, estado });
            
            // Aquí puedes agregar código adicional para manejar la selección
            // Por ejemplo, mostrar detalles en otro panel, habilitar botones, etc.
        });
    });
});