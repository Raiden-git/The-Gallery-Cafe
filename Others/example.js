document.addEventListener("DOMContentLoaded", () => {
    const cartCountElement = document.getElementById("cart-count");
    const cartSidebar = document.getElementById("cart-sidebar");
    const closeCartButton = document.getElementById("close-cart-btn");
    const cartItemsContainer = document.querySelector(".cart-items-container");
    const cartTotalElement = document.getElementById("cart-total");

    function updateCartDisplay(cart) {
        cartItemsContainer.innerHTML = '';
        cart.forEach(item => {
            const cartItem = document.createElement("div");
            cartItem.className = "cart-item";

            cartItem.innerHTML = `
                <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                <div class="cart-item-details">
                    <p class="cart-item-name">${item.name}</p>
                    <p class="cart-item-price">$${item.price}</p>
                    <div class="cart-item-quantity">
                        <input type="number" value="${item.quantity}" min="1" data-id="${item.id}">
                    </div>
                </div>
                <button class="remove-item-btn" data-id="${item.id}">Remove</button>
            `;

            cartItemsContainer.appendChild(cartItem);

            const quantityInput = cartItem.querySelector("input");
            const removeButton = cartItem.querySelector(".remove-item-btn");

            quantityInput.addEventListener("change", (e) => {
                const newQuantity = parseInt(e.target.value, 10);
                const itemId = e.target.getAttribute("data-id");
                updateCartItemQuantity(itemId, newQuantity);
            });

            removeButton.addEventListener("click", (e) => {
                const itemId = e.target.getAttribute("data-id");
                removeCartItem(itemId);
            });
        });
    }

    function updateCartItemQuantity(id, quantity) {
        fetch('cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=update&id=${id}&quantity=${quantity}`,
        })
        .then(response => response.json())
        .then(data => {
            cartCountElement.textContent = data.cart.length;
            cartTotalElement.textContent = data.total.toFixed(2);
            updateCartDisplay(data.cart);
        });
    }

    function removeCartItem(id) {
        fetch('cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=remove&id=${id}`,
        })
        .then(response => response.json())
        .then(data => {
            cartCountElement.textContent = data.cart.length;
            cartTotalElement.textContent = data.total.toFixed(2);
            updateCartDisplay(data.cart);
        });
    }

    document.querySelectorAll(".add-to-cart-btn").forEach(button => {
        button.addEventListener("click", (e) => {
            const menuItem = button.closest(".menu-item");
            const id = menuItem.getAttribute("data-id");
            const name = menuItem.getAttribute("data-name");
            const price = parseFloat(menuItem.getAttribute("data-price"));
            const image = menuItem.getAttribute("data-image");
            const quantityInput = menuItem.querySelector("input");
            const quantity = parseInt(quantityInput.value, 10);

            fetch('cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=add&id=${id}&name=${name}&price=${price}&quantity=${quantity}&image=${image}`,
            })
            .then(response => response.json())
            .then(data => {
                cartCountElement.textContent = data.cart.length;
                cartTotalElement.textContent = data.total.toFixed(2);
                updateCartDisplay(data.cart);
            });
        });
    });

    document.querySelector(".cart-btn").addEventListener("click", () => {
        cartSidebar.classList.add("open");
    });

    closeCartButton.addEventListener("click", () => {
        cartSidebar.classList.remove("open");
    });
});
