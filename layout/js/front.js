let path = window.location.pathname;

const comptlick = document.querySelector(".compt-lick");
const comptMenu = document.querySelector(".compt-menu");

const userMenu = document.querySelector(".login-btn");
const userDpMenu = document.querySelector(".user-dp-menu");

const shopCart = document.querySelector(".shop-cart");
const cart = document.querySelector(".cart");

const slider = document.querySelector(".slider");

const loginMmodal = document.querySelector(".login-modal");
const overlay = document.querySelector(".overlay");
const btnCloseModal = document.querySelector(".btn--close-modal");
const btnsOpenModal = document.querySelector(".btn--show-modal");

const pageUserMenuLinks = document.querySelectorAll(".page-user-menu li a");

const operationsTabContainer = document.querySelector(
	".operations__tab-container"
);
const operationsContent = document.querySelectorAll(
	".operations__tab__content"
);

const art_sec_imgs = document.querySelectorAll(".art_sec_imgs img");
const art_main_img = document.querySelector(".art_main_img img");

const cart__div = document.querySelectorAll(".cart__div");

//ShowHide Function
const shoHide = function (element, act1, act2) {
	element.classList.add(`${act1}`);
	element.classList.remove(`${act2}`);
};
//buttom navbar dpmenu
comptlick?.addEventListener("mouseover", function () {
	shoHide(comptMenu, "show", "hide");
});
comptlick?.addEventListener("mouseout", function () {
	shoHide(comptMenu, "hide", "show");
});
//top navbar db menu
userMenu?.addEventListener("mouseover", function () {
	shoHide(userDpMenu, "show", "hide");
});
userMenu?.addEventListener("mouseout", function () {
	shoHide(userDpMenu, "hide", "show");
});
//cart show hide
const cartShow = function () {
	shoHide(cart, "show", "hide");
};
const cartHide = function () {
	shoHide(cart, "hide", "show");
};
shopCart?.addEventListener("mouseover", cartShow);
shopCart?.addEventListener("mouseout", cartHide);

//REMOUVE THE EVENT LISTNER
if (path === "/e-commerce-proto/orders.php") {
	shopCart?.removeEventListener("mouseover", cartShow);
	shopCart?.removeEventListener("mouseout", cartHide);
}
// SLIDER START
if (slider) {
	let isDraigngStart = false,
		prevPageX,
		prevScrolleLeft;

	const dragStart = (e) => {
		isDraigngStart = true;
		prevPageX = e.pageX; //les coordonner ta3 win clikit
		prevScrolleLeft = slider.scrollLeft; //chhal men PX scrollit men slider's div
	};

	const dragEnd = () => {
		isDraigngStart = false;
	};

	const draging = (e) => {
		if (!isDraigngStart) return;
		e.preventDefault();
		let positionDiff = e.pageX - prevPageX;
		slider.scrollLeft = prevScrolleLeft - positionDiff;
	};

	slider.addEventListener("mousedown", dragStart);
	slider.addEventListener("mouseup", dragEnd);
	slider.addEventListener("mousemove", draging);
}
// SLIDER END

// MODAL START
const openModal = function (e) {
	e.preventDefault();
	loginMmodal.classList.remove("hidden");
	overlay.classList.remove("hidden");
};

const closeModal = function () {
	loginMmodal.classList.add("hidden");
	overlay.classList.add("hidden");
};
//Modal Event

// if (path === "/e-commerce-proto/index.php") {
// }
btnsOpenModal?.addEventListener("click", openModal);

btnCloseModal?.addEventListener("click", closeModal);
overlay?.addEventListener("click", closeModal);

document.addEventListener("keydown", function (e) {
	if (e.key === "Escape" && !loginMmodal.classList.contains("hidden")) {
		closeModal();
	}
});

// MODAL END
// VALIDATION FUNCTION

