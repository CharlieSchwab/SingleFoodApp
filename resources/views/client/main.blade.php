
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Supa Food Server</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href= {{ asset('public/css/main.css') }} rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <style>

      @media only screen and (max-width: 900px) {
        #Sidenav1{
          width:0;
        }
      }

      @media only screen and (min-width: 900px) {
        #Sidenav1{
          width:280px;
        }
      }

      @media only screen and (max-width: 1100px) {
        #Sidenav2{
          width:0;
        }
      }

      @media only screen and (min-width: 1100px) {
        #Sidenav2{
          width:320px;
        }
      }

      body {
        font-family: "Lato", sans-serif;
      }

      #Sidenav1{
        left:0;
      }
      
      #Sidenav2{
        right:0;
      }

      .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        background-color: rgb(32, 26, 19);
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
        
      }
      
      .sidenav a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 18px;
        color: #818181;
        display: block;
        transition: 0.3s;
      }
      
      .sidenav a:hover {
        color: #f1f1f1;
      }
      
      .sidenav .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
      }

    #navbar {
      align-content: center;
      overflow: hidden;
      background-color: #333;
      padding-left:30%;
    }

    #navbar a {
      float: left;
      display: block;
      color: #f2f2f2;
      text-align: center;
      padding: 14px;
      text-decoration: none;
    }

    .content {
      padding: 16px;
    }

    .sticky {
      position: fixed;
      top: 0;
      width: 100%;
    }

    .sticky + .content {
      padding-top: 60px;
    }

    .container{
      width:50%;
      margin-bottom: 30px;
    }

    #Sidenav2{
      color: #818181;
      cursor:default;
    }

    #purchaseTable{
      color: #818181;
      cursor:default;
    }
   
      
    </style>
