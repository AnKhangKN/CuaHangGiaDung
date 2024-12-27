const showMenu = (toggleId, navbarId, bodyId) => {
    const toggle = document.getElementById(toggleId), 
    navbar = document.getElementById(navbarId),
    bodypadding = document.getElementById(bodyId)

    if (toggle && navbar) {
        toggle.addEventListener('click', () => {
            navbar.classList.toggle('show')
            bodypadding.classList.toggle('expander')
        })
    }
}

showMenu('bar-icon', 'navbar', 'body')

const linkColor = document.querySelectorAll('nav__link')
function colorLink() {
    linkColor.forEach(l => l.classList.remove('active'))
    this.classList.add('active')
}

linkColor.forEach(l => l.addEventListener('click', colorLink))

const BtnAddProduct = document.querySelector('.js-product__header-btn');
const ProductModal = document.querySelector('.js-product__modal');
const ModalAddContainer = document.querySelector('.js-product__modal-container');
const ProductModalClose = document.querySelector('.js-product__modal-close');

function showModalAddProduct() {
    ProductModal.classList.add("open");
}

function hideModalAddProduct() {
    ProductModal.classList.remove("open");
}

BtnAddProduct.addEventListener("click", showModalAddProduct);
ProductModalClose.addEventListener("click", hideModalAddProduct);
ProductModal.addEventListener("click", hideModalAddProduct);

ModalAddContainer.addEventListener("click", function (event) {
    event.stopPropagation();
});

