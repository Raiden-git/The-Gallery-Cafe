document.addEventListener("DOMContentLoaded", () => {
    const addToCartButtons = document.querySelectorAll(".add-to-cart-btn");
    const cartCountElement = document.getElementById("cart-count");
    const cartSidebar = document.getElementById("cart-sidebar");
    const closeCartButton = document.getElementById("close-cart-btn");
    const cartItemsContainer = document.querySelector(".cart-items-container");
    const cartTotalElement = document.getElementById("cart-total");
    let cart = [];
    let cartCount = 0;

    function updateCartCount() {
        cartCount = cart.reduce((total, item) => total + item.quantity, 0);
        cartCountElement.textContent = cartCount;
    }

    function updateCartTotal() {
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        cartTotalElement.textContent = total.toFixed(2);
    }

    function renderCartItems() {
        cartItemsContainer.innerHTML = '';
        cart.forEach(item => {
            const cartItem = document.createElement("div");
            cartItem.className = "cart-item";

            cartItem.innerHTML = `
                <div class="cart-item-details">
                    <p class="cart-item-name">${item.name}</p>
                    <p class="cart-item-price">$${item.price}</p>
                    <div class="cart-item-quantity">
                        <input type="number" value="${item.quantity}" min="1" data-name="${item.name}">
                    </div>
                </div>
                <button class="remove-item-btn" data-name="${item.name}">Remove</button>
            `;

            cartItemsContainer.appendChild(cartItem);

            const quantityInput = cartItem.querySelector("input");
            const removeButton = cartItem.querySelector(".remove-item-btn");

            quantityInput.addEventListener("change", (e) => {
                const newQuantity = parseInt(e.target.value, 10);
                const itemName = e.target.getAttribute("data-name");
                const cartItem = cart.find(item => item.name === itemName);
                cartItem.quantity = newQuantity;
                updateCartCount();
                updateCartTotal();
            });

            removeButton.addEventListener("click", (e) => {
                const itemName = e.target.getAttribute("data-name");
                cart = cart.filter(item => item.name !== itemName);
                updateCartCount();
                updateCartTotal();
                renderCartItems();
            });
        });
    }

    addToCartButtons.forEach(button => {
        button.addEventListener("click", () => {
            const menuItem = button.closest(".menu-item");
            const name = menuItem.getAttribute("data-name");
            const price = parseFloat(menuItem.getAttribute("data-price"));
            const quantityInput = menuItem.querySelector("input[type='number']");
            const quantity = parseInt(quantityInput.value, 10);

            const existingCartItem = cart.find(item => item.name === name);
            if (existingCartItem) {
                existingCartItem.quantity += quantity;
            } else {
                cart.push({ name, price, quantity });
            }

            updateCartCount();
            updateCartTotal();
            renderCartItems();
        });
    });

    document.querySelector(".cart-btn").addEventListener("click", () => {
        cartSidebar.classList.add("open");
    });

    closeCartButton.addEventListener("click", () => {
        cartSidebar.classList.remove("open");
    });
});
