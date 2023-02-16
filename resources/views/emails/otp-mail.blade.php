<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        html,
        body {
            overflow-x: hidden;
        }

        /* REMOVE THIS IN PRODUCTION */
        body {
            background: #eaeaea;
            display: flex;
            flex-direction: column;
            /* min-height: calc(100vh - 60px); */
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        /* REMOVE THIS IN PRODUCTION */


        a {
            color: #5E5CFA;
            text-decoration: none;
        }

        .card {
            margin: 0px auto;
        }

        .card-header {
            background: #F9F4FF;
            border-radius: 8px;
            padding: 46px 26px;
            margin-bottom: 39px;
        }

        .card-step .card-header {
            padding: 25px 25px 38px 25px;
        }

        .card-step .card-header::before {
            content: 0;
            display: none;
        }

        .text {

            font-weight: 400;
            font-size: 14px;
            line-height: 24px;
            color: #102E5B;
        }

        .text-strong {

            font-weight: 600;
            color: #102E5B;
            font-size: 16px;
            display: block;
            margin-bottom: 10px;
        }

        .text-margin {
            margin-top: 34px;
        }

        .text-margin-sm {
            margin-top: 23px;
        }

        .card {
            padding: 26px 25px 32px 21px;
            background: #ffffff;
            border-radius: 8px;
            max-width: 600px;
            width: 100%;
        }

        .content {
            padding: 0 26px;
        }



        .submit-btn {
            cursor: pointer;
            display: inline-block;
            padding: 18px 43px;
            background: #5E5CFA;

            font-weight: 600;
            font-size: 22px;
            border-radius: 5px;
            color: #ffffff;
            border: 0;
            outline: 0;
            margin-top: 20px;
        }

        .title {

            font-weight: 700;
            font-size: 35px;
            margin-bottom: 15px;
            color: #102E5B;
        }

        .main-title {

            font-weight: 600;
            font-size: 25px;
            margin-bottom: 10px;
            color: #5E5CFA;
        }

        .subtitle {

            font-weight: 400;
            font-size: 11px;
            color: #102E5B;
            max-width: 211px;
            width: 100%;
        }

        .card-footer {
            margin-top: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 26px;
        }

        .footer-logo {
            max-width: 93.52px;
            max-height: 21px;
            width: 100%;
            height: auto;
            margin-left: 10px;
        }

        @media screen and (max-width: 600px) {
            .card-header {
                background-image: none !important;
            }
            .card-header {
                background: #F9F4FF;
                border-radius: 8px;
                padding: 30px 20px;
                margin-bottom: 25px;
            }

            .submit-btn {
                padding: 10px 20px;
                font-size: 15px;
                margin-top: 15px;
            }

            .text-margin {
                margin-top: 25px;
            }

            .content,
            .card-footer {
                padding: 0 10px;
            }

            .card-footer {
                margin-top: 40px;
            }
        }

        @media screen and (max-width: 360px) {
            .main-title {
                font-size: 20px;
            }

            .card-footer span {
                font-size: 10px;
            }

            .footer-logo {
                max-width: 63px;
                margin-left: 5px;
            }
        }
    </style>
    <style>
        .card-header {
            position: relative;
            background-position: right;
            background-repeat: no-repeat;
            background-size: contain;
        }

        /* .card-header::before {
          content: '';
          position: absolute;
          display: block;
          top: 10px;
          right: -10px;
          width: 312px;
          height: 197px;
          background: url('./images/welcome-header.svg') no-repeat center;
          background-size: cover;
        } */


        @media screen and (max-width:600px) {
            .card-header::before {
                top: 0;
                width: 235px;
                height: 149px;
            }
        }

        @media screen and (max-width:510px) {
            .card-header::before {
                top: 30px;
                width: 160px;
                height: 101px;
            }
        }

        @media screen and (max-width:460px) {
            .card-header::before {
                content: 0;
                display: none;
            }
        }
    </style>
    <title>OTP Verification</title>
</head>

<body>
<div class="card">
    <header class="card-header">
        <div class="col">
            <h2 class="main-title">OTP: {{$data}}</h2>
        </div>
    </header>
</div>
</body>

</html>