// RESET FUNCTION
const inputResSet = function (form, ...inputs) {
	form.querySelectorAll(".validation-err").forEach((el) => el.remove());
	if (!inputs) return;
	inputs.forEach((el) => (el.style.borderColor = "#ced4da"));
	errNumber = 0;
	//input.style.borderColor = "#ced4da";
};

// VALIDATION FUNCTION
const dsplayMsg = function (input, msg) {
	input.parentElement.insertAdjacentHTML(
		"beforeend",
		`<p class='validation-err' style="color:red">${msg}</p>`
	);
	input.style.borderColor = "red";
};

// 	USER EDIT INFO FORM VALIDATION START
if (
	path === "/e-commerce-proto/infoacount.php" ||
	path === "/e-commerce-proto/signin.php"
) {
	const editUserInfo = document.querySelector(".edit-user-info");
	const fullname = editUserInfo.querySelector('input[name="fullname"]');
	const username = editUserInfo.querySelector('input[name="username"]');
	const email = editUserInfo.querySelector('input[name="email"]');
	const password = editUserInfo.querySelector('input[name="password"]');
	const submit = editUserInfo.querySelector('button[type="submit"]');

	//SUBMIT LISTNER
	submit.addEventListener("click", function (e) {
		let errNumber = 0;
		// remouve the errors
		password
			? inputResSet(editUserInfo, fullname, username, email, password)
			: inputResSet(editUserInfo, fullname, username, email);

		e.preventDefault();

		// fullname validation
		if (fullname.value.length === 0) {
			dsplayMsg(fullname, "Full Name filed cant bee empty");
			errNumber++;
		}
		if (fullname.value.length < 4) {
			dsplayMsg(fullname, "Full Name cant bee less then 4 charecters");
			errNumber++;
		}
		if (fullname.value.length > 30) {
			dsplayMsg(fullname, "Full Name cant bee more then 30 charecters");
			errNumber++;
		}

		// username validation
		if (username.value.length === 0) {
			dsplayMsg(username, "User Name filed cant bee empty");
			errNumber++;
		}
		if (username.value.length < 4) {
			dsplayMsg(username, "User Name cant bee less then 4 charecters");
			errNumber++;
		}
		if (username.value.length > 20) {
			dsplayMsg(username, "User Name cant bee more then 20 charecters");
			errNumber++;
		}

		// username validation
		if (email.value.length === 0) {
			dsplayMsg(email, "E-mail Name filed cant bee empty");
			errNumber++;
		}
		if (!email.value.includes("@")) {
			dsplayMsg(email, "This is not an E-mail");
			errNumber++;
		}

		// password validation;
		if (password && password.value.length === 0) {
			dsplayMsg(password, "password filed cant bee empty");
			errNumber++;
		}

		if (errNumber === 0) {
			editUserInfo.submit();
		}
	});
}
// USER EDIT INFO FORM VALIDATION END

// MODAL VALIDATION START
const modal__form = document.querySelector(".modal__form");
const user = modal__form?.querySelector("input[name=user]");
const userpass = modal__form?.querySelector("input[name=userpass]");
const modal__btn = modal__form?.querySelector(".modal__btn");

modal__btn?.addEventListener("click", function (e) {
	let errNumber = 0;
	inputResSet(modal__form, user, userpass);
	e.preventDefault();

	if (user.value === "") {
		dsplayMsg(user, "Insérer votre identifiant");
		errNumber++;
	}
	if (userpass.value === "") {
		dsplayMsg(userpass, "Insérer votre mot de pass");
		errNumber++;
	}

	if (errNumber === 0) {
		modal__form.submit();
	}
});

