<form id="delete-form" method="post" style="display:none;">
    <input type="hidden" name="items" id="items-to-delete" value="">
</form>
<div class="container">
<div class="product-grid">
    <ul>
    <?php foreach ($products as $product): ?>
    <div class="product-box" onclick="toggleCheckbox(this)">
    <input type="checkbox" class="delete-checkbox" value="<?php echo htmlspecialchars($product['sku']); ?>">
    <p><?php echo htmlspecialchars($product['sku']); ?></p>
    <p><?php echo htmlspecialchars($product['name']); ?></p>
    <p><?php echo htmlspecialchars($product['price'] . " $"); ?></p>
    <p><?php echo htmlspecialchars($product['type']); ?></p>
    <p><?php echo htmlspecialchars($product['attribute']); ?></p>
    </div>
    <?php endforeach; ?>
    </ul>
    </div>
</div>

<!-- Script for deletion -->
<script>
    const deleteBtn = document.getElementById('delete-product-btn');
    if (deleteBtn) {
        deleteBtn.addEventListener('click', function (event) {
            event.preventDefault();
            const checkboxes = document.querySelectorAll('.delete-checkbox');
            const selectedItems = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);
            if (selectedItems.length > 0) {
                const deleteForm = document.getElementById('delete-form');
                // Clear existing hidden inputs
                deleteForm.innerHTML = '';
                console.log(selectedItems);
                // Create hidden inputs for each selected item
                selectedItems.forEach(item => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'items[]'; // Name it as an array
                    input.value = item;
                    deleteForm.appendChild(input);
                });
                deleteForm.submit();
            } else {
            }
        }
        )
    };
</script>

<!-- Notes: -->
 <!-- action="/App/Controllers/DeleteController.php" was used in post before deletion of delete MVC -->