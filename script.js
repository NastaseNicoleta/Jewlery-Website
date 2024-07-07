document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.getElementById('searchForm');
    const productSearch = document.getElementById('productSearch');
    const jewelryType = document.getElementById('jewelryType');
    const jewelryMaterial = document.getElementById('jewelryMaterial');
    const productsTable = document.getElementById('productsTable');
    const searchInput = document.getElementById('searchInput');

    const materialsByType = {
        "inel": ["argint", "safir", "platina", "claddagh"],
        "colier": ["aur", "opal"],
        "cercei": ["dama", "argint", "chandelier"],
        "bratara": ["charm", "diamant"],
        "brosa": ["artnouveau"],
        "pandantiv": ["aur"],
        "set": ["perle"]
    };
    const emailInput = document.getElementById('email');
    const emailError = document.createElement('span');
    emailError.style.color = 'red';
    if (emailInput) {
        emailInput.parentNode.insertBefore(emailError, emailInput.nextSibling);

        emailInput.addEventListener('input', function () {
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(emailInput.value)) {
                emailError.textContent = 'Email invalid';
            } else {
                emailError.textContent = '';
            }
        });
    }

    // Validare parolă
    const passwordInput = document.getElementById('password');
    const passwordError = document.createElement('span');
    passwordError.style.color = 'red';
    if (passwordInput) {
        passwordInput.parentNode.insertBefore(passwordError, passwordInput.nextSibling);

        passwordInput.addEventListener('input', function () {
            if (passwordInput.value.length < 6) {
                passwordError.textContent = 'Parola trebuie să aibă cel puțin 6 caractere';
            } else {
                passwordError.textContent = '';
            }
        });
    }

    // Dropdown dinamic pentru tip și material bijuterie
    const jewelryTypeSelect = document.getElementById('jewelryType');
    const jewelryMaterialSelect = document.getElementById('jewelryMaterial');
    const materials = {
        "inel": ["argint", "safir", "platină", "claddagh"],
        "colier": ["aur", "opal"],
        "cercei": ["dama", "argint", "chandelier"],
        "bratara": ["charm", "diamant"],
        "brosa": ["artnouveau"],
        "pandantiv": ["aur"],
        "set": ["perle"]
    };

    if (jewelryTypeSelect && jewelryMaterialSelect) {
        jewelryTypeSelect.addEventListener('change', function () {
            const selectedType = jewelryTypeSelect.value;
            jewelryMaterialSelect.innerHTML = '<option value="">Selectează materialul</option>';
            if (materials[selectedType]) {
                materials[selectedType].forEach(function (material) {
                    const option = document.createElement('option');
                    option.value = material;
                    option.textContent = material.charAt(0).toUpperCase() + material.slice(1); // Prima literă mare
                    jewelryMaterialSelect.appendChild(option);
                });
            }
        });
    }

    // Buton "View more" pentru lista de tipuri de bijuterii
    const viewMoreBtn = document.getElementById('viewMoreBtn');
    const hiddenItems = document.querySelectorAll('.hidden-item');
    
    if (viewMoreBtn) {
        viewMoreBtn.addEventListener('click', function () {
            hiddenItems.forEach(function (item) {
                item.style.display = 'list-item';
            });
            viewMoreBtn.style.display = 'none';
        });
    }

    // Funcție pentru filtrarea produselor
    const filterButton = document.getElementById('filterButton');
    const productsContainer = document.getElementById('productsContainer');
    if (filterButton && productsContainer) {
        filterButton.addEventListener('click', function () {
            const selectedType = jewelryTypeSelect.value;
            const selectedMaterial = jewelryMaterialSelect.value.toLowerCase(); // Asigură-te că materialul selectat este în litere mici
            const products = productsContainer.querySelectorAll('.product');

            let noResults = true;

            products.forEach(function (product) {
                const productType = product.getAttribute('data-type').toLowerCase();
                const productMaterial = product.getAttribute('data-material').toLowerCase();
                if ((selectedType === "" || productType === selectedType) &&
                    (selectedMaterial === "" || productMaterial === selectedMaterial)) {
                    product.style.display = 'block';
                    noResults = false;
                } else {
                    product.style.display = 'none';
                }
            });

            if (noResults) {
                productsContainer.innerHTML = '<p>Nicio bijuterie găsită.</p>';
            }
        });
    }

    // Căutare și filtrare după input text și dropdown
    const productSearchInput = document.getElementById('productSearch');
    const productSelect = document.getElementById('productSelect');
    const searchButton = document.getElementById('searchButton');

    if (productSearchInput && productSelect && searchButton) {
        productSearchInput.addEventListener('input', function () {
            const searchValue = productSearchInput.value.toLowerCase();
            for (let i = 0; i < productSelect.options.length; i++) {
                const option = productSelect.options[i];
                if (option.text.toLowerCase().includes(searchValue)) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            }
        });

        searchButton.addEventListener('click', function () {
            const selectedProductId = productSelect.value;
            if (selectedProductId) {
                const selectedProduct = document.querySelector(`.product[data-id="${selectedProductId}"]`);
                if (selectedProduct) {
                    productsContainer.innerHTML = '';
                    productsContainer.appendChild(selectedProduct);
                } else {
                    productsContainer.innerHTML = '<p>Produsul nu a fost găsit.</p>';
                }
            }
        });
    }


    jewelryType.addEventListener('change', function() {
        const selectedType = this.value;
        const materials = materialsByType[selectedType] || [];
        jewelryMaterial.innerHTML = '<option value="">Selectează materialul</option>';
        materials.forEach(material => {
            const option = document.createElement('option');
            option.value = material;
            option.textContent = material.charAt(0).toUpperCase() + material.slice(1);
            jewelryMaterial.appendChild(option);
        });
    });

    filterButton.addEventListener('click', function() {
        const selectedType = jewelryType.value.toLowerCase();
        const selectedMaterial = jewelryMaterial.value.toLowerCase();
        const productDivs = document.querySelectorAll('.product');
        productDivs.forEach(div => {
            const type = div.dataset.type.toLowerCase();
            const material = div.dataset.material.toLowerCase();
            if ((selectedType === "" || type === selectedType) && (selectedMaterial === "" || material === selectedMaterial)) {
                div.style.display = '';
            } else {
                div.style.display = 'none';
            }
        });
    });

    productSearch.addEventListener('input', function() {
        const searchText = productSearch.value.toLowerCase();
        Array.from(productSelect.options).forEach(option => {
            const text = option.text.toLowerCase();
            option.style.display = text.includes(searchText) ? 'block' : 'none';
        });
    });

    searchForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const query = productSearch.value;
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (selectedOption.value) {
            fetch(`search.php?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(products => {
                    productsContainer.innerHTML = '';
                    if (products.length > 0) {
                        products.forEach(product => {
                            const productDiv = document.createElement('div');
                            productDiv.innerHTML = `
                                <img src="images/${product.image}" style="width: 100px; height: auto;" alt="${product.name}">
                                <p><b>${product.name}</b></p>
                                <p>Preț: <b>${product.price} RON</b></p>
                                <p>${product.description}</p>
                            `;
                            productsContainer.appendChild(productDiv);
                        });
                    } else {
                        productsContainer.innerHTML = '<p>Nu s-au găsit produse.</p>';
                    }
                })
                .catch(error => console.error('Error loading the products:', error));
        }
    });

    // Pop-up modal for images
    const modal = document.getElementById('productModal');
    const modalImg = document.getElementById('modalImage');
    const captionText = document.getElementById('caption');
    const closeModal = document.querySelector('.close');
    document.querySelectorAll('.product-image').forEach(img => {
        img.addEventListener('click', function () {
            modal.style.display = 'block';
            modalImg.src = this.src;
            captionText.textContent = this.alt;
        });
    });

    closeModal.addEventListener('click', () => modal.style.display = 'none');
    window.addEventListener('click', event => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    viewMoreBtn.addEventListener('click', function() {
        hiddenItems.forEach(item => {
            item.style.display = 'list-item';
        });
        viewMoreBtn.style.display = 'none';
    });

    searchInput.addEventListener('keyup', function () {
        let filter = searchInput.value.toUpperCase();
        let tr = productsTable.getElementsByTagName("tr");
        for (let i = 1; i < tr.length; i++) {
            let tdArray = tr[i].getElementsByTagName("td");
            let found = false;
            for (let j = 0; j < tdArray.length; j++) {
                let td = tdArray[j];
                if (td) {
                    let txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
            }
            tr[i].style.display = found ? "" : "none";
        }
    });

    function sortTable(n) {
        let switching, shouldSwitch, x, y;
        let dir = "asc";
        let switchcount = 0;
        switching = true;
        while (switching) {
            switching = false;
            let rows = productsTable.rows;
            for (let i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                if (dir == "asc" && x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase() ||
                    dir == "desc" && x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else if (switchcount === 0 && dir === "asc") {
                dir = "desc";
                switching = true;
            }
        }
    };

    document.querySelectorAll('th').forEach((header, index) => {
        if (index === 0 || index === 1) {
            header.onclick = function() {
                sortTable(index);
            };
        }
    });
});
