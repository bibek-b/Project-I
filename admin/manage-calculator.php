<?php
// Dummy data to simulate existing prices and round-off values
$prices = [
    '5mm' => ['black' => 110, 'blue' => 115, 'clear' => 120, 'green' => 125],
    '6mm' => ['black' => 140, 'blue' => 145, 'clear' => 150, 'green' => 155],
    '8mm' => ['black' => 190, 'blue' => 195, 'clear' => 200, 'green' => 205],
    '10mm' => ['black' => 250, 'blue' => 255, 'clear' => 260, 'green' => 265],
    '12mm' => ['black' => 300, 'blue' => 305, 'clear' => 310, 'green' => 315]
];

// Initial round-off values as associative arrays
$roundOffValues = [
    ['lower' => 6, 'upper' => 9, 'rounded' => 9],
    ['lower' => 9, 'upper' => 12, 'rounded' => 12],
    ['lower' => 12, 'upper' => 18, 'rounded' => 18],
    ['lower' => 18, 'upper' => 24, 'rounded' => 24],
    ['lower' => 24, 'upper' => 30, 'rounded' => 30],
    ['lower' => 30, 'upper' => 36, 'rounded' => 36],
    ['lower' => 36, 'upper' => 42, 'rounded' => 42],
    ['lower' => 42, 'upper' => 48, 'rounded' => 48],
    ['lower' => 48, 'upper' => 60, 'rounded' => 60],
    ['lower' => 60, 'upper' => 72, 'rounded' => 72],
    ['lower' => 72, 'upper' => 84, 'rounded' => 84],
    ['lower' => 84, 'upper' => 96, 'rounded' => 96],
    ['lower' => 96, 'upper' => 108, 'rounded' => 108],
    ['lower' => 108, 'upper' => 120, 'rounded' => 120],
];

// Update the data if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve submitted data for prices and colors
    if (isset($_POST['price_update'])) {
        $thickness = $_POST['thickness'];
        $color = $_POST['color'];
        $newPrice = $_POST['price'];

        // Update prices array (This should be done in a database in a real application)
        if (isset($prices[$thickness][$color])) {
            $prices[$thickness][$color] = (float)$newPrice;
        }
    }

    // Retrieve submitted data for round-off values
    if (isset($_POST['round_off_update'])) {
        foreach ($_POST['round_off'] as $key => $value) {
            $roundOffValues[$key]['lower'] = (int)$value['lower'];     // Update lower value
            $roundOffValues[$key]['upper'] = (int)$value['upper'];     // Update upper value
            $roundOffValues[$key]['rounded'] = (int)$value['rounded'];  // Update rounded value
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/admin-style.css">
    <link rel="stylesheet" href="assets/css/calculate.css">
    <title>Manage Calculator</title>
</head>
<body>
    <div id="calc-container">
        <?php include 'includes/navbar.php'; ?>

        <div class="content-container">
            <h1>Manage Calculator</h1>

            <!-- Form to update prices -->
            <div class="price-update">
                <h2>Update Prices:</h2>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="thickness">Select Thickness:</label>
                        <select name="thickness" id="thickness" required>
                            <?php foreach (array_keys($prices) as $thickness): ?>
                                <option value="<?= $thickness; ?>"><?= $thickness; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="color">Select Color:</label>
                        <select name="color" id="color" required>
                            <option value="black">Black</option>
                            <option value="blue">Blue</option>
                            <option value="clear">Clear</option>
                            <option value="green">Green</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price">Update Price:</label>
                        <input type="number" step="0.01" name="price" id="price" required>
                    </div>

                    <button type="submit" name="price_update">Update Price</button>
                </form>

                <h2>Current Prices:</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Thickness</th>
                            <th>Color</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($prices as $thickness => $colors): ?>
                            <?php foreach ($colors as $color => $price): ?>
                                <tr>
                                    <td><?= $thickness; ?></td>
                                    <td><?= ucfirst($color); ?></td>
                                    <td>NRS <?= $price; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
<br><br><hr>
            <!-- Form to update round-off values -->
            
            <div class="round-off-update">
            <h2>Update Round-off Values:</h2>
                <form method="POST" action="">
                    <table>
                        <thead>
                            <tr>
                                <th>Lower Value</th>
                                <th>Upper Value</th>
                                <th>Rounded Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($roundOffValues as $key => $value): ?>
                                <tr>
                                    <td>
                                        <input type="number" name="round_off[<?= $key; ?>][lower]" value="<?= $value['lower']; ?>" required>
                                    </td>
                                    <td>
                                        <input type="number" name="round_off[<?= $key; ?>][upper]" value="<?= $value['upper']; ?>" required>
                                    </td>
                                    <td>
                                        <input type="number" name="round_off[<?= $key; ?>][rounded]" value="<?= $value['rounded']; ?>" required>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="submit" name="round_off_update">Update Round-off Values</button>
                </form>

                <h2>Current Round-off Values:</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Lower Value</th>
                            <th>Upper Value</th>
                            <th>Rounded Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($roundOffValues as $value): ?>
                            <tr>
                                <td><?= $value['lower']; ?></td>
                                <td><?= $value['upper']; ?></td>
                                <td><?= $value['rounded']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
        <script src="assets/js/calculate.js"></script>
    </div>
</body>
</html>
