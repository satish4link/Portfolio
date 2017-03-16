        <div style="text-align: center;">
        <h1 style="padding-bottom: 100px;">Add Product</h1>
        <?php
            require_once 'class.admin.php';
            $admin=new ADMIN;
		?>
        <form method="post" enctype="multipart/form-data" action="pdf.php"> 
            <select name="category_id" id="cat_id" >
						<option value="">---Select Category---</option>
						<?php
							$sql1 = "SELECT * FROM category";
							$result1 = $admin->runQuery($sql1);
							$result1->execute();
							while ($row = $result1->fetch(PDO::FETCH_ASSOC)) {
								if ($cat_id == $row['cat_id']) {
    								echo "<option value='" . $row['cat_id'] . "' selected>" . $row['cat_name'] . "</option>";
    							} else {
    								echo "<option value='" . $row['cat_id'] . "'>" . $row['cat_name'] . "</option>";
    							}
							}
						?>
			</select><br /><br/>
            <input type="text" name="prod_name" placeholder="Product Name" /><br /><br/>
            <textarea placeholder="Product description" name="prod_desc" rows="5"></textarea><br /><br />
            <input type="text" name="prod_rate" placeholder="Product Rate" /><br /><br />
            <input type="submit" name="insert" value="INSERT" />
        </form>
        </div>
