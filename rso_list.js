let printBtn = document.querySelector("#print");
let saveBtn = document.querySelector("#save");
let cancelBtn = document.querySelector("#cancel")

printBtn.addEventListener("click", function () {
  window.print();
});

cancelBtn.addEventListener("click", function(){
  window.location.href = "generate_list.php";
});

