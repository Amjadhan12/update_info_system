@if (Auth::user()->language == 'Pashto')
    <style>
        th {
            font-weight: bolder !important;
        }

    </style>
    <h3 class="text-center">({{ $cashAccount->name }}) Cash Account, ({{ $currency->name }}) Statement </h3>
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
                    <td class="text-center"> نغد :{{ $cash->details }} </td>
                    <td class="credit">{{ round($cash->amount, 1) }}</td>
                    <td class="debit">0</td>
                    <td class="balance"></td>
                </tr>
            @endforeach

            @foreach ($receiveds as $received)
                <tr>
                    <td>{{ $received->created_at }}</td>
                    <td class="text-center">د مشتری وصولی: Rasid ({{ $received->rasid_no }}),
                        {{ $received->details }}
                    </td>
                    <td class="credit">{{ round($received->amount, 1) }}</td>
                    <td class="debit">0</td>
                    <td class="balance"></td>
                </tr>
            @endforeach
            @foreach ($cashPurchaseReturns as $cashPurchaseReturn)
                <tr>
                    <td>{{ $cashPurchaseReturn->created_at }}</td>
                    <td class="text-center">د خریداری نغد واپسي({{ $cashPurchaseReturn->id }}):
                        {{ $cashPurchaseReturn->details }}</td>
                    <td class="credit">{{ round($cashPurchaseReturn->amount, 1) }}</td>
                    <td class="debit">0</td>
                    <td class="balance"></td>
                </tr>
            @endforeach

            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->created_at }}</td>
                    <td class="text-center">شرکت ته وصولی: {{ $payment->details }}</td>
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
            @foreach ($cashSaleReturns as $cashSaleReturn)
                <tr>
                    <td>{{ $cashSaleReturn->created_at }}</td>
                    <td class="text-center">د خرڅلاو نغد واپسي({{ $cashSaleReturn->id }}):
                        {{ $cashSaleReturn->details }}</td>
                    <td class="credit">0</td>
                    <td class="debit">{{ round($cashSaleReturn->amount, 1) }}</td>
                    <td class="balance"></td>
                </tr>
            @endforeach

            @foreach ($transferIns as $transferIn)
                <tr>
                    <td>{{ $transferIn->created_at }}</td>
                    <td class="text-center">دې حساب ته انتقال: {{ $transferIn->details }}</td>
                    <td class="credit">{{ round($transferIn->amount, 1) }}</td>
                    <td class="debit">0</td>
                    <td class="balance"></td>
                </tr>
            @endforeach
            @foreach ($transferOuts as $transferOut)
                <tr>
                    <td>{{ $transferOut->created_at }}</td>
                    <td class="text-center">بل حساب ته انتقال: {{ $transferOut->details }}</td>
                    <td class="credit">0</td>
                    <td class="debit">{{ round($transferOut->amount, 1) }}</td>
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
    <button class="btn btn-primary" id="btn_print"><i class="fa fa-print"></i> چاپول</button>
@else
    <style>
        th {
            font-weight: bolder !important;
        }

    </style>
    <h3 class="text-center">({{ $cashAccount->name }}) Cash Account, ({{ $currency->name }}) Statement </h3>
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
                    <td class="text-center"> Cash :{{ $cash->details }} </td>
                    <td class="credit">{{ round($cash->amount, 1) }}</td>
                    <td class="debit">0</td>
                    <td class="balance"></td>
                </tr>
            @endforeach

            @foreach ($receiveds as $received)
                <tr>
                    <td>{{ $received->created_at }}</td>
                    <td class="text-center">Receipt: Rasid ({{ $received->rasid_no }}), {{ $received->details }}
                    </td>
                    <td class="credit">{{ round($received->amount, 1) }}</td>
                    <td class="debit">0</td>
                    <td class="balance"></td>
                </tr>
            @endforeach
            @foreach ($cashPurchaseReturns as $cashPurchaseReturn)
                <tr>
                    <td>{{ $cashPurchaseReturn->created_at }}</td>
                    <td class="text-center">Cash Purchase Return({{ $cashPurchaseReturn->id }}):
                        {{ $cashPurchaseReturn->details }}</td>
                    <td class="credit">{{ round($cashPurchaseReturn->amount, 1) }}</td>
                    <td class="debit">0</td>
                    <td class="balance"></td>
                </tr>
            @endforeach

            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->created_at }}</td>
                    <td class="text-center">Payment: {{ $payment->details }}</td>
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
            @foreach ($cashSaleReturns as $cashSaleReturn)
                <tr>
                    <td>{{ $cashSaleReturn->created_at }}</td>
                    <td class="text-center">Cash Sale Return({{ $cashSaleReturn->id }}):
                        {{ $cashSaleReturn->details }}</td>
                    <td class="credit">0</td>
                    <td class="debit">{{ round($cashSaleReturn->amount, 1) }}</td>
                    <td class="balance"></td>
                </tr>
            @endforeach

            @foreach ($transferIns as $transferIn)
                <tr>
                    <td>{{ $transferIn->created_at }}</td>
                    <td class="text-center">Transfer In: {{ $transferIn->details }}</td>
                    <td class="credit">{{ round($transferIn->amount, 1) }}</td>
                    <td class="debit">0</td>
                    <td class="balance"></td>
                </tr>
            @endforeach
            @foreach ($transferOuts as $transferOut)
                <tr>
                    <td>{{ $transferOut->created_at }}</td>
                    <td class="text-center">Transfer Out: {{ $transferOut->details }}</td>
                    <td class="credit">0</td>
                    <td class="debit">{{ round($transferOut->amount, 1) }}</td>
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
        grandDebit += parseFloat(tblShow.rows[a].cells[2].innerHTML);
        grandCredit += parseFloat(tblShow.rows[a].cells[3].innerHTML);
    }

    $("#grandDebit").html(grandDebit);
    $("#grandCredit").html(grandCredit);
    $("#grandBalance").html(grandDebit - grandCredit);
</script>
