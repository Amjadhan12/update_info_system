@if (Auth::user()->language == 'Pashto')
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


        <div class="col text-left" dir="ltr">
            <h2 class="text-center bold_heading">{{ $setting->title_en }}</h2><br>
            <h5 class="text-left" dir="ltr">
                Estimate No:
                <b><span class="px-3 bolder">{{ $saleBill->id }}</span></b><br>
                Customer:
                <span class="px-2 bolder">{{ $saleBill->customer->name }}</span><br>
                Customer info:
                <span class="px-3">{{ $saleBill->customer->details }}</span><br>

            </h5>
            <p> </p>
        </div>
        <div class="col text-center">
            @if ($setting->image_path)
                <img src="{{ $setting->imagePath() }}" height="90">
            @endif
            <p>
                <br>
                Phone: {{ $setting->phone1 }}<br />
                Address: {{ $setting->address }}<br />
            </p>
        </div>
        <div class="col text-right">
            <h2 class="text-center bold_heading">{{ $setting->title_pa }}</h2><br>
            <h5>
                Date:
                <span class="px-3">{{ $saleBill->date }}</span><br>
                Time:
                <span class="px-3">{{ date('h:i:s') }}</span><br>

            </h5>
            <p> </p>
        </div>

    </div>
    <div class="row">
        <div class="col-12">
            <table class="tbl_bordered">
                <thead>
                    <tr>
                        <th width="100">شماره</th>
                        <th>جنس</th>
                        <th width="100">تعداد</th>
                        <th width="100">قیمت</th>
                        <th width="100">تخفیف %</th>
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
                        $grandQty += $sale->qty;
                        $grandAmount += $sale->qty * $sale->price - ($sale->qty * $sale->price * $sale->discount) / 100;
                        ?>
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sale->item->name }}</td>
                            <td>{{ $sale->qty }}</td>
                            <td>{{ $sale->price }}</td>
                            <td>{{ $sale->discount }}</td>
                            <td>{{ $sale->qty * $sale->price - ($sale->qty * $sale->price * $sale->discount) / 100 }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
            <table class="tbl_foot">
                <tr>
                    <th width="100">مجموعه:</th>
                    <th></th>
                    <th width="100">{{ $grandQty }}</th>
                    <th width="100"></th>
                    <th width="100"></th>
                    <th width="180"><?= $grandAmount ?></th>
                </tr>
            </table>
        </div>

        <div class="col-8">
            <p class="text-muted">{{ $saleBill->details }}</p>
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


        <div class="col text-left" dir="ltr">
            <h2 class="text-center bold_heading">{{ $setting->title_en }}</h2><br>
            <h5 class="text-left" dir="ltr">
                Estimate No:
                <b><span class="px-3 bolder">{{ $saleBill->id }}</span></b><br>
                Customer:
                <span class="px-2 bolder">{{ $saleBill->customer->name }}</span><br>
                Customer info:
                <span class="px-3">{{ $saleBill->customer->details }}</span><br>

            </h5>
            <p> </p>
        </div>
        <div class="col text-center">
            <img src="{{ $setting->imagePath() }}" height="90">
            <p>
                <br>
                Phone: {{ $setting->phone1 }}<br />
                Address: {{ $setting->address }}<br />
            </p>
        </div>
        <div class="col text-right">
            <h2 class="text-center bold_heading">{{ $setting->title_pa }}</h2><br>
            <h5>
                Date:
                <span class="px-3">{{ $saleBill->date }}</span><br>
                Time:
                <span class="px-3">{{ date('h:i:s') }}</span><br>

            </h5>
            <p> </p>
        </div>

    </div>
    <div class="row">
        <div class="col-12">
            <table class="tbl_bordered">
                <thead>
                    <tr>
                        <th width="100">SN.No</th>
                        <th>Item Desc</th>
                        <th width="100">Qty</th>
                        <th width="100">S.Price</th>
                        <th width="100">Dis %</th>
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
                        $grandQty += $sale->qty;
                        $grandAmount += $sale->qty * $sale->price - ($sale->qty * $sale->price * $sale->discount) / 100;
                        ?>
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sale->item->name }}</td>
                            <td>{{ $sale->qty }}</td>
                            <td>{{ $sale->price }}</td>
                            <td>{{ $sale->discount }}</td>
                            <td>{{ $sale->qty * $sale->price - ($sale->qty * $sale->price * $sale->discount) / 100 }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
            <table class="tbl_foot">
                <tr>
                    <th width="100">Grand:</th>
                    <th></th>
                    <th width="100">{{ $grandQty }}</th>
                    <th width="100"></th>
                    <th width="100"></th>
                    <th width="180"><?= $grandAmount ?></th>
                </tr>
            </table>
        </div>

        <div class="col-8">
            <p class="text-muted">{{ $saleBill->details }}</p>
        </div>
    </div>
@endif
