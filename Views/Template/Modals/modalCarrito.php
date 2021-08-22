
<?php
    $total= 0;
    if (isset($_SESSION['arrCarrito']) and count($_SESSION['arrCarrito'])>0) {
?>
<ul class="header-cart-wrapitem w-full">
<?php
    foreach ($_SESSION['arrCarrito'] as $producto){
    $total += $producto['cantidad'] * $producto['precio'];
    $idProducto = openssl_encrypt($producto['idproducto'],METHODENCRYPT, KEY);//encripto el id del producto
?>
    <li class="header-cart-item flex-w flex-t m-b-12">
        <div class="header-cart-item-img" idpr="<?= $idProducto ?>" op="1">
            <img src="<?= $producto['imagen']; ?>" alt="<?= $producto['imagen']; ?>">
        </div>

        <div class="header-cart-item-txt p-t-8">
            <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                White Shirt Pleat
            </a>

            <span class="header-cart-item-info">
                1 x $19.00
            </span>
        </div>
    </li>
<?php
}
?>
</ul>

<div class="w-full">
    <div class="header-cart-total w-full p-tb-40">
        Total: $75.00
    </div>

    <div class="header-cart-buttons flex-w w-full">
        <a href="shoping-cart.html" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
            Ver carrito
        </a>

        <a href="shoping-cart.html" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
            Procesar pago
        </a>
    </div>
</div>
<?php
    }
?>