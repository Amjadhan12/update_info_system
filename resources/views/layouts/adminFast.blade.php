@if (Auth::user()->language == 'Pashto')

    <!DOCTYPE html>
    <html lang="ar" dir="rtl">

    <head>
        <title>Inventory | @yield("title")</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="{{ asset('mdb/css/mdb.rtl.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugin/fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugin/datatable/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugin/sweetalert/sweetalert.css') }}">
        <style>
            body {
                background-color: #eee;
            }

            main {
                min-height: 85vh;
            }

            .selected_row {
                background-color: royalblue !important;
                color: #fff;
            }

            .hidden {
                visibility: hidden;
            }

            .dropdown-menu {
                background-color: #93ECD1;
            }

            /* .dropdown-menu li a:hover {
            background-color: #6A1B9A;
            color: #fff;
        } */

        </style>
    </head>

    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Navbar brand -->
                <a class="navbar-brand" href="{{ url('/dashboard') }}">
                    <div class="spinner-border text-light" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    کورپاڼه
                </a>
                <!-- Toggle button -->
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                    data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left links -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <!-- Navbar dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav_add" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-plus"></i> جوړښټونه
                            </a>
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu" aria-labelledby="nav_add">
                                <li><a class="dropdown-item" href="{{ route('item.create') }}">جنسونه</a></li>
                                <li><a class="dropdown-item" href="{{ route('unit.index') }}">د جنس واحدات</a></li>
                                <li><a class="dropdown-item" href="{{ route('supplier.index') }}">شرکتونه</a></li>
                                <li><a class="dropdown-item" href="{{ route('customer.index') }}">مشتریان</a></li>
                                <li><a class="dropdown-item" href="{{ route('currency.index') }}">کرنسی</a></li>
                                <li><a class="dropdown-item" href="{{ route('stock.index') }}">ګودامونه</a></li>
                                <li><a class="dropdown-item" href="{{ route('setting.index') }}">جوړښت</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav_opening" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-object-group"></i> لومړني
                            </a>
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu" aria-labelledby="nav_opening">
                                <li><a class="dropdown-item" href="{{ route('openStock.index') }}">لومړني موجود
                                        اجناس</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('openPayable.index') }}">لومړنی د
                                        شرکتونو
                                        قرض</a></li>
                                <li><a class="dropdown-item" href="{{ route('openReceivable.index') }}">لومړنی په
                                        مشتریانو
                                        قرض</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav_capital" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="far fa-money-bill-alt"></i> نغدي
                            </a>
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu" aria-labelledby="nav_sale">
                                <li><a class="dropdown-item" href="{{ route('cashAccount.index') }}">نغدي حساب</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('cash.index') }}">نغدی سرمایه</a></li>
                                <li><a class="dropdown-item" href="{{ route('cashTransfer.index') }}">د نغدو
                                        انتقال</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('/accountCash') }}">نغدی حساب کتل</a></li>
                                <li><a class="dropdown-item" href="{{ route('dailyBook.index') }}">روزنامچه</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav_purchase" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-cart-arrow-down"></i> خریداری
                            </a>
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu" aria-labelledby="nav_purchase">
                                <li><a class="dropdown-item" href="{{ route('purchase.create') }}">خرید کول</a></li>
                                <li><a class="dropdown-item" href="{{ route('purchaseReturn.create') }}">د خرید
                                        واپسی</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('payment.index') }}">وصولی کول</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav_sale" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-cart-plus"></i> خرڅلاو
                            </a>
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu" aria-labelledby="nav_sale">
                                <li><a class="dropdown-item" href="{{ route('sale.create') }}">خرڅلاو کول</a></li>
                                <li><a class="dropdown-item" href="{{ route('saleReturn.create') }}">د خرڅلاو
                                        واپسي</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('received.index') }}">وصولی کول</a></li>
                                <li><a class="dropdown-item" href="{{ route('estimateSale.create') }}">د مشتری له
                                        خوا
                                        ارډر</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav_expense" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-trash"></i> مصارف
                            </a>
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu" aria-labelledby="nav_expense">
                                <li><a class="dropdown-item" href="{{ route('expense.index') }}">مصارف کول</a></li>
                                <li><a class="dropdown-item" href="{{ route('expenseCategory.index') }}">د مصارفو
                                        ډولونه</a>
                                </li>
                                <!-- <li><a class="dropdown-item" href="#">Wastes</a></li> -->
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav_stock" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-university"></i> سټاک
                            </a>
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu" aria-labelledby="nav_stock">
                                <li><a class="dropdown-item" href="{{ route('stockTransfer.index') }}">د اجناسو
                                        انتقال</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('/currentStock') }}">موجود سټاک</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav_account" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-users"></i> کهاتې
                            </a>
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu" aria-labelledby="nav_account">
                                <li><a class="dropdown-item" href="{{ url('/accountSupplier') }}">د شرکت کهاتې</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('/accountCustomer') }}">د مشتریانو
                                        کهاتې</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav_report" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-file-alt"></i> راپورونه
                            </a>
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu" aria-labelledby="nav_report">
                                <li><a class="dropdown-item" href="{{ url('/report/purchase') }}">د خريد راپور</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('/report/purchaseReturn') }}">د خرید د
                                        واپسي
                                        راپور
                                        Report</a></li>
                                <li><a class="dropdown-item" href="{{ url('/report/payment') }}">د خرید د وصولی
                                        راپور</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('/report/sale') }}">د خرڅلاو راپور</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('/report/saleReturn') }}">د خرڅلاو د واپسی
                                        راپور</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('/report/received') }}">د خرڅلاو د وصولی
                                        راپور</a></li>
                                <li><a class="dropdown-item" href="{{ url('/report/expense') }}">د مصارفو راپور</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('/report/cash') }}">نغدي راپور</a></li>
                                <li><a class="dropdown-item" href="{{ url('/report/asset') }}">سرمایه</a></li>
                                <li><a class="dropdown-item" href="{{ url('/report/item') }}">د جنسونه راپور</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('/report/expire') }}">د ایکسپاري راپور</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav_setting" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-globe"></i> {{ Auth::user()->language }}
                            </a>

                            <ul class="dropdown-menu" aria-labelledby="nav_setting">
                                <li><a class="dropdown-item" href="{{ route('language', 'English') }}">English</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('language', 'Pashto') }}">Pashto</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <!-- Left links -->

                    <!-- Search form -->
                    <div class="d-flex input-group w-auto text-left" dir="rtl">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                            id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                            <img class="rounded-circle" src="{{ Auth::user()->profile_photo_url }}"
                                alt="{{ Auth::user()->name }}" style="border: 1px solid #f1f1f1;" height="28" />
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ url('/user/profile') }}">Profile</a></li>
                            @if (Auth::user()->user_type == 'Admin')
                                <li><a class="dropdown-item" href="{{ route('user.index') }}">Users</a></li>
                            @endif
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </div>
                <!-- Collapsible wrapper -->
            </div>
            <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->


        @section('body')

        @show



        <footer class="bg-light text-center text-lg-start">
            <!-- Copyright -->
            <div class="text-center p-3" style="background-color: rgba(0, 161, 112,0.2);">
                © 2020 Copyright:
                <a class="text-dark" href="https://mtechsh.com/" target="_blank">mtechsh.com</a>
            </div>
            <!-- Copyright -->
        </footer>

        <script src="{{ asset('plugin/jquery3.5.1.js') }}"></script>
        <script src="{{ asset('mdb/js/mdb.min.js') }}"></script>
        <script src="{{ asset('plugin/datatable/datatables.min.js') }}"></script>
        <script src="{{ asset('plugin/fontawesome/js/all.min.js') }}"></script>
        <script src="{{ asset('plugin/sweetalert/sweetalert.min.js') }}"></script>
        <script src="{{ asset('plugin/notify/bootstrap-notify.min.js') }}"></script>

        <script>
            let itemPrimarySprice = 0;
            let itemPrimaryPprice = 0;
            $("input").attr("autocomplete", "off");
            $('.data_table').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copyHtml5',
                        footer: true
                    },
                    {
                        extend: 'excelHtml5',
                        footer: true
                    },
                    {
                        extend: 'pdfHtml5',
                        footer: true
                    },
                    {
                        extend: 'print',
                        footer: 'true',
                        // title: "Title of your print",
                        autoPrint: 'false',
                        customize: function(win) {
                            $(win.document.body)
                                .css({
                                    'font-size': '8pt',
                                    'background-color': 'white'
                                });

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', '14px');
                        }
                    }
                ]
            });



            $(".spinner-border").css("visibility", "hidden");
            $(document).ajaxStart(function() {
                $(".spinner-border").css("visibility", "visible");
            });
            $(document).ajaxComplete(function() {
                $(".spinner-border").css("visibility", "hidden");
            });


            $("form").submit(function() {
                $(":submit").attr("disabled", "disabled");
            });
            $("body").dblclick(function() {
                $(":submit").removeAttr("disabled");
            })

            $('.number').keyup(function() {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            });
            // $(":submit").on('click', function(event) {
            //     $(this).prop('disabled', true);
            // });
        </script>
        @section('pageJs')
        @show
    </body>

    </html>
