@if (Auth::user()->language == 'Pashto')
    <style>
        th {
            font-weight: bolder !important;
        }
    </style>
    <h3 class="text-center">({{ $customer->name }}) مشتری, ({{ $currency->name }}) حساب </h3>
    <table class="table table-bordered table-sm" id="tbl_statement">
        <thead class="table-primary">
            <tr>
                <th>نیټه</th>
                <th>وضاحت</th>
                <th>جمع</th>
                <th>بنام</th>
                <th>بقایا</th>
            </tr>
        </thead>
        <tbody id="tblShow">

            @foreach ($openReceivables as $openReceivable)
                <tr>
                    <td>{{ $openReceivable->created_at }}</td>
                    <td class="text-center"> لومړني قرض:{{ $openReceivable->details }} </td>
                    <td class="debit">{{ round($openReceivable->amount, 1) }}</td>
                    <td class="credit">0</td>
                    <td class="balance"></td>
                </tr>
            @endforeach

            @foreach ($sales as $sale)
                <tr class="sale" data-id="{{ $sale->bill_id }}">
                    <td>{{ $sale->created_at }}</td>
                    <td class="text-center">خرڅلاو ({{ $sale->bill_id }}) :{{ $sale->details }}</td>
                    <td class="debit">{{ round($sale->amount, 1) }}</td>
                    <td class="credit">0</td>
                    <td class="balance"></td>
                </tr>
            @endforeach

            @foreach ($receiveds as $received)
                <tr>
                    <td>{{ $received->created_at }}</td>
                    <td class="text-center">وصولی: Rasid ({{ $received->rasid_no }}), {{ $received->details }}
                    </td>
                    <td class="debit">0</td>
                    <td class="credit">{{ round($received->amount, 1) }}</td>
                    <td class="balance"></td>
                </tr>
            @endforeach

            @foreach ($returns as $return)
                <tr>
                    <td>{{ $return->created_at }}</td>
                    <td class="text-center">په کهاته کې واپسي :{{ $return->details }}</td>
                    <td class="debit">0</td>
                    <td class="credit">{{ round($return->amount, 1) }}</td>
                    <td class="balance"></td>
                </tr>
            @endforeach
            @foreach ($cashReturns as $cashReturn)
                <tr>
                    <td>{{ $cashReturn->created_at }}</td>
                    <td class="text-center">نغد واپسي :{{ $cashReturn->details }}</td>
                    <td class="debit">{{ round($cashReturn->amount, 1) }}</td>
                    <td class="credit">0</td>
                    <td class="balance"></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot class="table-primary">
            <tr>
                <th></th>
                <th>مجموعه</th>
                <th id="grandDebit"></th>
                <th id="grandCredit"></th>
                <th id="grandBalance"></th>
            </tr>
        </tfoot>
    </table>
    <style>
        @media print {
            #btn_print, #btn_excel {
                display: none;
            }
        }
    </style>
    <div class="mt-3">
        <button class="btn btn-primary" id="btn_print"><i class="fa fa-print"></i> Print</button>
        <button class="btn btn-success" id="btn_excel"><i class="fa fa-file-excel-o"></i> Excel ته صادر کړئ</button>
    </div>

