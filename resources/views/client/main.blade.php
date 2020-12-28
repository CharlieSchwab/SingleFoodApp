
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Restuarant Ordering System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href= {{ asset('public/css/main.css') }} rel="stylesheet"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
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

    
    <div class="row">
      <div class="col-md-3" >
        <div class="w3-bar-block">
            @foreach ($category as $cat)
              <a href="{{url('/customer').'/'.$cat->user_id.'/'.$cat->category_order_by}}" class="w3-bar-item w3-button "> {{$cat->name}}</a>
            @endforeach
        </div>
      </div>

      <div class="col-md-5">
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
              <td><button class="addcart" name="{{$item->item_name}}"><i class="fas fa-arrow-right"></i></button></td>
            </tr>
           @endforeach
          </tbody>
        </table>
      </div> 
      <div class="col-md-4 bucket" >
        <h2  align="center">My Purchase</h2><a href="{{url('/stripe-payment')}}"><button id="buycart">Buy!</button></a>
        <table class="table ">
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
    </div>  

  <script>
      $(document).ready(function(){

        let itemN;
        let itemP;      
        let itemQ;        
        let newItem;
        let Newpur;  
        let purItem;

        let Mypur = JSON.parse(sessionStorage.getItem("MyPurchase"));

        if(Mypur != null){
          Mypur.forEach(item=>{
            if(item){
              $("#listbody").append(`<tr><td class="itemNorm">${item.itemN}</td><td class="itemQuan">${item.itemQ}</td><td class="itemP">$${item.itemP}</td><td><button class="delitem"><i class="fa fa-ban" aria-hidden="true"></i></button</td></tr>`);
            }
          });
        }

        $(".delitem").click(function(){
          itemN = $(this).parent().parent().find(".itemNorm").text();
          Mypur = JSON.parse(sessionStorage.getItem("MyPurchase"));
          Mypur.forEach((item,index)=>{
            if(item!=null){
              if(item.itemN == itemN){
                delete Mypur[index];
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

          itemN = $(this).parent().parent().find(".itemName").text();
          itemP = parseFloat($(this).parent().parent().find(".itemPrice").text().slice(1));      
          itemQ = 1;        
          newItem = 1;  

          purItem = {itemN,itemP,itemQ};

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
            $("#listbody").append(`<tr><td class="itemNorm">${itemN}</td><td class="itemQuan">${itemQ}</td><td class="itemP">$${itemP}</td><td><button class="delitem"><i class="fa fa-ban" aria-hidden="true"></i></button</td></tr>`);
          }
              
          $(".delitem").click(function(){
            itemN = $(this).parent().parent().find(".itemNorm").text();
            Mypur = JSON.parse(sessionStorage.getItem("MyPurchase"));
            Mypur.forEach((item,index)=>{
              if(item!=null){
                if(item.itemN == itemN){
                  delete Mypur[index];
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

        $("#buycart").click(function(){
          
          
        });

        
      });
    </script>
</body>
</html>