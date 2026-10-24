@if (Auth::user()->language == 'Pashto')
<style>
    th {
        font-weight: bolder !important;
    }

</style>
<h3 class="text-center">({{ $supplier->name }}) supplier, ({{ $currency->name }}) Account Statement </h3>
<table class="table table-bordered table-sm" id="tbl_statement">
    <thead class="table-primary">
        <tr>
            <th>نیټه</th>
            <th>وضاحت</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Balance</th>
        </tr>
    </thead>
    <tbody id="tblShow">

        @foreach ($openPaybles as $openPayble)
            <tr>
                <td>{{ $openPayble->created_at }}</td>
                <td class="text-center"> لومړني قرض:{{ $openPayble->details }} </td>
                <td class="debit">{{ round($openPayble->amount, 1) }}</td>
                <td class="credit">0</td>
                <td class="balance"></td>
            </tr>
        @endforeach

        @foreach ($purchases as $purchase)
            <tr class="purchase" data-id="{{ $purchase->bill_id }}">
                <td>{{ $purchase->created_at }}</td>
                <td class="text-center">خرید ({{ $purchase->bill_id }}) :{{ $purchase->details }}</td>
                <td class="debit">{{ round($purchase->amount, 1) }}</td>
                <td class="credit">0</td>
                <td class="balance"></td>
            </tr>
        @endforeach

        @foreach ($payments as $payment)
            <tr>
                <td>{{ $payment->created_at }}</td>
                <td class="text-center">وصولی:{{ $payment->details }}</td>
                <td class="debit">0</td>
                <td class="credit">{{ round($payment->amount, 1) }}</td>
                <td class="balance"></td>
            </tr>
        @endforeach

        @foreach ($returns as $return)
            <tr>
                <td>{{ $return->created_at }}</td>
                <td class="text-center">واپسي :{{ $return->details }}</td>
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
        #btn_print {
            display: none;
        }
    }

</style>
<button class="btn btn-primary" id="btn_print"><i class="fa fa-print"></i> چاپول</button>
@else
<style>
    th {
        font-weight: bolder !important;
    }

</style>
<h3 class="text-center">({{ $supplier->name }}) supplier, ({{ $currency->name }}) Account Statement </h3>
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

        @foreach ($openPaybles as $openPayble)
            <tr>
                <td>{{ $openPayble->created_at }}</td>
                <td class="text-center"> Open Payable:{{ $openPayble->details }} </td>
                <td class="debit">{{ round($openPayble->amount, 1) }}</td>
                <td class="credit">0</td>
                <td class="balance"></td>
            </tr>
        @endforeach

        @foreach ($purchases as $purchase)
            <tr class="purchase" data-id="{{ $purchase->bill_id }}">
                <td>{{ $purchase->created_at }}</td>
                <td class="text-center">Purchase ({{ $purchase->bill_id }}) :{{ $purchase->details }}</td>
                <td class="debit">{{ round($purchase->amount, 1) }}</td>
                <td class="credit">0</td>
                <td class="balance"></td>
            </tr>
        @endforeach

        @foreach ($payments as $payment)
            <tr>
                <td>{{ $payment->created_at }}</td>
                <td class="text-center">Payment:{{ $payment->details }}</td>
                <td class="debit">0</td>
                <td class="credit">{{ round($payment->amount, 1) }}</td>
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
                <td class="text-center">Return Cash :{{ $cashReturn->details }}</td>
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
</script>
