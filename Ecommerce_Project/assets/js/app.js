function toggleFields() {
    const productType = document.getElementById('productType').value;
    document.getElementById('DVDFields').style.display = (productType === 'DVD') ? 'block' : 'none';
    document.getElementById('BookFields').style.display = (productType === 'Book') ? 'block' : 'none';
    document.getElementById('FurnitureFields').style.display = (productType === 'Furniture') ? 'block' : 'none';
}

// document.getElementById('type').addEventListener('change', function() {
//     const type = this.value;
//     const dynamicFields = document.getElementById('dynamic-fields');
//     dynamicFields.innerHTML = ''; // Clear existing fields

//     if (type === 'Book') {
//         dynamicFields.innerHTML = `
//             <label for="weight">Weight (Kg):</label>
//             <input type="number" name="weight" id="weight" step="0.01">
//         `;
//     } else if (type === 'DVD') {
//         dynamicFields.innerHTML = `
//             <label for="size">Size (MB):</label>
//             <input type="number" name="size" id="size" step="0.01">
//         `;
//     } else if (type === 'Furniture') {
//         dynamicFields.innerHTML = `
//             <label for="dimensions">Dimensions (HxWxL):</label>
//             <input type="text" name="dimensions" id="dimensions">
//         `;
//     }
// });
