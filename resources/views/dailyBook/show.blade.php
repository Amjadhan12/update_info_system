@if (Auth::user()->language == 'Pashto')
    <style>
        th {
            font-weight: bolder !important;
        }

    </style>
    <h3 class="text-center">له ({{ $from }}) تر ({{ $to }}) روزنامچه </h3>
    <table class="table table-bordered table-sm" id="tbl_statement">
        <thead class="table-primary">
            <tr>
                <th>نیټه</th>
                <th>وضاحت</th>
                <th>جمع (+)</th>
                <th>بنام (-)</th>
                <th>بلانس</th>
            </tr>
        </thead>
        <tbody id="tblShow">


            @foreach ($dailyBooks as $dailyBook)
                @php
                    $credit = 0;
                    $debit = 0;
                    if ($dailyBook->isCredit == 1) {
                        $credit = $dailyBook->amount;
                    } else {
                        $debit = $dailyBook->amount;
                    }
                @endphp
                <tr>
                    <td>{{ $dailyBook->date }}</td>
                    <td class="text-center"><b style="font-weight: bold;">{{ $dailyBook->title }}:
                        </b>{{ $dailyBook->details }}</td>
                    <td class="credit">{{ round($credit, 1) }}</td>
                    <td class="debit">{{ round($debit, 1) }}</td>
                    <td class="balance"></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot class="table-primary">
            <tr>
                <th></th>
                <th>Grand Total</th>
                <th id="grandCredit"></th>
                <th id="grandDebit"></th>
                <th id="grandBalance"></th>
            </tr>
        </tfoot>
    </table>
    <style>
        @media print {
            #btn_print {
                display: none;
            }
        }

    </style>
    <button class="btn btn-primary" id="btn_print"><i class="fa fa-print"></i> Print</button>
@else
    <style>
        th {
            font-weight: bolder !important;
        }

    </style>
    <h3 class="text-center">From ({{ $from }}) To ({{ $to }}) Date Daily Book </h3>
    <table class="table table-bordered table-sm" id="tbl_statement">
        <thead class="table-primary">
            <tr>
                <th>Date</th>
                <th>Details</th>
                <th>Credit (+)</th>
                <th>Debit (-)</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody id="tblShow">


            @foreach ($dailyBooks as $dailyBook)
                @php
                    $credit = 0;
                    $debit = 0;
                    if ($dailyBook->isCredit == 1) {
                        $credit = $dailyBook->amount;
                    } else {
                        $debit = $dailyBook->amount;
                    }
                @endphp
                <tr>
                    <td>{{ $dailyBook->date }}</td>
                    <td class="text-center"><b style="font-weight: bold;">{{ $dailyBook->title }}:
                        </b>{{ $dailyBook->details }}</td>
                    <td class="credit">{{ round($credit, 1) }}</td>
                    <td class="debit">{{ round($debit, 1) }}</td>
                    <td class="balance"></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot class="table-primary">
            <tr>
                <th></th>
                <th>Grand Total</th>
                <th id="grandCredit"></th>
                <th id="grandDebit"></th>
                <th id="grandBalance"></th>
            </tr>
        </tfoot>
    </table>
    <style>
        @media print {
            #btn_print {
                display: none;
            }
        }

    </style>
    <button class="btn btn-primary" id="btn_print"><i class="fa fa-print"></i> Print</button>

@endif

<script>
    $("#tbl_statement").tablesorter({
        theme: 'blue',
        sortList: [
            [0, 0]
        ]
    });

    var currentBalance = 0;
    $('#tbl_statement tbody tr').each(function() { //Loop thru each row

        var payment = -$(this).find('.debit')
            .text(); //Get the value of payment and make the value negative number
        var receipt = +$(this).find('.credit')
            .text(); //Get the value of receipt and make the value positive number

        currentBalance += payment + receipt; //Just add the values

        $(this).find('.balance').text(currentBalance.toFixed(2)); //Update .balance
    });

    var tblShow = document.getElementById("tblShow");
    var grandDebit = 0;
    var grandCredit = 0;
    for (var a = 0; a < tblShow.rows.length; a++) {
        grandDebit += parseFloat(tblShow.rows[a].cells[3].innerHTML);
        grandCredit += parseFloat(tblShow.rows[a].cells[2].innerHTML);
    }

    $("#grandDebit").html(grandDebit);
    $("#grandCredit").html(grandCredit);
    $("#grandBalance").html(grandCredit - grandDebit);
</script>
