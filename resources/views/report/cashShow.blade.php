@if (Auth::user()->language == 'Pashto')
<h3 class="text-center">د نغدو راپور له ({{ $from }}) تر ({{ $to }}) </h3>
<h2 class="text-center">({{ $currency->name }}) کرنسي </h2>
<table class="table table-bordered table-sm" id="tbl_statement">
    <thead class="table-primary">
        <tr>
            <th>نیټه</th>
            <th>وضاحت</th>
            <th>Credit</th>
            <th>Debit</th>
            <th>Balance</th>
        </tr>
    </thead>
    <tbody id="tblShow">

        @foreach ($cashes as $cash)
            <tr>
                <td>{{ $cash->created_at }}</td>
                <td class="text-center">Cash (In/Out):{{ $cash->details }}</td>
                <td class="credit">{{ round($cash->amount, 1) }}</td>
                <td class="debit">0</td>
                <td class="balance"></td>
            </tr>
        @endforeach
        @foreach ($purchaseCashReturns as $purchaseCashReturn)
            <tr>
                <td>{{ $purchaseCashReturn->created_at }}</td>
                <td class="text-center">د خریداری نغد واپسي:{{ $purchaseCashReturn->details }}</td>
                <td class="credit">{{ round($purchaseCashReturn->amount, 1) }}</td>
                <td class="debit">0</td>
                <td class="balance"></td>
            </tr>
        @endforeach

        @foreach ($payments as $payment)
            <tr>
                <td>{{ $payment->created_at }}</td>
                <td class="text-center"> د شرکت وصولی:{{ $payment->details }} </td>
                <td class="credit">0</td>
                <td class="debit">{{ round($payment->amount, 1) }}</td>
                <td class="balance"></td>
            </tr>
        @endforeach

        @foreach ($expenses as $expense)
            <tr>
                <td>{{ $expense->created_at }}</td>
                <td class="text-center">مصارف: {{ $expense->details }}</td>
                <td class="credit">0</td>
                <td class="debit">{{ round($expense->amount, 1) }}</td>
                <td class="balance"></td>
            </tr>
        @endforeach

        @foreach ($receiveds as $received)
            <tr>
                <td>{{ $received->created_at }}</td>
                <td class="text-center">د مشتری وصولی:{{ $received->details }}</td>
                <td class="credit">{{ round($received->amount, 1) }}</td>
                <td class="debit">0</td>
                <td class="balance"></td>
            </tr>
        @endforeach

        @foreach ($saleCashReturns as $saleCashReturn)
            <tr>
                <td>{{ $saleCashReturn->created_at }}</td>
                <td class="text-center"> د خرڅلاو نغد واپسي:{{ $saleCashReturn->details }} </td>
                <td class="credit">0</td>
                <td class="debit">{{ round($saleCashReturn->amount, 1) }}</td>
                <td class="balance"></td>
            </tr>
        @endforeach
    </tbody>
    <tfoot class="table-primary">
        <tr>
            <th></th>
            <th>مجموعه</th>
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
@else
<h3 class="text-center">Cash Flow Report between ({{ $from }}) and ({{ $to }}) </h3>
<h2 class="text-center">({{ $currency->name }}) Currency </h2>
<table class="table table-bordered table-sm" id="tbl_statement">
    <thead class="table-primary">
        <tr>
            <th>Date</th>
            <th>Details</th>
            <th>Credit</th>
            <th>Debit</th>
            <th>Balance</th>
        </tr>
    </thead>
    <tbody id="tblShow">

        @foreach ($cashes as $cash)
            <tr>
                <td>{{ $cash->created_at }}</td>
                <td class="text-center">Cash (In/Out):{{ $cash->details }}</td>
                <td class="credit">{{ round($cash->amount, 1) }}</td>
                <td class="debit">0</td>
                <td class="balance"></td>
            </tr>
        @endforeach
        @foreach ($purchaseCashReturns as $purchaseCashReturn)
            <tr>
                <td>{{ $purchaseCashReturn->created_at }}</td>
                <td class="text-center">Purchase Cash Return:{{ $purchaseCashReturn->details }}</td>
                <td class="credit">{{ round($purchaseCashReturn->amount, 1) }}</td>
                <td class="debit">0</td>
                <td class="balance"></td>
            </tr>
        @endforeach

        @foreach ($payments as $payment)
            <tr>
                <td>{{ $payment->created_at }}</td>
                <td class="text-center"> Payment:{{ $payment->details }} </td>
                <td class="credit">0</td>
                <td class="debit">{{ round($payment->amount, 1) }}</td>
                <td class="balance"></td>
            </tr>
        @endforeach

        @foreach ($expenses as $expense)
            <tr>
                <td>{{ $expense->created_at }}</td>
                <td class="text-center">Expense: {{ $expense->details }}</td>
                <td class="credit">0</td>
                <td class="debit">{{ round($expense->amount, 1) }}</td>
                <td class="balance"></td>
            </tr>
        @endforeach

        @foreach ($receiveds as $received)
            <tr>
                <td>{{ $received->created_at }}</td>
                <td class="text-center">Received:{{ $received->details }}</td>
                <td class="credit">{{ round($received->amount, 1) }}</td>
                <td class="debit">0</td>
                <td class="balance"></td>
            </tr>
        @endforeach

        @foreach ($saleCashReturns as $saleCashReturn)
            <tr>
                <td>{{ $saleCashReturn->created_at }}</td>
                <td class="text-center"> Sale Cash Return:{{ $saleCashReturn->details }} </td>
                <td class="credit">0</td>
                <td class="debit">{{ round($saleCashReturn->amount, 1) }}</td>
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
