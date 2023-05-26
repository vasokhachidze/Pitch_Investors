<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404</title>
</head>




<style>
    .error-page-wrapper {
        height: 100vh;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;

    }
    .error-page-wrapper .error-page-inner {
        position: relative;
        background-image: url(/404-bg.png);
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        height: 100%;
        width: 100%;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
    }


    .error-page-wrapper .error-page-inner .all-btn{
        margin-top: 20%;
        font-size: 20px;
    background-color: #7dba3f;
    color: #fff;
    padding: 8px 34px;
    text-decoration: none;
    border: 5px solid #7dba3f;
    transition: 1s;
    display: inline-block;
    position: relative;
    border-radius: 5px;
        margin-left: 10%;
    }
    

</style>

<body>

    <div class="error-page-wrapper" style="background-image: url('{{asset('uploads/404/404.png')}}')">
        <div class="error-page-inner">
            <a href="{{url('/')}}" class="all-btn"> Back to home</a>
        </div>
    </div>

</body>

</html>