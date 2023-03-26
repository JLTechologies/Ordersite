
                    <?php
                    
        include ('../required.php');
					 $orders = "SELECT * FROM orders INNER JOIN tables on orders.tableid = tables.tableid";					 
					 $getorders = mysqli_query($conn, $orders);
					  
					 if(! $getorders) {
						 die('Could not fetch data: '.mysqli_error($conn));
					 }
					 
					 while($row = mysqli_fetch_assoc($getorders)) {
						 ?>
					  <tr class="align-middle">
					  	<td class="text-center"><?php echo htmlspecialchars($row['idorders']);?></td>
                        <td class="text-center"><?php echo htmlspecialchars($row['description']);?></td>
                        <td class="text-center"><?php echo htmlspecialchars($row['betaling']);?></td>						
						<td class="text-center"><?php echo ($row['description2']);?></td>
						<td class="text-center"><?php echo htmlspecialchars($row['totaal']);?></td>
						
                        <td>
							<form name="id" action="remove.php" method="get">
								<input type="hidden" name="id" value="<?php echo htmlspecialchars($row['idorders']);?>"/>
								<input type="submit" value="complete order"/>
							</form>
						</td>
					  </tr>
					 <?php };?>