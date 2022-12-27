import "http://127.0.0.1:5173/resources/css/wishlist-app.css";

const wishlistBtn = document.getElementById("awishlist-btn");
const getUrl = window.location.href;

if (wishlistBtn) {
    wishlistBtn.addEventListener("click", () => {
        console.log(getUrl);

        const distplayNotification = () => {
            const createdDiv = document.createElement("div");
            createdDiv.classList.add("wishlist-added");
            createdDiv.innerText = "Added to wishlist";
            wishlistBtn.insertAdjacentElement("afterend", createdDiv);

            setTimeout(() => createdDiv.remove(), 3000);
        };

        distplayNotification();
    });
}
