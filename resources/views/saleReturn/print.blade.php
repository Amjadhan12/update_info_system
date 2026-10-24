@if (Auth::user()->language == 'Pashto')
    <style>
        .print_div {
            width: 276mm;
            padding: 10px 0px;
            position: relative;
            direction: ltr;
            margin-top: -15px;
            color: black;
            direction: rtl;
        }


        .brdr {
            border: double 3px black;
        }

        .tbl_bordered {
            width: 100%;
        }

        .tbl_bordered th,
        .tbl_bordered td {
            text-align: center;
            border: double 3px black;
            padding: 8px;
            font-size: 18px;
        }

        .tbl_foot {
            margin-top: 6px;
            width: 100%;
        }

        .tbl_foot tr {
            text-align: center;
            border: double 3px black;

        }

        .tbl_foot tr th {
            padding: 8px;
            font-size: 24px;
            font-weight: bold;
        }

        th {
            font-weight: bolder;
        }

        .bolder {
            font-size: 1.1em;
            font-weight: bolder;
        }

        .bold_heading {
            font-weight: bolder;
            font-size: 30px;
        }



        @media print {
            * {
                color: #000;
            }
        }

    </style>

    <div class="row">
        <div class="col-12 text-center">
            {{-- <h2 class="text-center bold_heading">{{ $setting->title_en }}</h2> --}}
            <h1 class="text-center bold_heading">{{ $setting->title_pa }}</h1>
        </div>
        <div class="col-3 text-left" dir="ltr">
            <h5>
                <span class="px-3">{{ $setting->phone2 }}</span><br>
            </h5>
        </div>
        <div class="col-6 text-center">
            <h4>نماینده ګی هر نوع پرزه جات، جاپانی، چنایی، پاکستانی، تایوانی فلټر، ګارډ موجود است</h4>
        </div>
        <div class="col-3 text-center">
            <h5>
                <span class="px-3">{{ $setting->phone1 }}</span><br>
            </h5>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="mb-3 w-100">
                <tr>
                    <th colspan="4" class="text-center"><b class="bolder">ادرس: {{ $setting->address }}</b>
                    </th>
                </tr>
                <tr>
                    <th>
                        واپسي نمبر: <b><span class="px-3 bolder">{{ $saleBill->id }}</span></b>
                    </th>
                    <th>
                        نوم:<span class="px-2 bolder">{{ $saleBill->customer->name }}</span>
                    </th>
                    <th>
                        نیټه:<span class="px-2 bolder">{{ $saleBill->date }}</span>
                    </th>
                    <th>
                        وخت:<span class="px-2 bolder">{{ date('h:i:s') }}</span>
                    </th>
                </tr>
            </table>
            <table class="tbl_bordered">
                <thead>
                    <tr>
                        <th width="100">شماره</th>
                        <th>جنس</th>
                        <th width="100">تعداد</th>
                        <th width="100">واحد</th>
                        <th width="100">قیمت</th>
                        <th width="180">مجموعه ({{ $saleBill->currency->name }})</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $grandQty = 0;
                    $grandAmount = 0;
                    ?>
                    @foreach ($sales as $sale)
                        <?php
                        $grandQty += $sale->qty / $sale->unit_size;
                        $grandAmount += $sale->qty * $sale->price - ($sale->qty * $sale->price * $sale->discount) / 100;
                        ?>
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sale->item->name }}</td>
                            <td>{{ $sale->qty / $sale->unit_size }}</td>
                            <td>{{ $sale->unit->name . ' X ' . $sale->unit_size }}</td>
                            <td>{{ $sale->price * $sale->unit_size }}</td>
                            <td>{{ $sale->qty * $sale->price }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
            <table class="tbl_foot">
                <tr>
                    <th width="100">مجموعه:</th>
                    <th></th>
                    <th>{{ $grandQty }}</th>
                    <th width="100"></th>
                    <th width="100"></th>
                    <th width="180"><?= $grandAmount ?></th>
                </tr>
            </table>
        </div>

        <div class="col-8">
            {{-- <p class="text-muted">{{ $setting->bill_text }}</p> --}}
            <p class="text-muted">{{ $saleBill->details }}</p>
        </div>
        <div class="col-4">

        </div>
    </div>
@else
    <style>
        .print_div {
            width: 276mm;
            padding: 10px 0px;
            position: relative;
            direction: ltr;
            margin-top: -15px;
            color: black;
        }


        .brdr {
            border: double 3px black;
        }

        .tbl_bordered {
            width: 100%;
        }

        .tbl_bordered th,
        .tbl_bordered td {
            text-align: center;
            border: double 3px black;
            padding: 8px;
            font-size: 18px;
        }

        .tbl_foot {
            margin-top: 6px;
            width: 100%;
        }

        .tbl_foot tr {
            text-align: center;
            border: double 3px black;

        }

        .tbl_foot tr th {
            padding: 8px;
            font-size: 24px;
            font-weight: bold;
        }

        th {
            font-weight: bolder;
        }

        .bolder {
            font-size: 1.1em;
            font-weight: bolder;
        }

        .bold_heading {
            font-weight: bolder;
            font-size: 30px;
        }



        @media print {
            * {
                color: #000;
            }
        }

    </style>


    <div class="row">

        <div class="col-12 text-center">
            <h2 class="text-center bold_heading">{{ $setting->title_en }}</h2>
            {{-- <h2 class="text-center bold_heading">{{ $setting->title_pa }}</h2> --}}
        </div>
        <div class="col-3 text-left" dir="ltr">
            <h5>
                <span class="px-3">{{ $setting->phone2 }}</span><br>
            </h5>
        </div>
        <div class="col-6 text-center">
            <h5>{{ $setting->address }}</h5>
        </div>
        <div class="col-3 text-center">
            <h5>
                <span class="px-3">{{ $setting->phone1 }}</span><br>
            </h5>
        </div>

    </div>
    <div class="row">
        <div class="col-12">
            <table class="mb-3 w-100">
                <tr>
                    <th>
                        Number: <b><span class="px-3 bolder">{{ $saleBill->id }}</span></b>
                    </th>
                    <th>
                        Customer:<span class="px-2 bolder">{{ $saleBill->customer->name }}</span>
                    </th>
                    <th>
                        Date:<span class="px-2 bolder">{{ $saleBill->date }}</span>
                    </th>
                    <th>
                        Time:<span class="px-2 bolder">{{ date('h:i:s') }}</span>
                    </th>
                </tr>
            </table>
            <table class="tbl_bordered">
                <thead>
                    <tr>
                        <th width="100">SN.No</th>
                        <th>Item Desc</th>
                        <th width="100">Qty</th>
                        <th width="100">َUnit</th>
                        <th width="100">S.Price</th>
                        <th width="180">Amount ({{ $saleBill->currency->name }})</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $grandQty = 0;
                    $grandAmount = 0;
                    ?>
                    @foreach ($sales as $sale)
                        <?php
                        $grandQty += $sale->qty / $sale->unit_size;
                        $grandAmount += $sale->qty * $sale->price - ($sale->qty * $sale->price * $sale->discount) / 100;
                        ?>
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sale->item->name }}</td>
                            <td>{{ $sale->qty / $sale->unit_size }}</td>
                            <td>{{ $sale->unit->name . ' X ' . $sale->unit_size }}</td>
                            <td>{{ $sale->price * $sale->unit_size }}</td>td>
                            <td>{{ $sale->qty * $sale->price }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
            <table class="tbl_foot">
                <tr>
                    <th width="100">Grand:</th>
                    <th></th>
                    <th>{{ $grandQty }}</th>
                    <th width="100"></th>
                    <th width="100"></th>
                    <th width="180"><?= $grandAmount ?></th>
                </tr>
            </table>
        </div>

        <div class="col-8">
            {{-- <p class="text-muted">{{ $setting->bill_text }}</p> --}}
            <p class="text-muted">{{ $saleBill->details }}</p>
        </div>
        <div class="col-4">

        </div>
    </div>

@endif
