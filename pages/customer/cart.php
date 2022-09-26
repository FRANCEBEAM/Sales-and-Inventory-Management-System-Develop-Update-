<?php
session_start();
require '../customer/config/connection.php';
$email = $_SESSION['email'];

$sql = "SELECT * FROM users WHERE email = '$email'";
$run_Sql = mysqli_query($conn, $sql);
$fetch_info = mysqli_fetch_assoc($run_Sql);

if (!isset($_SESSION['email'])) {
    header("Location: signin.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://code.iconify.design/iconify-icon/1.0.0/iconify-icon.min.js"></script>
  <link rel="stylesheet" href="/assets/css/cart.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="/assets/css/menubar.css">
</head>
<nav class="navbar navbar-expand-lg navbar-light fixed-top mask-custom shadow-0">
  <div class="container-fluid">
  <a class="navbar-brand" href="./home.php">
      <img src="/assets/img/avancenalogo.svg" alt="" width="80%">
    </a>
    <button
      class="navbar-toggler"
      type="button"
      data-mdb-toggle="collapse"
      data-mdb-target="#navbarNavAltMarkup"
      aria-controls="navbarNavAltMarkup"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav me-auto">
        <a class="nav-link" aria-current="page" href="/pages/customer/home.php">Home</a>
        <a class="nav-link" href="/pages/customer/shop.php">Shop</a>
        <a class="nav-link" href="/pages/customer/about.php">About</a>

      </div>

<!-- Right elements -->
<div class="d-flex align-items-center">
  <!-- Icon -->
  <a class="text-reset me-3" href="./cart.php">
    <i class="fas fa-shopping-cart"></i>
    <span class="badge rounded-pill badge-notification bg-danger" id="cart-item"></span>
  </a>

  <!-- Notifications -->
  <div class="dropdown">
    <a
      class="text-reset me-3 dropdown-toggle hidden-arrow"
      href="#"
      id="navbarDropdownMenuLink"
      role="button"
      data-mdb-toggle="dropdown"
      aria-expanded="false"
    >
      <i class="fas fa-bell"></i>
      <span class="badge rounded-pill badge-notification bg-danger">1</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
    <li>
      <a class="dropdown-item" href="#">Confirm your order</a>
    </li>
    <li>
      <a class="dropdown-item" href="#">New Product Available</a>
    </li>
    <li>
      <a class="dropdown-item" href="#">Your order will deliver now</a>
    </li>
    </ul>
  </div>
  <!-- Avatar -->
  <div class="dropdown">
    <a
      class="dropdown-toggle d-flex align-items-center hidden-arrow"
      href="#"
      id="navbarDropdownMenuAvatar"
      role="button"
      data-mdb-toggle="dropdown"
      aria-expanded="false"
    >
      <img
        src="/assets/img/profile.jpg"
        class="rounded-circle"
        height="25"
        alt="Black and White Portrait of a Man"
        loading="lazy"
      />
    </a>
    <ul
      class="dropdown-menu dropdown-menu-end"
      aria-labelledby="navbarDropdownMenuAvatar"
    >
      <li>
        <a class="dropdown-item" href="./profile.php">My profile</a>
      </li>
      <li>
        <a class="dropdown-item" href="./settings.php">Settings</a>
      </li>
      <li>
        <a class="dropdown-item" href="./logout.php">Logout</a>
      </li>
    </ul>
  </div>
</div>
<!-- Right elements -->
    </div>
  </div>
</nav>

<body style="background-color: #E1E1EA">
<!-- CART LIST CONTENT -->
<div class="cartList-container mt-5" id="cartcart">
  <h4 class="fw-bold mt-5 mb-5">My cart</h4>

    <?php
        require 'config/connection.php';
        $grand_total = 0;
        $stmt = $conn->prepare("SELECT * FROM `cart` WHERE email = '$email'");
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()):
        $grand_total = $grand_total+($row['qty']*$row['price']);

    ?>
  <div class="card mb-2">
    <div class="img-container">
          <img src="/assets/img/product 1.png" alt="">
    </div>
    <div class="card-body">
      <h5 class="card-title"><?= $row['product'] ?></h5>
      <p class="card-text"><i class="fa-solid fa-peso-sign"></i>&nbsp;&nbsp;<?= number_format($row['price'],2); ?></p>

    
  <div class="qty-container">
    <form id="frm<?php echo $row['id'] ?>">
      <input type="hidden" name="cart_id" value="<?php  echo $row['id'];?>">

      <!-- Quantity Container -->
      <div class="qty-container">
        <div class="btn btn-outline-dark value-button changeQuantity" id="decrease" onclick="decreaseValue()" value="Decrease Value"><i class="fa-sharp fa-solid fa-minus"></i></div>
     
        <input type="number" class="form-control itemQty" name="qty" id="itemQty" value="<?php echo $row['qty']; ?>" onchange="updcart(<?php echo $row['id'];  ?>)" onkeyup="updcart(<?php echo $row['id'];  ?>)">

        <div class="btn btn-dark value-button changeQuantity" id="increase" onclick="increaseValue()" value="Increase Value"><i class="fa-sharp fa-solid fa-plus"></i></div>
      </div>

        
  </form>
  </div>

      <div class="card-foot">
        <h5 class="card-title total"><b>Total:&nbsp;&nbsp;</b><?= number_format($row['price']*$row['qty']); ?></h5>
        <a href="./config/action.php?remove=<?= $row['id'] ?>" class="text-danger btnRemove" onclick="deletedata(<?php echo $row['id'];?>)"><i class="bi bi-trash3-fill text-danger removeBtn"></i></a>
      </div>
    </div>
  </div>
  <?php endwhile; ?>
  <div class="total-container">
    <h5 class="sub-total"><b>Subtotal:&nbsp;&nbsp;</b><i class="fa-solid fa-peso-sign"></i><?= number_format($grand_total,2); ?></h5>
    <a href="./checkout.php" class="btn btn-success mt-4 mb-5 <?= ($grand_total > 1) ? '' : 'disabled'; ?>" data-bs-toggle="modal" data-bs-target="#modalOrder"><b>CHECKOUT</b>&nbsp;&nbsp;<svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M12.8377 8.01561H1.63281C1.38689 8.01561 1.1875 8.215 1.1875 8.46092V10.539C1.1875 10.785 1.38689 10.9844 1.63281 10.9844H12.8377V12.6936C12.8377 13.4871 13.797 13.8844 14.3581 13.3234L17.5517 10.1298C17.8995 9.78194 17.8995 9.21803 17.5517 8.87024L14.3581 5.67664C13.797 5.11558 12.8377 5.51295 12.8377 6.30642V8.01561V8.01561Z" fill="white"/>
      </svg>
    </a>

<!-- Modal -->
<div class="modal fade" id="modalOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

<?php
	require 'config/connection.php';

	$grand_total = 0;
	$allItems = '';
	$items = [];

	$sql = "SELECT CONCAT(product, '(',qty,')') AS ItemQty, total_price,qty,price FROM cart where email = '$email'";

	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();
	while ($row = $result->fetch_assoc()) {
	  // $grand_total += $row['total_price'];
    $grand_total = $grand_total+($row['qty']*$row['price']);
	  $items[] = $row['ItemQty'];
	}
	$allItems = implode(', ', $items);
?>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Checkout Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="" id="order">
         <h4 class="text-center text-success p-2 mb-5">Confirm your orders and details</h4>
         <div class="p-3 mb-2 text-center displayOrder">
          <h5><b>Products: </b><?= $allItems; ?></h5>
          <h5 class="mt-3"><b>Total Amount: </b><?=number_format($grand_total,2) ?></h5>
        </div>
        <form action="" method="post" id="placeOrder">
          <input type="hidden" name="products" value="<?= $allItems; ?>">
          <input type="hidden" name="grand_total" value="<?= $grand_total; ?>">
          <div class="form-group">
          <label class="form-label">Full Name:</label>
            <input type="text" name="fullname" class="form-control" placeholder="Enter Name" value='<?php echo $fetch_info['firstname'] ." ". $fetch_info['lastname']?>'>
          </div>
          <div class="form-group">
          <label class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" placeholder="Enter Email" value='<?php echo $fetch_info['email'] ?>'>
          </div>
          <div class="form-group">
          <label class="form-label">Phone Number:</label>
            <input type="tel" name="phone" class="form-control" placeholder="Enter Phone" required>
          </div>
          <div class="form-group">
          <label class="form-label">Address:</label>
            <textarea name="address" class="form-control" rows="3" cols="10" placeholder="Enter Delivery Address Here..." required></textarea>
          </div>
          <h6 class="text-center lead mt-5 fw-bold">Select Payment Mode</h6>
          <div class="form-group">
            <select name="paymentmode" class="form-control mt-3">
              <option value="Cash On Delivery"></i>Cash On Delivery</option>
              <option value="Walk-in">Walk-In</option>
              <option value="Debit/Credit Card">Debit/Credit Card</option>
            </select>
          </div>
          <div class="modal-footer">
          <!-- <button type="submit" class="btn btn-primary btn-lg btn-block btnSignin" name="signin">Sign in</button> -->
          <button type="submit" name="submit" class="btn btn-primary btn-lg mb-3 btn-block">Confirm order</button>
        <button type="button" class="btn btn-secondary btn-lg  btn-block" data-bs-dismiss="modal">Close</button>
      </div>
        </form>
      </div>
      </div>
    </div>
  </div>
</div>
  </div>
</div>

<script src="/assets/js/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="/assets/css/sweetalert2.min.css">

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/5.0.0/mdb.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.6.1.slim.js" integrity="sha256-tXm+sa1uzsbFnbXt8GJqsgi2Tw+m4BLGDof6eUPjbtk=" crossorigin="anonymous"></script> -->

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$(document).ready(function() {

// Send product details in the server
$(".addItemBtn").click(function(e) {
  e.preventDefault();
  var $form = $(this).closest(".form-submit");
  var id = $form.find(".id").val();
  var product = $form.find(".product").val();
  var price = $form.find(".price").val();
  var image_file = $form.find(".image_file").val();
  var serialnumber = $form.find(".serialnumber").val();

  var quantity = $form.find(".quantity").val();

  $.ajax({
    url: '../customer/config/action.php',
    method: 'post',
    data: {
      id: id,
      product: product,
      price: price,
      quantity: quantity,
      image_file: image_file,
      serialnumber: serialnumber
    },
    success: function(response) {
      $("#message").html(response);
      // window.scrollTo(0, 0);
      load_cart_item_number();
    }
  });
});

// Load total no.of items added in the cart and display in the navbar
load_cart_item_number();

function load_cart_item_number() {
  $.ajax({
    url: '../customer/config/action.php',
    method: 'get',
    data: {
      cartItem: "cart_item"
    },
    success: function(response) {
      $("#cart-item").html(response);
    }
  });
}


  $(".btnRemove").on('click', function(e) {
      e.preventDefault();

      const href = $(this).attr('href')

      Swal.fire({
      title: 'Remove from the cart?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Remove'
    }).then((result) => {
      if (result.value) {
          document.location.href = href;
      }
    })
  });

      // Sending Form data to the server
      $("#placeOrder").submit(function(e) {
        e.preventDefault(); 
  
        $.ajax({
          url: '../customer/config/action.php',
          method: 'post',
          data: $('form').serialize() + "&action=order",
          success: function(response) {
            $("#order").html(response);
            window.scrollTo(0, 0);
            load_cart_item_number();
          }
        });
      });

      $('#modalOrder').on('hidden.bs.modal', function () {
        location.reload();
       })
  
});


function updcart(id){
$.ajax({
  url:'/pages/customer/updqty.php',
  type:'POST',
  data:$("#frm"+id).serialize(),
  success:function(res){
    location.reload(true);
    // $("#cartcart").html(res);
  }
});

}

  // Update Cart Data
  $(document).ready(function () {

$('.changeQuantity').click(function (e) {
    e.preventDefault();

    var quantity = $(this).closest(".cartList-container").find('.itemQty').val();
    var product_id = $(this).closest(".cartList-container").find('.card-title').val();

    var data = {
        '_token': $('input[name=_token]').val(),
        'quantity':quantity,
        'card-title':card-title,
    };

    $.ajax({
        url: '/update-to-cart',
        type: 'POST',
        data: data,
        success: function (response) {
            window.location.reload();
            alertify.set('notifier','position','top-right');
            alertify.success(response.status);
        }
    });
});

});

</script>

</body>
</html>