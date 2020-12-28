
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
          @if ($restaurant->logo != "")
            <img src="{{$restaurant->logo}}" heigth="70%">
          @endif
          <h1>{{$restaurant->name}}</h1>
          <p>{{$restaurant->address_one}} {{$restaurant->address_two}} {{$restaurant->city}}</p>
        </div>    
    </header>

    
    <div class="row">
      <div class="col-md-3" >
        <div class="w3-bar-block">
            @foreach ($category as $cat)
              <a href="{{url('/').'/'.$cat->user_id.'/'.$cat->category_order_by}}" class="w3-bar-item w3-button "> {{$cat->name}}</a>
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
              <td>{{$item->item_name}}</td>
              <td><img src={{$item->item_image}} width="200px" height="200px"></td>
              <td>${{$item->price}}</td>
              <td>{{$item->item_description}}</td>
              <td><button onclick=""><i class="fas fa-arrow-right"></i></button></td>
            </tr>
           @endforeach
          </tbody>
        </table>
      </div> 
      <div class="col-md-4 bucket">
        <h2 align="center">My Purchase</h2>
        <table class="table ">
          <thead align="center">
            <tr class="table-active">
              <td>Item</td>
              <td>Picture</td>
              <td>Quantity</td>
              <td>Price</td>
            </tr>
          </thead>
          <tbody align="center">
            
          </tbody>
        </table>
      </div>
    </div>  
    <script>

    </script>
</body>
</html>