<?php
$products = [
    ['name' => 'cây 1', 'price' => '100.000 VNĐ', 'image' => 'https://via.placeholder.com/150'],
    ['name' => 'cây 2', 'price' => '200.000 VNĐ', 'image' => 'https://via.placeholder.com/150'],
    ['name' => 'cây 3', 'price' => '300.000 VNĐ', 'image' => 'https://via.placeholder.com/150'],
    ['name' => 'cây 4', 'price' => '400.000 VNĐ', 'image' => 'https://via.placeholder.com/150'],
    ['name' => 'cây 5', 'price' => '500.000 VNĐ', 'image' => 'https://via.placeholder.com/150'],
    ['name' => 'cây 6', 'price' => '600.000 VNĐ', 'image' => 'https://via.placeholder.com/150'],
    ['name' => 'cây 7', 'price' => '600.000 VNĐ', 'image' => 'https://via.placeholder.com/150'],
    ['name' => 'cây 9', 'price' => '600.000 VNĐ', 'image' => 'https://via.placeholder.com/150'],
];
?>
<div class="row ">
    <?php foreach ($products as $product): ?>
        <div class="col-md-3 mb-4">
            <div class="card">
                <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $product['name']; ?></h5>
                    <p class="card-text">Giá: <?php echo $product['price']; ?></p>
                    <a href="#" class="btn btn-primary">Mua ngay</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>