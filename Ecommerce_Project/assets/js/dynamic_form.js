class Product {
    constructor(data) {
        this.sku = data.sku;
        this.name = data.name;
        this.price = parseFloat(data.price);
        this.type = data.type;
        this.attributes = data.attributes || {};
    }

    validate() {
        return this.sku && this.name && this.price >= 0 && this.validateAttributes();
    }

    validateAttributes() {
        return true; // Override in subclasses
    }
}

class DVD extends Product {
    validateAttributes() {
        return this.attributes.size > 0;
    }
}

class Book extends Product {
    validateAttributes() {
        return this.attributes.weight > 0;
    }
}

class Furniture extends Product {
    validateAttributes() {
        return (
            this.attributes.height > 0 &&
            this.attributes.width > 0 &&
            this.attributes.length > 0
        );
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const saveButton = document.getElementById('save');
    const productTypeElement = document.getElementById('productType');
    const attributeContainers = {
        'DVD': document.getElementById('dvdAttributes'),
        'Book': document.getElementById('bookAttributes'),
        'Furniture': document.getElementById('furnitureAttributes'),
    };
    const notification = document.getElementById('notification');

    productTypeElement.addEventListener('change', () => {
        Object.values(attributeContainers).forEach(container => container.style.display = 'none');
        const selectedType = productTypeElement.value;
        if (attributeContainers[selectedType]) {
            attributeContainers[selectedType].style.display = 'block';
        }
    });

    saveButton.addEventListener('click', (event) => {
        event.preventDefault();

        const productData = {
            sku: document.getElementById('sku').value,
            name: document.getElementById('name').value,
            price: document.getElementById('price').value,
            type: productTypeElement.value,
            attributes: {}
        };

        // Collect attributes using a mapping object
        const productTypeClasses = {
            'DVD': DVD,
            'Book': Book,
            'Furniture': Furniture,
        };

        const ProductClass = productTypeClasses[productData.type];

        if (ProductClass) {
            // Capture attributes based on the product type
            const attributes = {
                DVD: { size: document.getElementById('size').value },
                Book: { weight: document.getElementById('weight').value },
                Furniture: {
                    height: document.getElementById('height').value,
                    width: document.getElementById('width').value,
                    length: document.getElementById('length').value,
                }
            };

            // Set the attributes dynamically
            productData.attributes = attributes[productData.type];

            const product = new ProductClass(productData);

            // Validation
            if (!product.validate()) {
                notification.textContent = "Please, submit required data";
                notification.style.display = "block";
                return;
            }

            notification.style.display = "none"; // Clear notification for valid input

            // Send the collected data to the PHP backend
            fetch('/save_product', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(productData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '../index.php'; // Redirect to homepage on success
                } else {
                    notification.textContent = data.message; // Show error message
                    notification.style.display = "block"; // Display notification
                }
            })
            .catch(error => {
                console.error('Error during save operation:', error);
            });
        }
    });
});