// TOTAL INPUT AUTO START
if (path === "/e-commerce-proto/orders.php") {
	const orderTotal = document.querySelector(".orderTotal"); // get the input element
	orderTotal?.addEventListener("input", resizeInput); // bind the "resizeInput" callback on "input" event
	resizeInput.call(orderTotal); // immediately call the function

	function resizeInput() {
		this.style.width = this.value?.length + "ch";
	}
}
// TOTAL INPUT AUTO ENDS
// START OPERATION TAB
// if (path === "/e-commerce-proto/" || path === "/e-commerce-proto/index.php") {
if (operationsTabContainer !== null && operationsContent !== null) {
	// OPERATION TAB
	operationsTabContainer.addEventListener("click", function (e) {
		//CHANG THE TAB
		Array.from(operationsTabContainer.children).forEach((el) =>
			el.classList.remove("operations__tab--active")
		);

		const clickedTarget = e.target.closest(".operations__tab");

		if (!clickedTarget) return;

		clickedTarget.classList.add("operations__tab--active");

		//CHANGE THE CONTENT
		operationsContent.forEach((el) =>
			el.classList.remove("operations__content--active")
		);
		document
			.querySelector(`.operations__content--${clickedTarget.dataset.tab}`)
			.classList.add("operations__content--active");
	});

	//DISPLAY SECTIONS ON SCROLL
	const sectionObserverCallback = (enteries, observer) => {
		const [entry] = enteries; //beacuse we only have one value in the threshold

		if (!entry.isIntersecting) return;

		entry.target.classList.remove("section--hidden");
		observer.unobserve(entry.target);
	};

	const sectoionOptions = {
		root: null,
		threshold: 0.15,
	};

	const sectionObserver = new IntersectionObserver(
		sectionObserverCallback,
		sectoionOptions
	);

	const allSections = document.querySelectorAll(".section");

	allSections.forEach((sec) => {
		sectionObserver.observe(sec);
		sec.classList.add("section--hidden");
	});

	// END OPERATION TAB

	//Countdown Timer

	let countDownDate = new Date("Aug 1, 2023 00:00:00").getTime();

	let counter = setInterval(() => {
		// Get Date Now
		let dateNow = new Date().getTime();

		// Find The Date Difference Between Now And Countdown Date
		let dateDiff = countDownDate - dateNow;

		// Get Time Units
		// let days = Math.floor(dateDiff / 1000 / 60 / 60 / 24);
		let days = Math.floor(dateDiff / (1000 * 60 * 60 * 24)); //days
		let hours = Math.floor(
			(dateDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
		); //houers
		let minutes = Math.floor((dateDiff % (1000 * 60 * 60)) / (1000 * 60));
		let seconds = Math.floor((dateDiff % (1000 * 60)) / 1000);

		const daysSpan = document.querySelector(".days");
		const hoursSpan = document.querySelector(".hours");
		const minutesSpan = document.querySelector(".minutes");
		const secondsSpan = document.querySelector(".seconds");

		if (
			daysSpan !== null &&
			hoursSpan !== null &&
			minutesSpan !== null &&
			secondsSpan !== null
		) {
			daysSpan.innerHTML = days < 10 ? `0${days}` : days;
			hoursSpan.innerHTML = hours < 10 ? `0${hours}` : hours;
			minutesSpan.innerHTML = minutes < 10 ? `0${minutes}` : minutes;
			secondsSpan.innerHTML = seconds < 10 ? `0${seconds}` : seconds;
		}
		if (dateDiff < 0) {
			clearInterval(counter);
		}
	}, 1000);
}

// ARTICLE INFO IMAGE CHANGING

if (art_sec_imgs !== null && art_main_img !== null) {
	//CHANGE THE IMAGE
	art_sec_imgs.forEach((img) => {
		img.addEventListener("click", function (e) {
			let srcMain = art_main_img.getAttribute("src");
			let srcSecend = e.target.getAttribute("src");

			art_main_img.setAttribute("src", srcSecend);
		});
	});
}

// ADD TO CART LINK CHANGE
// console.log(cart__div[0].closest("form.article_box"));

if (cart__div !== null) {
	const cart__div__link = `<a href="orders.php" class="modal__btn ps-2 pe-2 pt-1 pb-1 fs-6 me-2">Voire liste des commandes</a>`;

	cart__div.forEach((div) => {
		div.addEventListener("click", function () {
			let form = this.closest("form.article_box");
			form.addEventListener("submit", function () {
				div.innerHTML = "";
				div.innerHTML = cart__div__link;
			});
		});
	});
}

/////////////////////////////////////////////////test
const div =
	'{"div.widget_shopping_cart_content":"<div class="widget_shopping_cart_content">\n\n<div class="woocommerce-mini-cart cart_list product_list_widget ">\n\n\t\t\t\n\t\t\t<ul class="cart-widget-products">\n\t\t\t\t\t\t\t\t\t\t<li class="woocommerce-mini-cart-item mini_cart_item">\n\t\t\t\t\t\t\t<a href="https://habrisports.net/panier/?remove_item=b86b8c4fa6f55a31dd1964bd374d654f&#038;_wpnonce=96efcbd27b" class="remove remove_from_cart_button" aria-label="Remove this item" data-product_id="17596" data-cart_item_key="b86b8c4fa6f55a31dd1964bd374d654f" data-product_sku=""><i class="et-icon et-delete"></i></a>\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<a href="https://habrisports.net/product/horizon-gr6-indoor-cycle/" class="product-mini-image">\n\t\t\t\t\t\t\t\t\t<img width="300" height="300" src="//habrisports.net/wp-content/uploads/2022/04/GR6-1-300x300.jpg" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="" srcset="//habrisports.net/wp-content/uploads/2022/04/GR6-1-300x300.jpg 300w, //habrisports.net/wp-content/uploads/2022/04/GR6-1-150x150.jpg 150w, //habrisports.net/wp-content/uploads/2022/04/GR6-1-600x600.jpg 600w, //habrisports.net/wp-content/uploads/2022/04/GR6-1-100x100.jpg 100w" sizes="(max-width: 300px) 100vw, 300px" />\t\t\t\t\t\t\t\t</a>\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class="product-item-right">\n\t\t\t\t\t\t\t\t<h4 class="product-title">\n\t\t\t\t\t\t\t\t\t<a href="https://habrisports.net/product/horizon-gr6-indoor-cycle/">\n\t\t\t\t\t\t\t\t\t\tHORIZON GR6 INDOOR CYCLE\t\t\t\t\t\t\t\t\t</a>\n\t\t\t\t\t\t\t\t</h4>\n\n\t\t\t\t\t\t\t\t<div class="descr-box">\n\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<span class="quantity">1 &times; <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#x62f;.&#x62c;</span>225,000.00</span></span>\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t</div>\n\n\t\t\t\t\t\t</li>\n\t\t\t\t\t\t\t\t\t</ul>\n\n\t\t\n\n\t\t\n\t\t\t<div class="cart-popup-footer">\n\t\t\t\t<a href="https://habrisports.net/panier/" class="btn-view-cart wc-forward">Shopping cart (1)</a>\n\t\t\t\t<div class="cart-widget-subtotal woocommerce-mini-cart__total total">\n\t\t\t\t\t<span class="small-h">Subtotal:</span><span class="big-coast"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#x62f;.&#x62c;</span>225,000.00</span></span>\t\t\t\t</div>\n\t\t\t</div>\n\n\t\t\t\n\t\t\t<p class="buttons">\n\t\t\t\t<a href="https://habrisports.net/commande/" class="button btn-checkout wc-forward">Checkout</a>\t\t\t</p>\n\n\t\t\t\n\t\t\n\t\t\n</div><!-- end product list -->\n\n\n</div>","span.shop-text":"\t\t<span class="shop-text"><span class="cart-items">Cart:</span> <span class="total"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#x62f;.&#x62c;</span>225,000.00</span></span></span>\n\t\t","span.badge-number":"\t\t\t<span class="badge-number number-value-1" data-items-count="1">1</span>\n\t\t","span.popup-count":"\t\t<span class="popup-count popup-count-1"></span>\n\t\t"}';

const div2 = JSON.parse(div);

console.log("OK");
console.log(div2);
