/* DELETE CONFIRMATION (MODERN POPUP) */

function confirmDelete(){

return showConfirm(

"Delete Item",

"Are you sure you want to delete this item?"

);

}



/* MODERN CONFIRM BOX */

function showConfirm(title,message){

return new Promise((resolve)=>{


const popup = document.createElement("div");


popup.classList.add("confirm-overlay");


popup.innerHTML = `


<div class="confirm-box glass-card floating-card">


<h3>

<i class="fa-solid fa-triangle-exclamation"></i>

${title}


</h3>


<p>${message}</p>


<div class="confirm-actions">


<button class="primary-btn" id="confirmYes">

Yes

</button>


<button class="secondary-btn" id="confirmNo">

Cancel

</button>


</div>


</div>

`;


document.body.appendChild(popup);



document.getElementById("confirmYes")

.onclick = ()=>{


popup.remove();


resolve(true);


};



document.getElementById("confirmNo")

.onclick = ()=>{


popup.remove();


resolve(false);


};


});

}



/* SUCCESS TOAST */

function showToast(msg){

const toast = document.createElement("div");


toast.className = "toast-msg";


toast.innerText = msg;


document.body.appendChild(toast);



setTimeout(()=>{

toast.classList.add("show");

},100);



setTimeout(()=>{

toast.remove();

},3000);


}

function confirmDelete(){

return confirm(
"Delete this supplier?\n\nProducts mapping will also be removed."
);

}