<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>product</title>
    
</head>
<body>

    <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()">Generate Client token</button>
<br>
    
<div id="notification_value">

</div>

    <h2>Create Product</h2>
    <form id="product_form" method="POST">
       
        <label for="">Product Name</label>
        <input type="text" name="product_name">
        <br>
        <label for="">Size</label>
        <input type="text" name="size">
        <br>
        <label for="">Price</label>
        <input type="text" name="price">
        <br>
        <label for="">Quantity</label>
        <input type="text" name="quantity">
        <br>
        <input onclick="submitProduct()" type="button" value="Add Product">
    </form>
    <br><br>
    <h2>List of Products</h2>
    
    @foreach ($response_a as $item)
    <h3>Product {{ $loop->iteration }}</h3>
    <p>Product Name : {{ $item['product_name'] }}</p>
    <p>Product Size : {{ $item['size'] }}</p>
    <p>Product Price : {{ $item['price'] }}</p>
    <p>Product quantity : {{ $item['quantity'] }} </p>
    <br>
    @endforeach
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    {{-- <script src="{{ asset('firebase-messaging-sw.js') }}"></script> --}}
    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.6.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.6.2/firebase-messaging.js"></script>
    
    <!-- TODO: Add SDKs for Firebase products that you want to use
        https://firebase.google.com/docs/web/setup#available-libraries -->
       

    
    <script>
        submitProduct = () => {

            let _token = '{{ csrf_token() }}';
            
            let product = $("input[name='product_name']").val();
            let size = $("input[name='size']").val();
            let price = $("input[name='price']").val();
            let quantity = $("input[name='quantity']").val();
            
            $.ajax({
                url : '{{ url("product/create") }}',
                type : 'post',
                data : {product_name:product,size:size,price:price,quantity:quantity, _token:_token},
                success:function(data){
                    console.log(data);
                }
            });
        }
        
    </script>
        
        
        
            
            
    <script>
    // Your web app's Firebase configuration
    var firebaseConfig = {
        apiKey: "AIzaSyBrhfC7ZrhEyH_xNGXcR6HQUUGUVBNlnWw",
        authDomain: "interview-6168a.firebaseapp.com",
        projectId: "interview-6168a",
        storageBucket: "interview-6168a.appspot.com",
        messagingSenderId: "1028679469723",
        appId: "1:1028679469723:web:026d079d23d7505744943e"

    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    const messaging = firebase.messaging();

    function initFirebaseMessagingRegistration() {

        messaging

        .requestPermission()

        .then(function () {

            return messaging.getToken()

        })

        .then(function(token) {
            
            console.log(token);



            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });



            $.ajax({

                url: '{{ route("save-token") }}',

                type: 'POST',

                data: {

                    token: token

                },

                dataType: 'JSON',

                success: function (response) {

                    alert('Token saved successfully.');

                },

                error: function (err) {

                    console.log('User Chat Token Error'+ err);

                },

            });


        }).catch(function (err) {

            console.log('User Chat Token Error'+ err);

        });

        }  



        messaging.onMessage(function(payload) {
            // console.log('message get', payload);
            
        const noteTitle = payload.notification.title;
        const noteBody = payload.notification.body;
        // const noteOptions = {

        //     body: payload.notification.body,
        //     // icon: payload.notification.icon,

        // };

        let note = `<h3>${noteTitle}</h3>
        <p>${noteBody}</p>`;

        $('#notification_value').html(note);

        // new Notification(noteTitle, noteOptions);

        });

        
    </script>


</body>
</html>