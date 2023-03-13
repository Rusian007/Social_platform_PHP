var IsOpen = true;
document.getElementById("open-icon").style.display = "none";

function Drawer() {
  if (IsOpen) {
    // hide
    document.getElementById("left").style.width = "0px";

    document.getElementById("left").classList.remove("padding");
    document.getElementById("left").classList.add("padding-remove");

    document.getElementById("open-icon").style.display = "block";
    IsOpen = false;
  } else {
    // Show the div
    document.getElementById("left").style.width = "200px";

    document.getElementById("left").classList.remove("padding-remove");
    document.getElementById("left").classList.add("padding");

    document.getElementById("open-icon").style.display = "none";
    IsOpen = true;
  }
}

const backdrop = document.getElementById("p-modal");
const forgotBtn = document.getElementById("forgot-btn");
const closeBtn = document.getElementById("close-btn");
const createPostBtn = document.getElementById("create-post-btn");

backdrop.style.display = "none";

createPostBtn.addEventListener("click", () => {
  backdrop.style.display = null;
});

backdrop.addEventListener("click", (e) => {
  if (e.target.id === "p-modal") {
    backdrop.style.display = "none";
  }
});

closeBtn.addEventListener("click", () => {
  backdrop.style.display = "none";
});

//upload picture for post//
const display=document.querySelector('.media-display')
const input=document.querySelector('#file')
let img=document.querySelector('img')

input.addEventListener("change", () => {
  let reader=new FileReader();
  reader.readAsDataURL(input.files[0]);
  reader.addEventListener("load",()=>{
    display.innerHTML=`<img src=${reader.result} alt=''/>`;
  });
});