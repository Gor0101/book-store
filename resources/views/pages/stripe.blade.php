<!DOCTYPE html>
<html>
<head>
    <title>Payment Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #0C4160;

            padding: 30px 10px;
        }

        .card {
            max-width: 500px;
            margin: auto;
            color: black;
            border-radius: 20px;
        }

        p {
            margin: 0px;
        }

        .container .h8 {
            font-size: 30px;
            font-weight: 800;
            text-align: center;
        }

        .btn.btn-primary {
            width: 100%;
            height: 70px;
            align-items: center;
            justify-content: space-between;
            padding: 0 15px;
            background-image: linear-gradient(to right, #28a745 0%, #28a745 51%, #095a1d 100%);
            border: none;
            transition: 0.5s;
            background-size: 200% auto;

        }


        .btn.btn.btn-primary:hover {
            background-position: right center;
            color: #fff;
            text-decoration: none;
        }


        .btn.btn-primary:hover .fas.fa-arrow-right {
            transform: translate(15px);
            transition: transform 0.2s ease-in;
        }

        .form-control {
            color: white;
            background-color: #223C60;
            border: 2px solid transparent;
            height: 60px;
            padding-left: 20px;
            vertical-align: middle;
        }

        .form-control:focus {
            color: white;
            background-color: #0C4160;
            border: 2px solid #2d4dda;
            box-shadow: none;
        }

        .text {
            font-size: 14px;
            font-weight: 600;
        }

        ::placeholder {
            font-size: 14px;
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="container p-0">
    <div class="card px-4">
        <p class="h8 py-3">Payment Details for {{$book->name}}</p>
        @if (Session::has('success'))
            <div class="alert alert-success text-center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <p>{{ Session::get('success') }}</p>
            </div>
        @endif
        <form
            role="form"
            action="{{ route('stripe.post', $book->id) }}"
            method="post"
            class="require-validation"
            data-cc-on-file="false"
            data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
            id="payment-form">
            @csrf
            <div class="row gx-3 text-center">
                <div class="col-12">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">Person Name</p>
                        <input class="form-control mb-3" type="text" placeholder="Name">
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">Card Number</p>
                        <input class="form-control mb-3 card-number" type="text" placeholder="1234 5678 435678">
                    </div>
                </div>
                <div class="col-3">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">Month</p>
                        <input class="form-control mb-3 form-control card-expiry-month" type="text" placeholder="MM">
                    </div>
                </div>
                <div class="col-3">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">Year</p>
                        <input class="form-control mb-3 form-control card-expiry-year" type="text" placeholder="YYYY">
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex flex-column">
                        <p class="text mb-1">CVV/CVC</p>
                        <input class="form-control mb-3 pt-2 card-cvc" type="password" placeholder="***">
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now (${{$book->price}})</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    $(function () {
        var $form = $(".require-validation");
        $('form.require-validation').bind('submit', function (e) {
            var $form = $(".require-validation"),
                inputSelector = ['input[type=email]', 'input[type=password]',
                    'input[type=text]', 'input[type=file]',
                    'textarea'
                ].join(', '),
                $inputs = $form.find('.required').find(inputSelector),
                $errorMessage = $form.find('div.error'),
                valid = true;
            $errorMessage.addClass('hide');
            $('.has-error').removeClass('has-error');
            $inputs.each(function (i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    $input.parent().addClass('has-error');
                    $errorMessage.removeClass('hide');
                    e.preventDefault();
                }
            });
            if (!$form.data('cc-on-file')) {
                e.preventDefault();
                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeResponseHandler);
            }
        });

        function stripeResponseHandler(status, response) {
            if (response.error) {
                $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
            } else {
                /* token contains id, last4, and card type */
                var token = response['id'];
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }
    });
</script>
</html>
