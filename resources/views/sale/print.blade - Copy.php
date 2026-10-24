<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #000;
        }

        .a4 {
            width: 21cm;
            min-height: 29.7cm;
            margin: 0 auto;
            padding: 1cm;
            position: relative;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding-bottom: 150px; /* Space for the footer */
        }

        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th, .table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .text-end {
            text-align: right;
        }

        /* Footer Styles */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #fff;
            padding: 10px;
            text-align: center;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Print-specific styles */
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .footer {
                position: fixed;
                bottom: 0;
            }
        }
    </style>
</head>
<body>
    <div class="a4">
        <!-- Header -->
        <div>
            <img src="{{ asset('2.JPEG') }}" alt="Logo" style="width: 760px; height: 230px;">
        </div>

        <!-- Customer Info -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div style="text-align: left;">
                <strong>Name:</strong> {{ $saleBill->customer->name }}
            </div>
            <div style="text-align: center;">
                <strong>Invoice#:</strong> {{ $saleBill->id }}
            </div>
            <div style="text-align: right;">
                <strong>Date:</strong> {{ $saleBill->date }}
            </div>
        </div>

        <!-- Items Table -->
        <div class="row">
            <div class="col-12">
                <table class="table table-sm" id="tbl_main">
                    <thead class="table-primary">
                        <tr style="color:white;">
                            <th style="background-color:#08A04B;">No#</th>
                            <th style="background-color:#08A04B;">Item Description</th>
                            <th style="background-color:#08A04B;">Details</th>
                            <th style="background-color:#08A04B;">Qty</th>
                            <th style="background-color:#08A04B;">Price</th>
                            <th style="background-color:#08A04B;">Dis %</th>
                            <th style="background-color:#08A04B;">Amount ({{ $saleBill->currency->name }})</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $grandQty = 0;
                        $grandAmount = 0;
                        $grandDiscount = 0;
                        ?>
                        @foreach($sales as $sale)
                        <?php
                        $itemAmount = round(($sale->qty * $sale->price) - ($sale->qty * $sale->price * $sale->discount / 100), 1);
                        $grandQty += $sale->qty;
                        $grandAmount += $itemAmount;
                        $grandDiscount += $sale->qty * $sale->price * $sale->discount / 100;
                        ?>
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sale->item->name }}</td>
                            <td>{{ $sale->item->details }}</td>
                            <td>{{ floatval($sale->qty) }}</td>
                            <td>{{ floatval($sale->price) }}</td>
                            <td>{{ floatval($sale->discount) }}</td>
                            <td>{{ floatval($itemAmount) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-primary">
                        <tr>
                            <th style="background-color:#FFA500;" colspan="3" class="text-center">Grand Quantity</th>
                            <th style="background-color:#FFA500;">{{ floatval($grandQty) }}</th>
                            <th style="background-color:#FFA500;" colspan="2" class="text-center">Total Amount</th>
                            <th style="background-color:#FFA500;">{{ floatval($grandAmount) }}</th>
                        </tr>
                    </tfoot>
                </table>

                <div class="col-5" style="float: right;">
                    <table class="table table-sm">
                        <tr class="summary-row">
                            <td colspan="6" class="text-end"><strong>Total:</strong></td>
                            <td>{{ floatval($grandAmount) }}</td>
                        </tr>
                        <tr class="summary-row">
                            <td colspan="6" class="text-end"><strong>Discount:</strong></td>
                            <td>{{ floatval($grandDiscount) }}</td>
                        </tr>
                        <tr class="summary-row">
                            <td colspan="6" class="text-end"><strong>Paid:</strong></td>
                            <td>{{ floatval($paidAmount) }}</td>
                        </tr>
                        <tr class="summary-row">
                            <td colspan="6" class="text-end"><strong>Balance:</strong></td>
                            <td>{{ floatval($grandAmount - $paidAmount) }}</td>
                        </tr>
                        <tr class="summary-row">
                            <td colspan="6" class="text-end"><strong>Previous Balance:</strong></td>
                            <td>{{ floatval($totBalance - ($grandAmount - $paidAmount)) }}</td>
                        </tr>
                        <tr class="summary-row">
                            <td style="color: white; background-color: #FFA500;" colspan="6" class="text-end"><strong>Total Balance:</strong></td>
                            <td style="color: white; background-color: #FFA500;">{{ floatval($totBalance) }}</td>
                        </tr>
                    </table>
                </div>
                

                <p>Note: {{ $saleBill->details }}</p>

                <div class="col-7">
                    <!-- WhatsApp Icon with Number -->
                    <i class="fab fa-whatsapp" style="color: #08A04B; font-size: 12px; margin-right: 10px;"></i>
                    <span>072 888 6888</span><br>
                    <!-- Telephone Icon with Number -->
                    <i class="fas fa-phone-alt" style="color: #08A04B; font-size: 12px; margin-right: 10px;"></i>
                    <span>+93602002280</span><br>
                    <!-- Email Icon with Email Address -->
                    <i class="fas fa-envelope" style="color:rgb(16, 17, 18); font-size: 12px; margin-right: 10px;"></i>
                    <span>momand@hayatrokhan.com</span><br>
                    <!-- Address Icon with Address -->
                    <i class="fas fa-map-marker-alt" style="color:rgb(24, 6, 6); font-size: 12px; margin-right: 10px;"></i>
                    <span style="font-size: 13px;">Dand Ghara Shah Mahmood Market 2nd Floor Jalalabad Afghanistan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <div class="footer">
        <img src="{{ asset('1.JPEG') }}" alt="Logo" style="width: 790px; height: 124px;">
    </div>
</body>
</html>
