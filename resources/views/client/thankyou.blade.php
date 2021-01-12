<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stripe Payment Integration</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <style>
        *{
            margin-top:30px;
        }
    </style>
</head>
<body>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Thank you for the order.</h2>
                </div>
                @if (Request::has('receipt_url'))
                    <h4 class="text-center">
                        <a href="{{ Request::get('receipt_url') }}" target="_blank">
                            Click here to download you payment receipt
                        </a>
                    </h4>
                @endif
                <div class="col-md-12">
                    <form action="{{ url('customer/2')}}" method="get">
                        <button type="submit" class="btn btn-primary btn-block">Go Back</button>
                    </form>
                </div>
            </div>
            <br>
        </div>
    </div>


</body>
</html>


