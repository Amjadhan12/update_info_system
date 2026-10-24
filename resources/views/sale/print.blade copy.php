<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .a4 {
            min-height: 20cm;
            position: relative;
            padding: 1cm;
            overflow: hidden; /* Ensure content doesn't overflow */
        }

        .inner {
            background-color: transparent !important;
            opacity: 0.9;
            position: relative;
            z-index: 1;
            padding: 0; /* Ensure no extra padding */
        }

        .bg {
            background-color: blue;
            color: #fff;
            padding: 4px;
            border-radius: 5px;
        }

        .bold {
            font-weight: bold;
        }

        /* Ensure table rows and cells are fully transparent */
        #tbl_main td, #tbl_main th {
            color: black !important;
            background-color: transparent !important; /* Make cells fully transparent */
            border: none; /* Remove borders */
        }

        #tbl_main th {
            font-weight: bold;
            font-size: 18px;
            background-color: transparent !important; /* Make headers fully transparent */
        }

        #tbl_main tr {
            background-color: transparent !important; /* Make rows fully transparent */
        }

        #footer {
            margin-top: 20px;
        }

        .a4 * {
            color: #000;
        }

        /* Watermark styling */
        .watermark {
            position: fixed; /* Fixed for print and always visible */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1000; /* Ensure it is behind all content */
            background-image: url("logo.png"); /* Update this path */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.1;
        }

        @media print {
            .watermark {
                position: fixed; /* Fix the watermark in position for printing */
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1000; /* Ensure it is behind all content */
                background-size: cover; /* Ensure it covers the area */
                background-repeat: no-repeat;
                background-position: center;
                opacity: 0.1;
            }

            .inner, #footer {
                position: relative;
                z-index: 1; /* Ensure they are on top of watermark */
            }

            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="a4">
        <!-- Watermark -->
        <div class="watermark"></div>
        
        <div class="inner">
            <div class="row">
                <div class="col-12 text-center">
                    <img src="{{$setting->imagePath()}}" height="110" alt="Logo"> <!-- Update this path -->
                    <h3 class="bold text-center" style='color:#000;'>{{$setting->title_en}} __ {{$setting->title_pa}}</h3>
                </div>
                <div class="col-12 mb-2">
                    <div class="bg bold d-flex">
                        <div class="me-auto">
                            <h3 class="text-left text-white">Invoice# {{$saleBill->id}}</h3>
                        </div>
                        <div class="justify-content-end">
                            <h3 class="text-end text-white">Date: {{$saleBill->date}}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-5 px-3">
                    <h4 class="bold text-center" style='color:#000;'>Customer Info</h4>
                    <table class="">
                        <tbody style='color:#000;'>
                        <tr>
                            <th>Name</th>
                            <td>{{$saleBill->customer->name}}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{$saleBill->customer->phone}}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{$saleBill->customer->address}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-7 px-4">
                    <p class="text-end" style='color:#000;'><h5>Exclusive Distributer of Turkish and Holland Companies in Afghanistan</h5></p>
                    <p class="text-end" dir="rtl" style='color:#000;'><h5>په افغانستان کې د هالندی او ترکي کمپنۍ انحصاري نماینده ګي</h5></p>
                </div>
                <div class="col-12">
                    <table class="table table-sm" id="tbl_main">
                        <thead class="table-primary">
                            <tr style='color:blue;'>
                                <th>No#</th>
                                <th>Item Description</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Dis %</th>
                                <th>Amount ({{ $saleBill->currency->name }})</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $grandQty = 0;
                            $grandAmount = 0;
                            $grandDiscount = 0; // Initialize this variable for discount
                            ?>
                            @foreach($sales as $sale)
                            <?php
                            $itemAmount = round(($sale->qty * $sale->price) - ($sale->qty * $sale->price * $sale->discount / 100), 1);
                            $grandQty += $sale->qty;
                            $grandAmount += $itemAmount;
                            $grandDiscount += $sale->qty * $sale->price * $sale->discount / 100; // Calculate total discount
                            ?>
                            <tr>
                                <td style='color:#000;'>{{$loop->iteration}}</td>
                                <td style='color:#000;'>{{$sale->item->name}}</td>
                                <td style='color:#000;'>{{$sale->qty}}</td>
                                <td style='color:#000;'>{{$sale->price}}</td>
                                <td style='color:#000;'>{{$sale->discount}}</td>
                                <td style='color:#000;'>{{$itemAmount}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-primary">
                            <tr>
                                <th colspan="5" class="text-center">Total</th>
                                <th>{{$grandQty}}</th>
                                <th>{{$grandAmount}}</th>
                            </tr>
                            
                        </tfoot>
                        
                    </table>
                  
                </div>
            </div>
            
        </div>
        
        <!-- Footer -->
        <div id="footer">
            <div class="row">
                <div class="col-7">
                    <table class="">
                    
                        <tbody>
                            
                        <h3>Note: {{$saleBill->details}}</h3>
                            <!-- <tr>
                                <th>Azizi Bank USD</th>
                                <td>007701203168087</td>
                            </tr>
                            <tr>
                                <th>Ghazanfar Bank ID USD</th>
                                <td>10805634</td>
                            </tr> -->
                        </tbody>
                        
                    </table>
                   
                    
                </div>
              
                <div class="col-5">
                    <table class="table table-sm">
                    <tr class="summary-row">
                                <td colspan="6" class="text-end"><strong>Total:</strong></td>
                                <td>{{ round($grandAmount, 2) }}</td>
                            </tr>
                            <tr class="summary-row">
                                <td colspan="6" class="text-end"><strong>Discount:</strong></td>
                                <td>{{ round($grandDiscount, 2) }}</td>
                            </tr>
                            <tr class="summary-row">
                                <td colspan="6" class="text-end"><strong>Paid:</strong></td>
                                <td>{{ round($paidAmount, 2) }}</td>
                            </tr>
                            <tr class="summary-row">
                                <td colspan="6" class="text-end"><strong>Balance:</strong></td>
                                <td>{{ round($grandAmount - $paidAmount, 2) }}</td>
                            </tr>
                            <tr class="summary-row">
                                <td colspan="6" class="text-end"><strong>Previous Balance:</strong></td>
                                <td>{{ round($totBalance - ($grandAmount - $paidAmount), 2) }}</td>
                            </tr>
                            <tr class="summary-row">
                                <td colspan="6" class="text-end"><strong>Total Balance:</strong></td>
                                <td>{{ round($totBalance, 2) }}</td>
                            </tr>
                            <!-- <tr class="summary-row">
                                <td colspan="6" class="text-end"><strong>Total Amount:</strong></td>
                                <td>{{ round($grandAmount - $paidAmount, 2) }}</td>
                            </tr> -->
                    <!-- <tr>
                        <th>Received:</th>
                        <td>{{round($paidAmount, 2)}} {{$saleBill->currency->name}}</td>
                    </tr>
                    <tr>
                        <th>Prev Balance:</th>
                        <td>{{round($totBalance - ($grandAmount - $paidAmount), 2)}} {{$saleBill->currency->name}}</td>
                    </tr>
                    <tr>
                        <th>Total Balance:</th>
                        <td>{{round($totBalance, 2)}} {{$saleBill->currency->name}}</td>
                    </tr>
                    <tr>
                        <th>Total Amount:</th>
                        <td>{{round($grandAmount - $paidAmount, 2)}} {{$saleBill->currency->name}}</td>
                    </tr> -->
                    </table>
                    
                </div>
                
                <div class="col-12">
                <hr>
                <i>Address: {{$setting->address}}</i><br>
                <p>Contact: {{$setting->phone1}}, {{$setting->phone2}}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
