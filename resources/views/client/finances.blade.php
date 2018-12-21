<table id = "finacesTable" class="table mdl-data-table  table-hover">
    <thead>
        <tr>
            
            <th>Expense Type</th>
            <th>Total Amount</th>
            
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Expense on subscriptions</td>
            <td>$<?= $totalExpenseSubscription?></td>
        </tr>
        <tr>
            <td>Expenses on Scan packs</td>
            <td>$<?= $totalExpenseScanPacks ?></td>
        </tr>
        
        <tr>
            <td>Revenue Earned from Paid Projects</td>
            <td>$<?= $totalEarned ?></td>
        </tr>
        <tr>
            <td><h4>Net</h4></td>
            <td><?php
            $totalExpense = $totalEarned - ($totalExpenseSubscription + $totalExpenseScanPacks);
            
            if($totalExpense < 0){
                $class = "color:red";
            }else{
                $class = "color:green";
            }
            
            ?>
                <h5 style = "<?= $class ?>"><?= $totalExpense;?></h5>
            </td>
        </tr>
    </tbody>
</table>

