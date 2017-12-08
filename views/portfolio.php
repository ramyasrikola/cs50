<div style="text-align:left">
  <table class="table table-striped" >
       <thead>
         <tr>
            <th>Symbol</th>
            <th>Name</th>
            <th>Shares</th>
            <th>Price</th>
            <th>TOTAL</th>
         </tr>
         </thead>
         <tbody>
            <?php foreach ($positions as $position): ?>
              <tr >
                  <td style="text-transform:uppercase"><?= $position["symbol"] ?></td>
                  <td><?= $position["name"] ?></td>
                  <td><?= $position["shares"] ?></td>
                  <td>$<?= $position["price"] ?></td>
                  <td>$<?= $position["total"] ?></td>
              </tr>
              
           <?php endforeach ?>
           <tr>
               <td colspan="4">CASH</td>
               <td>$<?= $amount ?></td>
           </tr>
     </tbody>
 </table>
</div>