document.getElementById('delete-product-btn').addEventListener('click', function() {
    // Get all checked checkboxes
    const checkedCheckboxes = document.querySelectorAll('.delete-checkbox:checked');

    // Check if any checkboxes are selected
    if (checkedCheckboxes.length === 0) {
        console.log('No products selected for deletion.');
        return;
    }

    // Collect IDs of selected products
    const idsToDelete = Array.from(checkedCheckboxes).map(cb => cb.value);
    console.log(idsToDelete);

    // Send AJAX request to delete products
    fetch('/controllers/delete_products.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ ids: idsToDelete })
    })
    .then(response => response.text()) // Get the raw response text
    .then(rawText => {
        try {
            const data = JSON.parse(rawText); // Parse the response text as JSON
            if (data.success) {
                // Remove deleted product cards from the DOM
                checkedCheckboxes.forEach(cb => cb.closest('.product-item').remove());
                console.log('Products deleted successfully.');
            } else {
                console.log('Failed to delete products: ' + (data.message || 'Unknown error'));
            }
        } catch (e) {
            console.error('Error parsing JSON response:', rawText); // Log raw response
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
