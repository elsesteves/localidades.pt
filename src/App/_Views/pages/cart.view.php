<div id="breadcrumbs_area">
	<a href="/inicio">Início</a> &gt; Carrinho
</div>

<div id="cart_wrap">

	<div id="cart_subwrap">
		<?php require __DIR__ .'/includes/cart/products.view.php'; ?>
		<?php require __DIR__ .'/includes/cart/promocode.view.php'; ?>
	</div><div id="logsignWrap"><div id="shiptax_wrap">
		<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
		<?php 
			require __DIR__ .'/includes/cart/shipping.view.php';
			require __DIR__ .'/includes/cart/invoicing.view.php';
		?>
		<div id="final-wrap">
			<button type="submit" name="submit" id="finalizar">CONTINUAR</button>
		</div>
	</form>

	</div></div>
</div>