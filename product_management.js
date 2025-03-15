
function confirmDelete() {
    return confirm("Are you sure you want to delete this product?");
}

function validateForm() {
    const productName = document.querySelector('input[name="product_name"]');
    const productPrice = document.querySelector('input[name="product_price"]');
    const productQuantity = document.querySelector('input[name="product_quantity"]');
    
    if (productName.value.trim() === "") {
        alert("Product name is required.");
        productName.focus();
        return false;
    }
    
    if (productPrice.value <= 0) {
        alert("Product price must be greater than zero.");
        productPrice.focus();
        return false;
    }
    
    if (productQuantity.value < 0) {
        alert("Product quantity cannot be negative.");
        productQuantity.focus();
        return false;
    }
    
    return true;
}

// Attach the validateForm function to the form's submit event
document.querySelector('.form-inline').addEventListener('submit', function(event) {
    if (!validateForm()) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
});
