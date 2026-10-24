<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Invoice #{{ $saleBill->id }}</title>

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    >

    <style>

        /* =====================================================
           GLOBAL
        ===================================================== */

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            background: #EDEFF1;
            font-family: Arial, Helvetica, sans-serif;
            color: #222;
        }

        @page {
            size: A4;
            margin: 0;
        }


        /* =====================================================
           COLORS
        ===================================================== */

        :root {
            --green: #082ba0;
            --dark-green: #0a086b;
            --orange: #F5A623;
            --light-green: #F1FAF5;
            --border: #D8DEE3;
            --text: #222222;
            --muted: #6B7280;
        }


        /* =====================================================
           PRINT BUTTON
        ===================================================== */

        .print-area {
            width: 210mm;
            margin: 15px auto 10px;
            text-align: right;
        }

        .print-btn {
            background: #082ba0;
            color: #ffffff;
            border: none;
            border-radius: 5px;

            padding: 10px 18px;

            font-size: 14px;
            font-weight: bold;

            cursor: pointer;
        }

        .print-btn:hover {
            background: #0a086b;
        }


        /* =====================================================
           A4 PAGE
        ===================================================== */

        .a4 {
            width: 210mm;
            min-height: 297mm;

            margin: 0 auto 20px;

            /*
             * Left = 11mm
             * Right = 11mm
             *
             * Available content width:
             *
             * 210mm - 11mm - 11mm = 188mm
             */

            padding: 10mm 11mm 28mm;

            background: #ffffff;

            position: relative;

            box-shadow: 0 3px 20px rgba(0, 0, 0, 0.12);

            overflow: visible;
        }


        /* =====================================================
           HEADER
        ===================================================== */

        .header {
            width: 100%;
            margin-bottom: 4px;
        }


        /*
         * CONTROL YOUR LOGO SIZE HERE
         *
         * A4 content width = 188mm
         *
         * Change height as you like:
         *
         * 40mm = short
         * 50mm = normal
         * 60mm = large
         */

        .invoice-logo {
            display: block;

            width: 188mm;
            height: 50mm;

            max-width: none;
            max-height: none;

            object-fit: fill;
        }


        /* =====================================================
           BRAND LINE
        ===================================================== */

        .brand-line {
            width: 100%;

            height: 2px;

            margin-top: 2px;

            background: linear-gradient(
                90deg,
                var(--green) 0%,
                var(--green) 70%,
                var(--orange) 70%,
                var(--orange) 100%
            );
        }


        /* =====================================================
           CUSTOMER / INVOICE INFORMATION
        ===================================================== */

        .compact-info {
            display: flex;

            flex-wrap: wrap;

            justify-content: space-between;

            align-items: center;

            gap: 6px 12px;

            width: 100%;

            padding: 5px 10px;

            margin-bottom: 8px;

            background: #f8fafc;

            border: 1px solid var(--border);

            border-radius: 4px;

            font-size: 13px;
        }

        .info-piece {
            display: inline-flex;

            align-items: baseline;

            gap: 4px;

            white-space: nowrap;
        }

        .info-piece strong {
            color: var(--muted);

            font-size: 12px;

            font-weight: 700;

            text-transform: uppercase;

            letter-spacing: 0.3px;
        }

        .info-piece span {
            color: var(--text);

            font-weight: 700;
        }


        /* =====================================================
           ITEMS TABLE
        ===================================================== */

        .items-table {
            width: 100%;

            border-collapse: collapse;

            margin-top: 5px;

            page-break-inside: auto;
        }

        .items-table thead {
            display: table-header-group;
        }

        .items-table tbody tr {
            page-break-inside: avoid;

            page-break-after: auto;
        }

        .items-table th {
            background: var(--green);

            color: #ffffff;

            border: 1px solid var(--green);

            padding: 6px 4px;

            font-size: 12px;

            font-weight: bold;

            text-align: center;

            text-transform: uppercase;
        }

        .items-table td {
            border: 1px solid var(--border);

            padding: 5px 4px;

            font-size: 12px;

            vertical-align: middle;
        }

        .items-table tbody tr:nth-child(even) {
            background: #FAFCFB;
        }

        .items-table td:first-child {
            text-align: center;

            font-weight: bold;

            color: var(--green);
        }

        .items-table td:nth-child(4),
        .items-table td:nth-child(5),
        .items-table td:nth-child(6),
        .items-table td:nth-child(7) {
            text-align: right;

            white-space: nowrap;
        }


        /* =====================================================
           GRAND TOTAL
        ===================================================== */

        .grand-total th,
        .grand-total td {
            background: var(--orange);

            color: #ffffff;

            border-color: var(--orange);

            padding: 6px 4px;

            font-weight: bold;
        }

        .center {
            text-align: center !important;
        }


        /* =====================================================
           LOWER SECTION
        ===================================================== */

        .lower-section {
            display: grid;

            grid-template-columns: 1fr 0.95fr;

            gap: 14px;

            margin-top: 12px;

            page-break-inside: avoid;
        }


        /* =====================================================
           NOTE
        ===================================================== */

        .note-box {
            min-height: 55px;

            padding: 8px 10px;

            background: var(--light-green);

            border: 1px solid var(--border);

            border-left: 4px solid var(--green);

            page-break-inside: avoid;
        }

        .note-title {
            color: var(--green);

            font-size: 13px;

            font-weight: bold;

            text-transform: uppercase;

            margin-bottom: 4px;
        }

        .note-text {
            font-size: 13px;

            line-height: 1.4;

            word-wrap: break-word;

            overflow-wrap: anywhere;
        }


        /* =====================================================
           SUMMARY
        ===================================================== */

        .summary-table {
            width: 100%;

            border-collapse: collapse;

            page-break-inside: avoid;
        }

        .summary-table td {
            border: 1px solid var(--border);

            padding: 5px 7px;

            font-size: 13px;
        }

        .summary-table td:first-child {
            width: 65%;

            text-align: right;

            font-weight: bold;

            color: #555555;
        }

        .summary-table td:last-child {
            text-align: right;

            font-weight: bold;

            white-space: nowrap;
        }

        .summary-table tr:nth-child(even) {
            background: #FAFAFA;
        }

        .total-balance td {
            background: var(--orange) !important;

            color: #ffffff !important;

            border-color: var(--orange) !important;

            font-size: 13px !important;

            font-weight: bold !important;
        }


        /* =====================================================
           CONTACT
        ===================================================== */

        .contact-box {
            margin-top: 10px;

            padding: 7px 10px;

            background: var(--light-green);

            border: 1px solid #D5EBDD;

            border-radius: 4px;

            page-break-inside: avoid;
        }

        .contact-title {
            color: var(--green);

            font-size: 13px;

            font-weight: bold;

            text-transform: uppercase;

            margin-bottom: 4px;
        }

        .contact-row {
            display: flex;

            align-items: flex-start;

            margin: 4px 0;

            font-size: 12px;

            line-height: 1.4;
        }

        .contact-row i {
            width: 18px;

            flex: 0 0 18px;

            color: var(--green);

            font-size: 11px;

            margin-right: 4px;

            text-align: center;
        }

        .contact-row span {
            flex: 1;
        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .footer {
            position: absolute;

            left: 11mm;

            right: 11mm;

            bottom: 6mm;

            text-align: center;
        }

        .footer-line {
            width: 100%;

            height: 3px;

            margin-bottom: 4px;

            background: linear-gradient(
                90deg,
                var(--green) 0%,
                var(--green) 72%,
                var(--orange) 72%,
                var(--orange) 100%
            );
        }

        .footer .contact-row {
            justify-content: center;

            margin: 0;

            font-size: 11px;
        }

        .footer .contact-row i {
            width: auto;

            flex: none;
        }


        /* =====================================================
           PRINT
        ===================================================== */

        @media print {

            @page {
                size: A4;
                margin: 0;
            }


            html {
                width: 210mm;

                margin: 0 !important;
                padding: 0 !important;

                background: #ffffff !important;
            }


            body {
                width: 210mm;

                margin: 0 !important;
                padding: 0 !important;

                background: #ffffff !important;

                color: #000000 !important;

                overflow: visible !important;

                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }


            /* Hide print button */

            .no-print {
                display: none !important;
            }


            /* =================================================
               A4 PRINT PAGE
            ================================================= */

            .a4 {
                width: 210mm !important;

                min-height: 297mm !important;

                margin: 0 !important;

                padding: 10mm 11mm 28mm !important;

                background: #ffffff !important;

                box-shadow: none !important;

                overflow: visible !important;

                position: relative !important;
            }


            /* =================================================
               LOGO
            ================================================= */

            /*
             * IMPORTANT:
             *
             * Do NOT use:
             *
             * width: 100%;
             * max-height: 45mm;
             *
             * here because that would override
             * your custom logo size.
             */

            .invoice-logo {
                display: block !important;

                width: 188mm !important;

                height: 50mm !important;

                max-width: none !important;

                max-height: none !important;

                object-fit: fill !important;
            }


            /* =================================================
               CUSTOMER INFO
            ================================================= */

            .compact-info {
                display: flex !important;

                background: #f8fafc !important;

                -webkit-print-color-adjust: exact !important;

                print-color-adjust: exact !important;
            }


            /* =================================================
               ITEMS TABLE
            ================================================= */

            .items-table {
                width: 100% !important;

                border-collapse: collapse !important;

                page-break-inside: auto !important;
            }

            .items-table thead {
                display: table-header-group !important;
            }

            .items-table tbody tr {
                page-break-inside: avoid !important;
            }


            /* =================================================
               PRINT COLORS
            ================================================= */

            .items-table th,
            .grand-total th,
            .grand-total td,
            .total-balance td {
                -webkit-print-color-adjust: exact !important;

                print-color-adjust: exact !important;
            }


            /* =================================================
               LOWER SECTION
            ================================================= */

            .lower-section {
                page-break-inside: avoid !important;
            }

            .note-box,
            .contact-box,
            .summary-table {
                page-break-inside: avoid !important;
            }


            /* =================================================
               FOOTER
            ================================================= */

            .footer {
                position: absolute !important;

                left: 11mm !important;

                right: 11mm !important;

                bottom: 6mm !important;
            }

        }


        /* =====================================================
           MOBILE
        ===================================================== */

        @media screen and (max-width: 800px) {

            body {
                background: #ffffff;
            }


            .print-area {
                width: 100%;

                padding: 10px 12px;

                margin: 0;

                text-align: right;
            }


            .a4 {
                width: 100%;

                min-height: auto;

                margin: 0;

                padding: 12px;

                box-shadow: none;
            }


            .invoice-logo {
                width: 100%;

                height: auto;

                max-width: 100%;
            }


            .compact-info {
                flex-direction: column;

                align-items: stretch;

                gap: 4px;
            }


            .lower-section {
                grid-template-columns: 1fr;
            }


            .footer {
                position: relative;

                left: auto;

                right: auto;

                bottom: auto;

                margin-top: 20px;
            }

        }

    </style>

</head>


<body>


    <!-- =====================================================
         PRINT BUTTON
    ====================================================== -->

    <div class="print-area no-print">

        <button
            type="button"
            class="print-btn"
            onclick="printInvoice()">

            <i class="fas fa-print"></i>

            Print Invoice

        </button>

    </div>


    <!-- =====================================================
         A4 INVOICE
    ====================================================== -->

    <div class="a4">


        <!-- =================================================
             HEADER / LOGO
        ================================================== -->

        <div class="header">

            <img
                src="{{ asset('2.png') }}"
                alt="Logo"
                class="invoice-logo"
            >

            <div class="brand-line"></div>

        </div>


        <!-- =================================================
             CUSTOMER / INVOICE INFO
        ================================================== -->

        <div class="compact-info">


            <div class="info-piece">

                <strong>
                    Customer
                </strong>

                <span>
                    {{ $saleBill->customer->name }}
                </span>

            </div>


            <div class="info-piece">

                <strong>
                    Invoice #
                </strong>

                <span>
                    {{ $saleBill->id }}
                </span>

            </div>


            <div class="info-piece">

                <strong>
                    Date
                </strong>

                <span>
                    {{ $saleBill->date }}
                </span>

            </div>


        </div>


        <!-- =================================================
             ITEMS TABLE
        ================================================== -->

        <table class="items-table">

            <thead>

                <tr>

                    <th>
                        No.
                    </th>

                    <th>
                        Item Description
                    </th>

                    <th>
                        Details
                    </th>

                    <th>
                        Qty
                    </th>

                    <th>
                        Price
                    </th>

                    <th>
                        Dis %
                    </th>

                    <th>
                        Amount
                        ({{ $saleBill->currency->name }})
                    </th>

                </tr>

            </thead>


            <tbody>

                @php

                    $grandQty = 0;

                    $grandAmount = 0;

                    $grandDiscount = 0;

                @endphp


                @foreach($sales as $sale)


                    @php

                        $itemAmount = round(
                            ($sale->qty * $sale->price)
                            -
                            (
                                $sale->qty
                                * $sale->price
                                * $sale->discount
                                / 100
                            ),
                            1
                        );

                        $grandQty += $sale->qty;

                        $grandAmount += $itemAmount;

                        $grandDiscount +=
                            $sale->qty
                            * $sale->price
                            * $sale->discount
                            / 100;

                    @endphp


                    <tr>


                        <td>
                            {{ $loop->iteration }}
                        </td>


                        <td>

                            <strong>
                                {{ $sale->item->name }}
                            </strong>

                        </td>


                        <td>
                            {{ $sale->item->details }}
                        </td>


                        <td>
                            {{ floatval($sale->qty) }}
                        </td>


                        <td>
                            {{ floatval($sale->price) }}
                        </td>


                        <td>
                            {{ floatval($sale->discount) }}
                        </td>


                        <td>

                            <strong>
                                {{ floatval($itemAmount) }}
                            </strong>

                        </td>


                    </tr>


                @endforeach


            </tbody>


            <tfoot>

                <tr class="grand-total">


                    <th
                        colspan="3"
                        class="center">

                        Grand Quantity

                    </th>


                    <th>

                        {{ floatval($grandQty) }}

                    </th>


                    <th
                        colspan="2"
                        class="center">

                        Total Amount

                    </th>


                    <th>

                        {{ floatval($grandAmount) }}

                    </th>


                </tr>

            </tfoot>


        </table>


        <!-- =================================================
             LOWER SECTION
        ================================================== -->

        <div class="lower-section">


            <!-- =================================================
                 LEFT
            ================================================== -->

            <div>


                <!-- NOTE -->

                <div class="note-box">

                    <div class="note-title">

                        <i class="fas fa-sticky-note"></i>

                        Note

                    </div>


                    <div class="note-text">

                        {{ $saleBill->details }}

                    </div>

                </div>


                <!-- CONTACT -->

                <div class="contact-box">

                    <div class="contact-title">

                        Contact Information

                    </div>


                    <div class="contact-row">

                        <i class="fab fa-whatsapp"></i>

                        <span>
                            074 924 5003
                        </span>

                    </div>


                    <div class="contact-row">

                        <i class="fas fa-envelope"></i>

                        <span>
                            shamshadkhpalwak27@gmail.com
                        </span>

                    </div>


                    <div class="contact-row">

                        <i class="fas fa-map-marker-alt"></i>

                        <span>
                            بیز اکمالاتی ،فیصل حتیځ زون سبزی منډوی دواحانو راسته
                        </span>

                    </div>


                </div>


            </div>


            <!-- =================================================
                 RIGHT / SUMMARY
            ================================================== -->

            <div>

                <table class="summary-table">


                    <tr>

                        <td>
                            Total:
                        </td>

                        <td>
                            {{ floatval($grandAmount) }}
                        </td>

                    </tr>


                    <tr>

                        <td>
                            Discount:
                        </td>

                        <td>
                            {{ floatval($grandDiscount) }}
                        </td>

                    </tr>


                    <tr>

                        <td>
                            Paid:
                        </td>

                        <td>
                            {{ floatval($paidAmount) }}
                        </td>

                    </tr>


                    <tr>

                        <td>
                            Balance:
                        </td>

                        <td>
                            {{ floatval($grandAmount - $paidAmount) }}
                        </td>

                    </tr>


                    <tr>

                        <td>
                            Previous Balance:
                        </td>

                        <td>

                            {{
                                floatval(
                                    $totBalance
                                    - ($grandAmount - $paidAmount)
                                )
                            }}

                        </td>

                    </tr>


                    <tr class="total-balance">

                        <td>
                            Total Balance:
                        </td>

                        <td>
                            {{ floatval($totBalance) }}
                        </td>

                    </tr>


                </table>

            </div>


        </div>


        <!-- =================================================
             FOOTER
        ================================================== -->

        <div class="footer">

            <div class="footer-line"></div>


            <div class="contact-row">

                <i class="fas fa-map-marker-alt"></i>

                <span>
                    بیز اکمالاتی ،فیصل حتیځ زون سبزی منډوی دواحانو راسته
                </span>

            </div>

        </div>


    </div>


    <!-- =====================================================
         PRINT JAVASCRIPT
    ====================================================== -->

    <script>

        function printInvoice() {

            setTimeout(function () {

                window.focus();

                window.print();

            }, 300);

        }


        window.addEventListener('afterprint', function () {

            console.log('Print dialog closed.');

        });

    </script>


</body>
</html>
