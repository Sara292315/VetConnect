document.getElementById('form-citas').addEventListener('submit', function(e){
  e.preventDefault();
  alert('Solicitud de cita enviada (demostración). En la versión funcional esto se conectará al backend.');
});
document.getElementById('form-contacto').addEventListener('submit', function(e){
  e.preventDefault();
  alert('Mensaje enviado (demostración).');
});
document.getElementById('edad').addEventListener('input', function(){
  document.getElementById('edad-out').value = this.value;
});