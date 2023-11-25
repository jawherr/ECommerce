<?php
            require_once 'core/init.php';
            include 'includes/head.php';
            include 'includes/navigation.php';
            include 'includes/headerpartial.php';
            include 'includes/leftbar.php';

            if (isset($_GET['cat'])){
                $cat_id = sanitize($_GET['cat']);
            }else{
                $cat_id = '';
            }

            $sql = "SELECT * FROM products WHERE categories = '$cat_id'";
            $productQ = $db->query($sql);
            $categorie = get_categorie($cat_id);
?>
      

            <!-- main content -->
        <div class="col-md-8">Main
            <div class="row">
                <h2 class="text-center"><?=$categorie['parent'].' '.$categorie['child'];?></h2>
                <?php while($product = mysqli_fetch_assoc($productQ)) : ?>
                     <div class="col-sm-3 text-center">
                        <h4><?= $product['title']; ?></h4>
                        <?php $photos = explode(',',$product['image']);?>
                        <img src="<?= $photos[0]; ?>" alt="<?= $product['title']; ?>" 
                        class="img-thumb" />
                        <p class="list price text-danger">List Price: <s>$<?= $product['list_price'];?></s></p>
                        <p class="price">Our Price: $<?= $product['price']; ?></p>
                        <button type="button" class="btn btn-sm btn-success" 
                        onclick="detailsmodal(<?= $product['id']; ?>)">Details</button>
                     </div>
                <?php endwhile; ?>
            </div>
        </div>
           <?php
            include 'includes/rigthbar.php';
            include 'includes/footer.php';
           ?>