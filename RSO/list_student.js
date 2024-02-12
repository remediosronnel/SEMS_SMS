let printBtn = document.querySelector("#print");
let cancelBtn = document.querySelector("#cancel")

printBtn.addEventListener("click", function () {
  window.print();
});

cancelBtn.addEventListener("click", function(){
  window.location.href = "home.php";
});