@else
    <!DOCTYPE html>
    <html>

    <head>
        <title>Inventory | @yield("title")</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="{{ asset('mdb/css/mdb.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugin/fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugin/datatable/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugin/sweetalert/sweetalert.css') }}">
        <style>
            body {
                background-color: #eee;
            }

            main {
                min-height: 85vh;
            }

            .selected_row {
                background-color: royalblue !important;
                color: #fff;
            }

            .hidden {
                visibility: hidden;
            }

            .dropdown-menu {
                background-color: #93ECD1;
            }

            /* .dropdown-menu li a:hover {
            background-color: #6A1B9A;
            color: #fff;
        } */

        </style>
    </head>

    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Navbar brand -->
                <a class="navbar-brand" href="{{ url('/dashboard') }}">
                    <div class="spinner-border text-light" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    Home
                </a>
                <!-- Toggle button -->
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                    data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left links -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <!-- Navbar dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav_add" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-plus"></i> Add
                            </a>
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu" aria-labelledby="nav_add">
                                <li><a class="dropdown-item" href="{{ route('item.create') }}">Item</a></li>
                                <li><a class="dropdown-item" href="{{ route('unit.index') }}">Item Units</a></li>
                                <li><a class="dropdown-item" href="{{ route('supplier.index') }}">Supplier</a></li>
                                <li><a class="dropdown-item" href="{{ route('customer.index') }}">Customer</a></li>
                                <li><a class="dropdown-item" href="{{ route('currency.index') }}">Currency</a></li>
                                <li><a class="dropdown-item" href="{{ route('stock.index') }}">Stocks</a></li>
                                <li><a class="dropdown-item" href="{{ route('setting.index') }}">Environment
                                        Setup</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav_opening" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-object-group"></i> Opening
                            </a>
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu" aria-labelledby="nav_opening">
                                <li><a class="dropdown-item" href="{{ route('openStock.index') }}">Opening Stock</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('openPayable.index') }}">Opening
                                        Payable</a></li>
                                <li><a class="dropdown-item" href="{{ route('openReceivable.index') }}">Open
                                        Receivable</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav_capital" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="far fa-money-bill-alt"></i> Cash
                            </a>
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu" aria-labelledby="nav_sale">
                                <li><a class="dropdown-item" href="{{ route('cashAccount.index') }}">Cash
                                        Accounts</a></li>
                                <li><a class="dropdown-item" href="{{ route('cash.index') }}">Cash Capital</a></li>
                                <li><a class="dropdown-item" href="{{ route('cashTransfer.index') }}">Cash
                                        Transfer</a></li>
                                <li><a class="dropdown-item" href="{{ url('/accountCash') }}">Check Account</a></li>
                                <li><a class="dropdown-item" href="{{ route('dailyBook.index') }}">Daily Book</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav_purchase" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-cart-arrow-down"></i> Purchase
                            </a>
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu" aria-labelledby="nav_purchase">
                                <li><a class="dropdown-item" href="{{ route('purchase.create') }}">Purchase</a></li>
                                <li><a class="dropdown-item" href="{{ route('purchaseReturn.create') }}">Return</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('payment.index') }}">Payment</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav_sale" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-cart-plus"></i> Sale
                            </a>
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu" aria-labelledby="nav_sale">
                                <li><a class="dropdown-item" href="{{ route('sale.create') }}">Sale</a></li>
                                <li><a class="dropdown-item" href="{{ route('saleReturn.create') }}">Return</a></li>
                                <li><a class="dropdown-item" href="{{ route('received.index') }}">Receipt</a></li>
                                <li><a class="dropdown-item" href="{{ route('estimateSale.create') }}">Estimate
                                        Sale</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav_expense" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-trash"></i> Expenses
                            </a>
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu" aria-labelledby="nav_expense">
                                <li><a class="dropdown-item" href="{{ route('expense.index') }}">Expense</a></li>
                                <li><a class="dropdown-item" href="{{ route('expenseCategory.index') }}">Expense
                                        Category</a>
                                </li>
                                <!-- <li><a class="dropdown-item" href="#">Wastes</a></li> -->
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav_stock" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-university"></i> Stock
                            </a>
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu" aria-labelledby="nav_stock">
                                <li><a class="dropdown-item" href="{{ route('stockTransfer.index') }}">Transfer</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('/currentStock') }}">Current Stock</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav_account" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-users"></i> Accounts
                            </a>
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu" aria-labelledby="nav_account">
                                <li><a class="dropdown-item" href="{{ url('/accountSupplier') }}">Supplier
                                        Account</a></li>
                                <li><a class="dropdown-item" href="{{ url('/accountCustomer') }}">Customer
                                        Account</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav_report" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-file-alt"></i> Report
                            </a>
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu" aria-labelledby="nav_report">
                                <li><a class="dropdown-item" href="{{ url('/report/purchase') }}">Purchase Report</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('/report/purchaseReturn') }}">Purchase
                                        Return
                                        Report</a></li>
                                <li><a class="dropdown-item" href="{{ url('/report/payment') }}">Payment Report</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('/report/sale') }}">Sale Report</a></li>
                                <li><a class="dropdown-item" href="{{ url('/report/saleReturn') }}">Sale Return
                                        Report</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('/report/received') }}">Receipt Report</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('/report/expense') }}">Expense Report</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('/report/cash') }}">Cash Flow Report</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ url('/report/asset') }}">Asset</a></li>
                                <li><a class="dropdown-item" href="{{ url('/report/item') }}">Item Report</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav_setting" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-globe"></i> {{ Auth::user()->language }}
                            </a>

                            <ul class="dropdown-menu" aria-labelledby="nav_setting">
                                <li><a class="dropdown-item" href="{{ route('language', 'English') }}">English</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('language', 'Pashto') }}">Pashto</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <!-- Left links -->

                    <!-- Search form -->
                    <div class="d-flex input-group w-auto text-left" dir="rtl">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                            id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                            <img class="rounded-circle" src="{{ Auth::user()->profile_photo_url }}"
                                alt="{{ Auth::user()->name }}" style="border: 1px solid #f1f1f1;" height="28" />
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ url('/user/profile') }}">Profile</a></li>
                            @if (Auth::user()->user_type == 'Admin')
                                <li><a class="dropdown-item" href="{{ route('user.index') }}">Users</a></li>
                            @endif
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </div>
                </div>
                <!-- Collapsible wrapper -->
            </div>
            <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->


        @section('body')

        @show



        <footer class="bg-light text-center text-lg-start">
            <!-- Copyright -->
            <div class="text-center p-3" style="background-color: rgba(0, 161, 112,0.2);">
                © 2020 Copyright:
                <a class="text-dark" href="https://mtechsh.com/" target="_blank">mtechsh.com</a>
            </div>
            <!-- Copyright -->
        </footer>

        <script src="{{ asset('plugin/jquery3.5.1.js') }}"></script>
        <script src="{{ asset('mdb/js/mdb.min.js') }}"></script>
        <script src="{{ asset('plugin/datatable/datatables.min.js') }}"></script>
        <script src="{{ asset('plugin/fontawesome/js/all.min.js') }}"></script>
        <script src="{{ asset('plugin/sweetalert/sweetalert.min.js') }}"></script>
        <script src="{{ asset('plugin/notify/bootstrap-notify.min.js') }}"></script>

        <script>
            let itemPrimarySprice = 0;
            let itemPrimaryPprice = 0;
            $("input").attr("autocomplete", "off");
            $('.data_table').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copyHtml5',
                        footer: true
                    },
                    {
                        extend: 'excelHtml5',
                        footer: true
                    },
                    {
                        extend: 'pdfHtml5',
                        footer: true
                    },
                    {
                        extend: 'print',
                        footer: 'true',
                        // title: "Title of your print",
                        autoPrint: 'false',
                        customize: function(win) {
                            $(win.document.body)
                                .css({
                                    'font-size': '8pt',
                                    'background-color': 'white'
                                });

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', '14px');
                        }
                    }
                ]
            });



            $(".spinner-border").css("visibility", "hidden");
            $(document).ajaxStart(function() {
                $(".spinner-border").css("visibility", "visible");
            });
            $(document).ajaxComplete(function() {
                $(".spinner-border").css("visibility", "hidden");
            });


            $("form").submit(function() {
                $(":submit").attr("disabled", "disabled");
            });
            $("body").dblclick(function() {
                $(":submit").removeAttr("disabled");
            })

            $('.number').keyup(function() {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            });
            // $(":submit").on('click', function(event) {
            //     $(this).prop('disabled', true);
            // });
        </script>
        @section('pageJs')
        @show
    </body>

    </html>
@endif