@else
    <style>
        th {
            font-weight: bolder !important;
        }
    </style>
    <h3 class="text-center">({{ $customer->name }}) customer, ({{ $currency->name }}) Account Statement </h3>
    <table class="table table-bordered table-sm" id="tbl_statement">
        <thead class="table-primary">
            <tr>
                <th>Date</th>
                <th>Details</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody id="tblShow">

            @foreach ($openReceivables as $openReceivable)
                <tr>
                    <td>{{ $openReceivable->created_at }}</td>
                    <td class="text-center"> Open Receivable:{{ $openReceivable->details }} </td>
                    <td class="debit">{{ round($openReceivable->amount, 1) }}</td>
                    <td class="credit">0</td>
                    <td class="balance"></td>
                </tr>
            @endforeach

            @foreach ($sales as $sale)
                <tr class="sale" data-id="{{ $sale->bill_id }}">
                    <td>{{ $sale->created_at }}</td>
                    <td class="text-center">Sale ({{ $sale->bill_id }}) :{{ $sale->details }}</td>
                    <td class="debit">{{ round($sale->amount, 1) }}</td>
                    <td class="credit">0</td>
                    <td class="balance"></td>
                </tr>
            @endforeach

            @foreach ($receiveds as $received)
                <tr>
                    <td>{{ $received->created_at }}</td>
                    <td class="text-center">Receipt: Rasid ({{ $received->rasid_no }}), {{ $received->details }}
                    </td>
                    <td class="debit">0</td>
                    <td class="credit">{{ round($received->amount, 1) }}</td>
                    <td class="balance"></td>
                </tr>
            @endforeach

            @foreach ($returns as $return)
                <tr>
                    <td>{{ $return->created_at }}</td>
                    <td class="text-center">Return :{{ $return->details }}</td>
                    <td class="debit">0</td>
                    <td class="credit">{{ round($return->amount, 1) }}</td>
                    <td class="balance"></td>
                </tr>
            @endforeach
            @foreach ($cashReturns as $cashReturn)
                <tr>
                    <td>{{ $cashReturn->created_at }}</td>
                    <td class="text-center">Cash Return :{{ $cashReturn->details }}</td>
                    <td class="debit">{{ round($cashReturn->amount, 1) }}</td>
                    <td class="credit">0</td>
                    <td class="balance"></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot class="table-primary">
            <tr>
                <th></th>
                <th>Grand Total</th>
                <th id="grandDebit"></th>
                <th id="grandCredit"></th>
                <th id="grandBalance"></th>
            </tr>
        </tfoot>
    </table>
    <style>
        @media print {
            #btn_print, #btn_excel {
                display: none;
            }
        }
    </style>
    <div class="mt-3">
        <button class="btn btn-primary" id="btn_print"><i class="fa fa-print"></i> Print</button>
        <button class="btn btn-success" id="btn_excel"><i class="fa fa-file-excel-o"></i> Export to Excel</button>
    </div>

@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    $("#tbl_statement").tablesorter({
        theme: 'blue',
        sortList: [
            [0, 0]
        ]
    });

    var currentBalance = 0;
    $('#tbl_statement tbody tr').each(function() { //Loop thru each row

        var payment = +$(this).find('.debit')
            .text(); //Get the value of payment and make the value negative number
        var receipt = -$(this).find('.credit')
            .text(); //Get the value of receipt and make the value positive number

        currentBalance += payment + receipt; //Just add the values

        $(this).find('.balance').text(currentBalance.toFixed(2)); //Update .balance
    });

    var tblShow = document.getElementById("tblShow");
    var grandDebit = 0;
    var grandCredit = 0;
    for (var a = 0; a < tblShow.rows.length; a++) {
        grandDebit += parseFloat(tblShow.rows[a].cells[2].innerHTML);
        grandCredit += parseFloat(tblShow.rows[a].cells[3].innerHTML);
    }

    $("#grandDebit").html(grandDebit);
    $("#grandCredit").html(grandCredit);
    $("#grandBalance").html(grandDebit - grandCredit);

    // Excel Export Functionality
    document.getElementById('btn_excel').addEventListener('click', function() {
        // Get the table element
        var table = document.getElementById('tbl_statement');
        
        // Create a new workbook
        var wb = XLSX.utils.book_new();
        
        // Convert table to worksheet
        var ws = XLSX.utils.table_to_sheet(table);
        
        // Add the worksheet to the workbook
        XLSX.utils.book_append_sheet(wb, ws, 'Customer Statement');
        
        // Generate filename with customer name and date
        var customerName = "{{ $customer->name }}";
        var date = new Date().toISOString().split('T')[0];
        var fileName = customerName + '_Statement_' + date + '.xlsx';
        
        // Save the file
        XLSX.writeFile(wb, fileName);
    });
</script>