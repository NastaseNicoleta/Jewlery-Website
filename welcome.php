<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}
include 'db.php';

// Query to select products with type and material
$sql = "SELECT id, name, description, price, image, type, material FROM products";
$result = $conn->query($sql);
$products = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bine ai venit</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="script.js"></script>
</head>
<body>
    <header>
        <img src="logo.png" alt="Logo Glamour Gems" style="width: 100px;">
        <h1>Bine ai venit, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <nav>
            <ul>
                <li><a href="cart.php"><img src="cart_icon.png" alt="Cos de cumparaturi" class="cart-icon" /></a></li>
                <li><a href="account.php">Contul meu</a></li>
                <li><a href="logout.php">Delogare</a></li>
            </ul>
        </nav>
    </header>
    <main>
    <section>
            <label for="productSearch">Caută produs:</label>
            <input type="text" id="productSearch" placeholder="Caută...">
            <select id="productSelect">
                <option value="">Selectează un produs</option>
                <?php foreach ($products as $product): ?>
                    <option value="<?php echo htmlspecialchars($product['id']); ?>"><?php echo htmlspecialchars($product['name']); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="button" id="searchButton">Caută</button>
        </section>
        <section>
            <h2>Produse</h2>
            <form id="filterForm">
                <label for="jewelryType">Tip bijuterie:</label>
                <select id="jewelryType">
                    <option value="">Selectează tipul</option>
                    <option value="inel">Inel</option>
                    <option value="colier">Colier</option>
                    <option value="cercei">Cercei</option>
                    <option value="bratara">Brățară</option>
                    <option value="brosa">Broșă</option>
                    <option value="pandantiv">Pandantiv</option>
                    <option value="set">Set</option>
                </select>
                <label for="jewelryMaterial">Material bijuterie:</label>
                <select id="jewelryMaterial">
                    <option value="">Selectează materialul</option>
                </select>
                <button type="button" id="filterButton">Caută</button>
            </form>
            <div id="productsContainer">
                <?php foreach ($products as $product): ?>
                    <div class="product" data-id="<?php echo htmlspecialchars($product['id']); ?>" data-type="<?php echo htmlspecialchars($product['type']); ?>" data-material="<?php echo htmlspecialchars($product['material']); ?>">
                        <img src="images/<?php echo htmlspecialchars($product['image']); ?>" style="width: 100px; height: auto;" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
                        <p><b><?php echo htmlspecialchars($product['name']); ?></b></p>
                        <p>Preț: <b><?php echo htmlspecialchars($product['price']); ?> RON</b></p>
                        <p class="short-description"><?php echo substr(htmlspecialchars($product['description']), 0, 100); ?>...</p>
                        <form action="add_to_cart.php" method="post">
                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit">Adaugă în coș</button>
                        </form>
                        <a href="product_details.php?id=<?php echo htmlspecialchars($product['id']); ?>" class="view-more-btn">View More</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <section>
            <h2>Îngrijirea bijuteriilor</h2>
            <table border="1">
                <tr>
                    <th colspan="2">Sfaturi pentru îngrijirea bijuteriilor</th>
                </tr>
                <tr>
                    <td rowspan="2">Curățare</td>
                    <td>Utilizați o soluție de curățare delicată și o periuță de dinți moale.</td>
                </tr>
                <tr>
                    <td>Evitați substanțele chimice dure care pot deteriora metalele prețioase și pietrele.</td>
                </tr>
                <tr>
                    <td>Depozitare</td>
                    <td>Păstrați bijuteriile în cutii sau pungi de catifea pentru a preveni zgârieturile.</td>
                </tr>
                <tr>
                    <td>Utilizare</td>
                    <td>Îndepărtați bijuteriile înainte de a face baie sau de a efectua activități fizice intense.</td>
                </tr>
            </table>
        </section>
        <section>
            <h2>Tipuri de bijuterii disponibile</h2>
            <ul>
                <li> <strong class="category-title">Bijuterii din aur</strong>
                    <ul>
                        <li class="hidden-item" style="display: none;">Coliere din aur</li>
                        <li class="hidden-item" style="display: none;">Brățări din aur</li>
                    </ul>
                </li>
                <li><strong class="category-title">Bijuterii din argint</strong>
                    <ul>
                        <li class="hidden-item" style="display: none;">Inel din argint</li>
                        <li class="hidden-item" style="display: none;">Cercei din argint</li>
                    </ul>
                </li>
                <li><strong class="category-title">Bijuterii cu pietre prețioase</strong>
                    <ul>
                        <li class="hidden-item" style="display: none;">Inel cu diamant</li>
                        <li class="hidden-item" style="display: none;">Brățară cu rubin</li>
                        <li class="hidden-item" style="display: none;">Pandantiv cu safir</li>
                        <li class="hidden-item" style="display: none;">Colier cu smarald</li>
                    </ul>
                </li>
            </ul>
            <button id="viewMoreBtn">View more</button>
        </section>
        <section>
            <p><b>La Glamour Gems, oferim bijuterii de cea mai înaltă calitate.</b></p>
            <p><u>Toate produsele noastre sunt garantate.</u></p>
        </section>
        <section>
            <input type="text" id="searchInput" placeholder="Caută produs...">
            <button type="button" id="searchTableButton">Caută</button>
            <table id="productsTable">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Nume</th>
                        <th onclick="sortTable(1)">Preț</th>
                        <th>Descriere</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)) : ?>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['price']); ?></td>
                            <td><?php echo htmlspecialchars($product['description']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
        <br><br><br>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const searchButton = document.getElementById('searchTableButton');
            const productsTable = document.getElementById('productsTable');

            searchButton.onclick = function () {
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
            };

            window.sortTable = function(n) {
                let table, rows, switching, i, x, y, shouldSwitch, dir = "asc", switchcount = 0;
                table = document.getElementById("productsTable");
                switching = true;
                while (switching) {
                    switching = false;
                    rows = table.rows;
                    for (i = 1; i < (rows.length - 1); i++) {
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
        });
        </script>
        <section>
            <table border="1">
                <tr>
                    <th>Aspectul Bijuteriilor</th>
                    <th>Detalii</th>
                </tr>
                <tr>
                    <td>Curățare și Protejare</td>
                    <td>
                        <table border="1">
                            <tr>
                                <td>Curățare bijuterii</td>
                                <td>Utilizați o soluție de curățare delicată.</td>
                            </tr>
                            <tr>
                                <td>Protejare bijuterii</td>
                                <td>Evitați contactul cu substanțe chimice dure.</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>Depozitare bijuterii</td>
                    <td>Folosirea cutiilor de bijuterii individuale pentru a preveni zgârieturi.</td>
                </tr>
            </table>
        </section>
        <hr><br><br>
    </main>
    <footer>
        <p>&copy; 2024 Glamour Gems. Toate drepturile rezervate.</p>
    </footer>
    <div id="productModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="modalImage">
        <div id="caption"></div>
    </div>
</body>
</html>
<?php
$conn->close();
?>
