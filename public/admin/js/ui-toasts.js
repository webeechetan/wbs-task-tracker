function toast(head = 'Welcome',body = '',type = 'primary'){
  document.getElementById("toastHead").innerHTML = head;
  document.getElementById("toastBody").innerHTML = body;
  let toast = document.querySelector('.toast-placement-ex');
  toast.classList.add('bg-'+type);
  let toastPlacement = new bootstrap.Toast(toast);
  toastPlacement.show();
}
