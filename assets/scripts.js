// Inicializa o AOS
AOS.init();

// Insere a data atual nos inputs de data e adiciona '*' aos requireds
document.querySelectorAll('input,textarea,select').forEach((input) => {
  let name = input.getAttribute('name');
  let type = input.getAttribute('type');
  let required = input.required;
  let label = document.querySelector(`label[for="${name}"]`);
  if(type=='date') { input.valueAsDate = new Date(); }
  if(required && label) { label.innerHTML = label.innerHTML + '&nbsp;<b>*</b>'; }
});