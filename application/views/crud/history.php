<?php foreach ($groupedbyDate as $date => $historyData): ?>
    <h2>Date: <?php echo $date; ?></h2>
    <table>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Product</th>
                <th scope="col">Price</th>
            </tr>
        </thead>
        <tbody>
            <!-- Iterate through the data for this date -->
            <?php $totalPrice = 0; foreach ($historyData as $row): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['product']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                </tr>
            <?php
            $totalPrice += $row['price'];
        
        endforeach; ?>
        </tbody>
    </table>
    <h2>Total: <?php echo $totalPrice; ?></h2>
    <!-- assume vat = 20%; -->
    <h2>VAT: <?php echo $totalPrice * 0.2; ?></h2> 
    <h2>Grand Total: <?php echo $totalPrice + ($totalPrice * 0.2 ) ?>  </h2>
    
<?php endforeach; ?>
