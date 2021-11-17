<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://oss.maxcdn.com/semantic-ui/2.2.10/semantic.min.css">

    <link href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" rel="stylesheet">

    <style>
        .login__wrapper-B .login__inner .button {
    text-transform: none;
    }

    body{
        background: radial-gradient(ellipse at bottom, #1b2735 0%, #090a0f 100%);
    }

    .night .button--twitch {
        background-color: #9146ff;
        color: #fff;
    }

    .star-glow{
        animation: glow 1.5s linear alternate infinite;
    }

    @keyframes glow {
        0% {
            text-shadow: 1px 1px 5px gold;
        }
        100% {
            text-shadow: 1px 1px 15px gold;
        }
    }

    </style>
</head>
<body>



    @foreach ($datos_subs as $ds)

        {{ $i = $loop->index +1 }}
        <div class="star{{ $i }} " style="position: absolute; display:none; animation: glow {{ mt_rand(1, 3) }}s linear alternate infinite;"><i style="font-size: 15px; color:gold;" class="fas fa-star"></i></div>

        <script>console.log('{{ $ds }}')</script>


    @endforeach






    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/15a0d76b97.js" crossorigin="anonymous"></script>
    <script>
        function makeDiv(){


            for (let index = 0; index < 10000; index++) {

                var divsize = ((Math.random()*100) + 50).toFixed();
                var color = '#'+ Math.round(0xffffff * Math.random()).toString(16);

                var timeGlow = Math.floor(Math.random() * 1.5) + 1;

                star = document.querySelectorAll(".star");
                var posx = (Math.random() * ($(document).width() - divsize)).toFixed();
                var posy = (Math.random() * ($(document).height() - divsize)).toFixed();

                console.log(index)

                // $(".star"+index).css({'left':posx+'px', 'top':posy+'px', 'animation': 'glow '+timeGlow+'s linear alternate infinite'}).appendTo( 'body' ).fadeIn(100);
                $(".star"+index).css({'left':posx+'px', 'top':posy+'px'}).appendTo( 'body' ).fadeIn(100);
            }



        };

            makeDiv();
    </script>
</body>
</html>