</head>
<body>
    <header>
        <img src="{{url('public/img/header.jpg')}}" alt="Nature" class="responsive">
        
        <div class="main_content">
          {{-- @if ($restaurant->logo != "")
            <img src="{{$restaurant->logo}}" heigth="70%">
          @endif --}}
          <h1>{{$restaurant->name}}</h1>
          <p>{{$restaurant->address_one}} {{$restaurant->address_two}} {{$restaurant->city}}</p>
        </div>    
    </header>
    <div class="noti"></div>
    <!-- The Modal -->
    <div class="modal fade" id="myModal">
      <div class="modal-dialog">
        <div class="modal-content">
    
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title" style="text-align:center">Please enter Name and Password</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
    
          <!-- Modal body -->
          <div class="modal-body">
            {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
            <script>
              function loginStart(){
                $.ajax({
                  url: "/customer/login",
                  context: {
                      userN : $('#userN').value,
                      userP : $('#userP').value
                  }
                }).done(function() {
                  alert("ok");
                }).fail(function(){
                  alert("fail");
                })
              }
            </script>
            <form action="{{url('/customer/login')}}" method="post">
              {{ csrf_field() }}
              <div class="form-group">
                <label>User Name:</label>
                <input placeholder="Input Name" class="form-control" type="text" name="userN" id="userN">
              </div>
              <div class="form-group">
                <label>User Password:</label>
                <input placeholder="Input Password" class="form-control" type="text" name="userP" id="userP">
              </div>
              If you haven't signed up yet, please <a data-toggle="modal" data-target="#register" href="#" > <span class="text text-primary register">sign up</span></a>
              
              <div style="margin-left:30%">
                <input type="hidden" name="userR" id="userR" value="{{$restaurant->restaurant_id}}">
                <a class="btn btn-primary" href="javascript:loginStart()" >Login</a>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="register">
      <script>
          function registerStart(){
              $.ajax({
                url: "/customer/register",
                context: {
                    email : $('#email').value,
                    pass1 : $('#psw').value,
                    pass2 : $('#psw-repeat')
                }
              }).done(function() {
                alert("ok");
              }).fail(function(){
                alert("fail");
              })
        </script>
      <div class="modal-dialog">
        <div class="modal-content">
          
          <div class="modal-header">
            <h4 class="modal-title" style="text-align:center">Please register</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form action="action_page.php">
              <div class="container-fluid">
                <div class="form-group">
                  <label for="email"><b>Email</b></label>
                  <input type="text" placeholder="Enter Email" name="email" id="email" required>
                </div>

                <div class="form-group">
                  <label for="psw"><b>Password</b></label>
                  <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
                </div>
                <div class="form-group">
                  <label for="psw-repeat"><b>Repeat Password</b></label>
                  <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>
                </div>
                <hr>
                <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
                <button type="button" onclick="registerStart()" class="registerbtn">Register</button>
              </div>
  
              <div class="container signin">
                <p>Already have an account? <a data-target="#myModal" data-toggle="modal" href="#">Sign in</a>.</p>
              </div>
            </form>
          </div>
          
        </div>
      </div>
    </div>

   
    <div id="navbar">
      <a href="javascript:openNav()">Restaurant Menu</a>
      <a href="javascript:openNav2()">My Purchase</a>
      @if ($user == 'guest')
      <a data-toggle="modal" data-target="#myModal" href="#" >Login</a>
      @else
      {{-- <a href="{{route('/customer/2'.$restaurant->retaurant_id)}}" >Signout</a> --}}
      @endif
    </div>


    <div id="Sidenav1" class="sidenav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      @foreach ($category as $cat)
        <a href="{{url('/customer').'/'.$cat->user_id.'/'.$cat->category_order_by}}" class="w3-bar-item w3-button "> {{$cat->name}}</a>
      @endforeach
    </div>

    <div id="Sidenav2" class="sidenav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav2()">&times;</a>
        <h2 style="color:chocolate" align="center">My Purchase</h2>
        <a style="display:inline-block; margin-left:10%" href="{{url('/stripe-payment')}}"><button class="btn btn-primary" id="buycart"><i class="fa fa-credit-card"></i>  Purchase Now!</button></a>
        <p style="display:inline; color:chocolate;font-size:20px" id="totPrice"></p>
          <table class="table" id="purchaseTable">
            <thead align="center">
              <tr class="table-active">
                <td>Item</td>
                <td>Quantity</td>
                <td>Price</td>
                <td>Cancel</td>
              </tr>
            </thead>
            <tbody align="center" id="listbody">
              

            </tbody>
          </table>
    </div>
    
      <div class="container">
        <table class="table table-striped table-hover">
          <thead align="center">
            <tr class="table-active">
              <td>Item</td>
              <td>Photo</td>
              <td>Price</td>
              <td>Description</td>
              <td>Put into Cart</td>
            </tr>
          </thead>
          <tbody align="center">
            @foreach($items as $item)
            <tr>
              <td class="itemName">{{$item->item_name}}</td>
              <td><img src="{{$item->item_image}}" width="200px" height="200px"></td>
              <td class="itemPrice">${{$item->price}}</td>
              <td>{{$item->item_description}}</td>
              <td><div><button class="addcart btn btn-success" @if ($user=='1guest') disabled  @endif name="{{$item->item_name}}"><i class="fas fa-arrow-right"></i></button></div>
                @if ($user=='1guest') <p style="color:red;cursor:default"> Please signin to purchase </p> @endif
              </td>
            </tr>
           @endforeach
          </tbody>
        </table>
      </div> 


    <script>
      function openNav() {
        document.getElementById("Sidenav1").style.width = "280px";
      }
      
      function closeNav() {
        document.getElementById("Sidenav1").style.width = "0";
      }
      function openNav2() {
        document.getElementById("Sidenav2").style.width = "320px";
      }
      
      function closeNav2() {
        document.getElementById("Sidenav2").style.width = "0";
      }
      window.onscroll = function() {myFunction()};

      var navbar = document.getElementById("navbar");

      var sticky = navbar.offsetTop;

      function myFunction() {
        if (window.pageYOffset >= sticky) {
          navbar.classList.add("sticky")
        } else {
          navbar.classList.remove("sticky");
        }
      }
    </script>

  <script>
      $(document).ready(function(){    

        let itemN;
        let itemP;      
        let itemQ;        
        let newItem;
        let Newpur;  
        let purItem;
        let totPrice = 0;

        let Mypur = JSON.parse(sessionStorage.getItem("MyPurchase"));

        if(totPrice > 0){
          $("#buycart").attr('dsabled','false');
        } else {
          $("#buycart").attr('dsabled','true');
        }

        if(Mypur != null){
          Mypur.forEach(item=>{
            if(item){
              $("#listbody").append(`<tr><td class="itemNorm">${item.itemN}</td><td class="itemQuan">${item.itemQ}</td><td class="itemP">$${item.itemP}</td><td><button class="delitem btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i></button</td></tr>`);
                totPrice += parseFloat(item.itemP);
            }
          });
          $("#totPrice").text("$"+totPrice.toFixed(2));
          sessionStorage.setItem("total",totPrice.toFixed(2));
        }

        $(".delitem").click(function(){
          itemN = $(this).parent().parent().find(".itemNorm").text();
          Mypur = JSON.parse(sessionStorage.getItem("MyPurchase"));
          Mypur.forEach((item,index)=>{
            if(item!=null){
              if(item.itemN == itemN){
                delete Mypur[index];
                totPrice -= item.itemP;
                if(totPrice == 0){
                    $("#buycart").attr('dsabled','true');
                  }
                $("#totPrice").text("$"+totPrice.toFixed(2));
                sessionStorage.setItem("total",totPrice.toFixed(2));
              }
            }
          });

          Newpur = [];
          for(let i=0;i<Mypur.length;i++){
            if(Mypur[i]){
              Newpur.push(Mypur[i]);
            }
          }

          sessionStorage.setItem("MyPurchase",JSON.stringify(Newpur));
          $(this).parent().parent().remove();
          
        });

        $(".addcart").click(function(){

          itemN = $(this).parent().parent().parent().find(".itemName").text();
          itemP = parseFloat($(this).parent().parent().parent().find(".itemPrice").text().slice(1));      
          itemQ = 1;        
          newItem = 1;  

          totPrice += itemP;

          if(totPrice > 0){
            $("#buycart").attr('dsabled','false');
          }
          $("#totPrice").text("$"+totPrice.toFixed(2));
          sessionStorage.setItem("total",totPrice.toFixed(2));

          purItem = {itemN,itemP,itemQ};

          console.log(Mypur);

          Mypur = JSON.parse(sessionStorage.getItem("MyPurchase"));

          Newpur = [];
            if(Mypur){
              for(let i=0;i<Mypur.length;i++){
              if(Mypur[i]){
                Newpur.push(Mypur[i]);
              }
            }
            sessionStorage.setItem("MyPurchase",JSON.stringify(Newpur));
          }
            

          
          if(Mypur != null){
            Mypur.forEach(item=>{
              if(item){
                if(item.itemN == itemN){
                  newItem = 0;
                  item.itemQ = parseInt(item.itemQ) + 1;
                  itemQ = item.itemQ;
                  item.itemP = (parseFloat(itemP) * itemQ).toFixed(2);
                  itemP = item.itemP;
                }
              }
            });
            if(newItem == 1){
              Mypur.push(purItem);
            }
          }else{
            Mypur = [];
            Mypur.push(purItem);
          }
          sessionStorage.setItem("MyPurchase",JSON.stringify(Mypur));

          $.each($("#listbody").children(), function( index) {
            if($(this).find(".itemNorm").text()==itemN){
              $(this).find(".itemQuan").text(itemQ);
              $(this).find(".itemP").text("$"+itemP);
            }
          });
         
          if(newItem == 1){
            $("#listbody").append(`<tr><td class="itemNorm">${itemN}</td><td class="itemQuan">${itemQ}</td><td class="itemP">$${itemP}</td><td><button class="delitem btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i></button</td></tr>`);
          }
              
          $(".delitem").click(function(){
            itemN = $(this).parent().parent().find(".itemNorm").text();
            Mypur = JSON.parse(sessionStorage.getItem("MyPurchase"));
            Mypur.forEach((item,index)=>{
              if(item!=null){
                if(item.itemN == itemN){
                  delete Mypur[index];
                  totPrice -= item.itemP;
                  if(totPrice == 0){
                    $("#buycart").attr('dsabled','true');
                  }
                  $("#totPrice").text("$"+totPrice.toFixed(2));
                  sessionStorage.setItem("total",totPrice.toFixed(2));
                }
              }
            });


            Newpur = [];
            for(let i=0;i<Mypur.length;i++){
              if(Mypur[i]){
                Newpur.push(Mypur[i]);
              }
            }


            sessionStorage.setItem("MyPurchase",JSON.stringify(Newpur));
            $(this).parent().parent().remove();
           
          });

        });
        
      });

    </script>
</body>
</html>