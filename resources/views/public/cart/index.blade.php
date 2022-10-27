@extends('layout.home')
@section('content')
    <div class="privacy">
        <div class="container" style="width:90%">
            <h3 class="tittle-w3l">Giao hàng
                <span class="heading-style">
                    <i></i>
                    <i></i>
                    <i></i>
                </span>
            </h3>
            <div class="row">
                <div class="col-sm-8" id="cart_item">
                    @include('public.cart.cart_ajax')
                </div>
                <div class="col-sm-4">
                    <div class="address_form_agile">
                        <h4>Thêm địa chỉ mua hàng</h4>
                        <form id="pay_by_cash" class="creditly-card-form agileinfo_form" autocomplete="off">
                            <div class="creditly-wrapper wthree, w3_agileits_wrapper">
                                <div class="information-wrapper">
                                    <div class="first-row">
                                        <div class="controls">
                                            <input class="billing-address-name" type="text" name="name" id="receiver"
                                                placeholder="Tên Người nhận" required="">
                                        </div>
                                        <div class="w3_agileits_card_number_grids">
                                            <div class="w3_agileits_card_number_grid_left">
                                                <div class="controls">
                                                    <input type="text" placeholder="Số điện thoại" id="phone_format"
                                                        name="number" required="" maxlength="11" minlength="10">
                                                </div>
                                            </div>
                                            <div class="w3_agileits_card_number_grid_right">
                                                <div class="controls">
                                                    <select placeholder="Thành phố" id="delivery" name="delivery" required>
                                                        <option value="" selected>Chọn thành phố</option>
                                                        @foreach ($delivery as $key => $val)
                                                            <option value="{{ $val->city }}">{{ $val->city }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="w3_agileits_card_number_grid_right">
                                                <div class="controls">
                                                    <input type="text" placeholder="Địa chỉ" id="location"
                                                        name="landmark" required="">
                                                </div>
                                            </div>
                                            <div class="clear"> </div>
                                        </div>
                                        <div class="controls">
                                            <textarea
                                                style="
                                border-style:none;
                                border-bottom: 1px solid #FF5722;
                                -webkit-box-shadow: 0px 0px 3px 0px rgb(0 0 0 / 31%);
                                -moz-box-shadow: 0px 0px 3px 0px rgba(0, 0, 0, 0.31);
                                box-shadow: 0px 0px 3px 0px rgb(0 0 0 / 31%);
                                width:100%;
                            "
                                                rows="5" placeholder="Ghi chú" id="note"></textarea>
                                        </div>
                                    </div>
                                    {{-- <button class="submit check_out">Delivery to this Address</button> --}}

                                </div>
                            </div>
                            <label>Thanh toán offline</label>
                            <div class="checkout-right-basket">
                                <input class="btn btn-primary" type="submit" value="Đặt hàng" />
                            </div>
                            <hr />
                        </form>
                        <label>Thanh toán online</label>
                        <br /><br />
                        {{-- <form action="{{URL::TO('/vnpay')}}" method="POST">
                                @csrf
                                <button type="submit" class="btn-vnpay"><span style="color:red">VN</span> <span style="color:blue">PAY</span></button>
</form> --}}
                        <br />
                        <p id="error" class="text-center hidden">Xin hãy điền đủ thông tin</p>
                        <div id="vn_pay">
                            <div id="paypal-button-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script
        src="https://www.paypal.com/sdk/js?client-id=AU6V3tMjm0p5FUQSpGxvfw0w0HbCy-dnSj5sI5XilsZ6U62I1pv3cQmGZ8Q6l-dkO4lztuiPwZh-th4v&currency=USD">
    </script>
    <script>
        var total = 0;
        var receiver = '';
        var phone = '';
        var city = '';
        var locationn = '';
        var note = '';
        var payment_type = '';
        var item = 0;
        paypal.Buttons({
            // onInit is called when the button first renders
            onInit: function(data, actions) {
                // Disable the buttons
                actions.disable();
                // Enable or disable the button when it is checked or unchecked
                document.querySelector('#pay_by_cash').addEventListener('input', function() {
                    total = $('#total-price').val();
                    total = total / 23000;
                    total = total.toFixed(2);
                    receiver = $("#receiver").val();
                    phone = $("#phone_format").val();
                    city = $("#delivery").val();
                    locationn = $("#location").val();
                    note = $("#note").val();
                    if (total > 0 && receiver && phone && city && locationn) {
                        actions.enable();
                    } else {
                        actions.disable();
                    }
                });
            },
            // onClick is called when the button is clicked
            onClick: function() {
                // Show a validation error if the checkbox is not checked
                if (total < 0 || !receiver || !phone || !city || !locationn) {
                    document.querySelector('#error').classList.remove('hidden');
                }
            },
            // Sets up the transaction when a payment button is clicked
            createOrder: (data, actions) => {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: `${total}` // Can also reference a variable or function
                        }
                    }]
                });
            },
            // Finalize the transaction after payer approval
            onApprove: (data, actions) => {
                return actions.order.capture().then(function(orderData) {
                    // Successful capture! For dev/demo purposes:
                    payment_type = "VNPAY";
                    $.ajax({
                        url: "{{ url('/order/store') }}",
                        method: "POST",
                        data: {
                            receiver: receiver,
                            phone: phone,
                            city: city,
                            location: locationn,
                            note: note,
                            payment_type: payment_type
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            Swal.fire({
                                title: "Đặt hàng thành công",
                                text: "Đơn hàng của bạn sẽ được cập nhật sau giây lát",
                                icon: "success",
                            });
                            setTimeout(() => {
                                window.location.href = "{{ url('/') }}";
                            }, 1000);
                        }
                    });
                });
            }
        }).render('#paypal-button-container');
    </script>

    <script>
        function delete_cart_item(id) {
            var rowid = $(".cart_rowId" + id).val();
            $.ajax({
                url: "{{ url('/cart/delete') }}" + "/" + rowid,
                method: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $("#cart_item").html(data);
                }
            });
        }
    </script>
    <script>
        function cart_minus_item(id) {
            var rowid = $(".cart_rowId" + id).val();
            var number = -1;
            $.ajax({
                url: "{{ url('/cart/update') }}" + "/" + rowid,
                method: "POST",
                data: {
                    number: number
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $("#cart_item").html(data);
                }
            });
        }
    </script>
    <script>
        function cart_push_item(id) {
            var rowid = $(".cart_rowId" + id).val();
            var number = 1;
            $.ajax({
                url: "{{ url('/cart/update') }}" + "/" + rowid,
                method: "POST",
                data: {
                    number: number
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $("#cart_item").html(data);
                }
            });
        }
    </script>
    <script>
        $("#phone_format").keyup(function() {
            //Filter only numbers from the input
            let cleaned = ('' + $(this).val()).replace(/\D/g, '');
            $(this).val(cleaned);
            //Check if the input is of correct length
            let match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
            let phone = '' + match[1] + '-' + match[2] + '-' + match[3];
            $(this).val(phone);
        });
    </script>
    <script>
        $("#delivery").change(function() {
            var city = $(this).val();
            $.ajax({
                url: "{{ url('/delivery') }}",
                method: "POST",
                data: {
                    city: city
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $("#cart_item").html(data);
                }
            });
        });
    </script>
    <script>
        $("#pay_by_cash").submit(function(e) {
            e.preventDefault();
            item = "{{ Cart::count() }}";
            if (item <= 0) {
                Swal.fire({
                    title: "",
                    text: "Bạn chưa có sản phẩm trong giỏ hàng",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "<a style='color:white' href='{{ url('/') }}'><i class='la la-headphones'></i>Mua ngay</a>",
                    showCancelButton: true,
                    // cancelButtonText: "<i class='la la-thumbs-down'></i> Mua tiếp",
                    customClass: {
                        confirmButton: "btn btn-success",
                        // cancelButton: "btn btn-default"
                    }
                });
            } else {
                receiver = $("#receiver").val();
                phone = $("#phone_format").val();
                city = $("#delivery").val();
                locationn = $("#location").val();
                note = $("#note").val();
                payment_type = "Trả tiền mặt";
                $.ajax({
                    url: "{{ url('/order/store') }}",
                    method: "POST",
                    data: {
                        receiver: receiver,
                        phone: phone,
                        city: city,
                        location: locationn,
                        note: note,
                        payment_type: payment_type
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        Swal.fire({
                            title: "Đặt hàng thành công",
                            text: "Đơn hàng của bạn sẽ được cập nhật sau giây lát",
                            icon: "success",
                        });
                        setTimeout(() => {
                            window.location.href = "{{ url('/') }}";
                        }, 1000);
                    }
                });
            }
        });
    </script>
@endsection
