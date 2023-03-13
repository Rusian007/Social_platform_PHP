//get modal element//
var modal=document.getElementById('modal');
//get open modal button//
var button=document.getElementById('button');
//get close button//
var closeBtn=document.getElementsByClassName('close-btn')[0];


//listen for open click//
button.addEventListener('click',openModal);

//listen for close click//
closeBtn.addEventListener('click', closeModal);

//listen for outside click//
window.addEventListener('click',clickOutside);


//function to open modal//
function openModal(){
   modal.style.display='block';
}

function closeModal(){
    modal.style.display='none';
}

function clickOutside(e){
    if(e.target==modal){
        modal.style.display='block';
    }
}