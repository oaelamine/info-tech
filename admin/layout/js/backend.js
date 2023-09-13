/* LOGIN FORM START */
const inputs = document.querySelectorAll('input:not(input[type="submit"])');
const editProfilInputs = document.querySelectorAll(
	'.edit_profile input:not(input[type="submit"])'
);
//const eye = document.querySelector(".svg-inline--fa");
const confirmCatDelete = document.querySelectorAll(".confirmCatDelete");
const confirmMembrDelete = document.querySelectorAll(".confirmMembrDelete");

const placeHolder = function (elem) {
	const placeHolder = elem.getAttribute("placeholder");
	elem.addEventListener("focus", function () {
		this.setAttribute("placeholder", " ");
	});
	elem.addEventListener("blur", function () {
		this.setAttribute("placeholder", placeHolder);
	});
};

inputs.forEach((input) => {
	placeHolder(input);
});

/* LOGIN FORM END */
/* LOGIN FORM END */
editProfilInputs.forEach((inp) => {
	placeHolder(inp);
	if (inp.hasAttribute("required")) {
		inp.insertAdjacentHTML("afterend", '<span class="asterisk">*</span>');
		inp.closest("div").style.position = "relative";
	}
});

/* LOGIN FORM END */
/* ADD MEMBER START */
/* console.log(eye);
eye.addEventListener("click", (e) => {
	console.log("working");
	console.log(e.target);
	//this.closest("input[type=password]").setAttribute("type", "text");
}); */

confirmMembrDelete.forEach((el) => {
	el.addEventListener("click", function (e) {
		e.preventDefault();
		const url = this.getAttribute("href");
		if (confirm("Voulez-vous supprimer ce membre ?")) {
			window.open(url, "_self");
		} else {
			return;
		}
	});
});

/* END MEMBER MEMBEr*/

// DROPEND
const btnAdmin_menu = document.querySelector(".admin_menu button");
btnAdmin_menu.addEventListener("click", function () {
	document.querySelector(".admin_drop_menu").classList.toggle("hide");
});

// DELETE CAT CONFIRMATION
confirmCatDelete.forEach((el) => {
	el.addEventListener("click", function (e) {
		e.preventDefault();
		const url = this.getAttribute("href");
		if (confirm("Voulez-vous supprimer cette catégorie ?")) {
			window.open(url, "_self");
		} else {
			return;
		}
	});
});
