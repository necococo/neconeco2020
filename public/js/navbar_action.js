
// Get the container element
var btns = document.getElementById("btns");
// console.log(btns);
var dropDown1 =  document.getElementById("dropdown1");
// console.log(dropDown1);
dropDown1.addEventListener("click", function() {
    var activated = btns.getElementsByClassName("activated");
    console.log(activated.length);
    activated[0].classList.remove("activated");
});
   