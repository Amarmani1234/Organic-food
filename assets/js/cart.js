document.addEventListener("DOMContentLoaded", function () {
  const cartBody = document.querySelector("#offcanvasCart .offcanvas-body");
  
  function loadCart() {
    fetch("/wp-admin/admin-ajax.php?action=get_cart_items")
      .then(res => res.json())
      .then(data => {
        let html = "";

        if (data.items.length > 0) {
          data.items.forEach(item => {
            html += `
              <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                <div>
                  <strong>${item.name}</strong><br>
                  <small>Qty: ${item.qty}</small>
                </div>
                <span>${item.subtotal}</span>
              </div>
            `;
          });

          html += `
            <div class="mt-3">
              <div class="d-flex justify-content-between mb-2">
                <strong>Total:</strong>
                <strong>${data.total}</strong>
              </div>
              <a href="/cart" class="btn btn-primary w-100 mb-2">View Cart</a>
              <a href="/checkout" class="btn btn-success w-100">Checkout</a>
            </div>
          `;
        } else {
          html = `<p>Your cart is empty.</p>`;
        }

        cartBody.innerHTML = html;
      });
  }

  // Load cart when offcanvas opens
  document.getElementById("offcanvasCart").addEventListener("show.bs.offcanvas", loadCart);
});
