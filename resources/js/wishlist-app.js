import axios, { isCancel, AxiosError } from "axios";
const wishlistBtn = document.querySelector(".awishlist-btn");

if (wishlistBtn) {
    // import Noty from "noty";

    document
        .getElementsByTagName("head")[0]
        .insertAdjacentHTML(
            "beforeend",
            '<link rel="stylesheet" href="http://localhost:5173/resources/css/wishlist-app.css" />'
        );

    // import "noty/src/themes/mint.scss";
    // import "noty/src/noty.scss";
    // window.Noty = import("noty");

    const productId = wishlistBtn.dataset.product;
    const customerId = wishlistBtn.dataset.customer;
    const getUrl = window.location.href;
    const appDomain = "https://shopify-wishlist-app.test/api/";
    const shopId = Shopify.shop;

    if (wishlistBtn) {
        wishlistBtn.addEventListener("click", () => {
            if (wishlistBtn.classList.contains("active")) {
                removeWishlist();
            } else {
                addWishlist();
            }
        });
    }

    const addWishlist = () => {
        axios
            .post(`${appDomain}addToWishlist`, {
                shop_id: shopId,
                customer_id: customerId,
                product_id: productId,
            })
            .then((response) => {
                console.log(response);
                wishlistBtn.classList.add("active");
                distplayNotification("added to the wishlist");
            })
            .catch((error) => {
                console.log(error);
            });
    };

    const removeWishlist = () => {
        axios
            .post(`${appDomain}removeFromWishlist`, {
                shop_id: shopId,
                customer_id: customerId,
                product_id: productId,
            })
            .then((response) => {
                console.log(response);
                wishlistBtn.classList.remove("active");
                distplayNotification("removed from the wishlist");
            })
            .catch((error) => {
                console.log(error);
            });
    };

    const checkWishlist = () => {
        axios
            .post(`${appDomain}wishlistItemExists`, {
                shop_id: shopId,
                customer_id: customerId,
                product_id: productId,
            })
            .then((response) => {
                if (response.data === 1) {
                    wishlistBtn.classList.add("active");
                }
            })
            .catch((error) => {
                console.log(error);
            });
    };

    document.addEventListener("DOMContentLoaded", () => {
        checkWishlist();
    });

    const distplayNotification = (textToDisplay) => {
        const createdDiv = document.createElement("div");
        createdDiv.innerText = textToDisplay;
        wishlistBtn.insertAdjacentElement("afterend", createdDiv);
        setTimeout(() => createdDiv.remove(), 3000);
    };
}
