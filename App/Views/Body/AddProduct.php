<form method="POST" id="formAdd">
    <!-- Render common fields -->
    <?php foreach ($formData['commonFields'] as $field => $data): ?>
        <label><?= $data['label'] ?>:</label>
        <input type="<?= $data['type'] ?>" name="<?= $field ?>" required><br>
    <?php endforeach; ?>

    <!-- Product type selection -->
    <label>Type:</label>
    <select name="type" id="productType" onchange="showAttributes()">
        <option value="" disabled selected>Select a product type</option>
        <?php foreach ($formData['types'] as $type => $typeData): ?>
            <option value="<?= $type ?>" required><?= $typeData['label'] ?></option>
        <?php endforeach; ?>
    </select><br>

    <!-- Placeholder for dynamic fields based on product type -->
    <div id="dynamicFields"></div>

    <!-- <input type="submit" value="Save"> -->
</form>

<script>
    // Get formData directly as JSON for dynamic rendering in JS
    const formData = <?= json_encode($formData['types']) ?>;

    function showAttributes() {
        const type = document.getElementById('productType').value;
        const fieldsDiv = document.getElementById('dynamicFields');
        fieldsDiv.innerHTML = ''; // Clear existing fields

        if (formData[type]) {
            const fields = formData[type]['fields'];
            for (let field in fields) {
                const label = document.createElement('label');
                label.innerText = fields[field];

                const input = document.createElement('input');
                input.type = 'number';
                input.name = field;
                input.required = true;
                
                fieldsDiv.appendChild(label);
                fieldsDiv.appendChild(input);
                fieldsDiv.appendChild(document.createElement('br'));
            }
        }
    }
</script>

<!-- Script for Save -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Select all buttons with the custom data-role attribute
        const submitButtons = document.querySelectorAll('[data-role="submit-form"]');
        const submitForm = document.getElementById('formAdd');
        const typeSelect = document.getElementById('productType');
        if (submitButtons && submitForm) {
            submitButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const form = document.getElementById('formAdd');  // Target form by ID

                    if (form) {
                        typeSelect.setCustomValidity("");
                        // Check if a type is selected
                        if (!typeSelect.value) {
                            // Set a custom error message that resembles native validation
                            typeSelect.setCustomValidity("Please select a product type.");
                        }

                        if (form.checkValidity()) {
                            form.requestSubmit(); // Submits if valid
                        } else {
                            form.reportValidity(); // Shows validation messages
                        }
                    } else {
                        console.warn("Target form not found.");
                    }
                });
            });
        }
    });
</script>