@extends('layouts.admin')

@section('title', Auth::user()->language == 'Pashto' ? 'مجموعي سرمایه' : 'Current Total Asset')

@section('body')

@php
    $isPashto = Auth::user()->language == 'Pashto';
    $currency = App\Models\Currency::first();
    $currencyName = $currency ? $currency->name : '';

    $cash = round($cashCapital, 2);
    $stock = round($stockAmount, 2);
    $receivable = round($receivables, 2);
    $payable = round($payables, 2);

    $total = round($cash + $stock + $receivable - $payable, 2);
@endphp

<style>
    .report-container {
        max-width: 900px;
        margin: 30px auto;
    }

    .report-card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 15px rgba(0, 0, 0, .10);
    }

    .report-header {
        background: #2563eb;
        color: white;
        padding: 18px 25px;
    }

    .report-header h4 {
        margin: 0;
    }

    .report-body {
        padding: 30px;
        background: white;
    }

    .company-title {
        color: #1e3a8a;
        font-weight: bold;
        font-size: 24px;
    }

    .report-date {
        color: #6b7280;
    }

    .asset-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 25px;
    }

    .asset-table th {
        background: #2563eb;
        color: white;
        padding: 12px;
    }

    .asset-table td {
        padding: 12px;
        border: 1px solid #dee2e6;
    }

    .asset-table tbody tr:nth-child(even) {
        background: #f8fafc;
    }

    .amount {
        text-align: right;
        font-weight: 600;
    }

    .payable {
        color: #dc3545;
    }

    .total-row th {
        background: #198754 !important;
        color: white !important;
        font-size: 18px;
        padding: 15px !important;
    }

    .print-btn {
        background: #2563eb;
        color: white;
        border: none;
    }

    .print-btn:hover {
        background: #1d4ed8;
        color: white;
    }

    .rtl {
        direction: rtl;
        text-align: right;
    }

    .rtl .amount {
        text-align: left;
    }

    /* Print */
    @media print {

        @page {
            size: A4;
            margin: 15mm;
        }

        body {
            background: white !important;
        }

        .report-container {
            margin: 0;
            max-width: 100%;
        }

        .report-card {
            box-shadow: none;
        }

        .report-header,
        .print-area {
            display: none !important;
        }

        .report-body {
            padding: 0;
        }

        .asset-table th {
            background: #2563eb !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .total-row th {
            background: #198754 !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>

<div class="container-fluid">

    <div class="report-container">

        <div class="card report-card">

            {{-- Header --}}
            <div class="report-header">
                <h4>
                    <i class="fas fa-chart-pie mr-2"></i>

                    {{ $isPashto ? 'مجموعي سرمایه' : 'Current Total Asset' }}
                </h4>
            </div>

            {{-- Report --}}
            <div class="report-body {{ $isPashto ? 'rtl' : '' }}">

                <div class="text-center">

                    <div class="company-title">
                        {{ $setting->title_en }}
                    </div>

                    <h5 class="mt-2">
                        {{ $isPashto ? 'د مجموعي سرمایې راپور' : 'Current Total Asset Report' }}
                    </h5>

                    <div class="report-date">
                        {{ $isPashto ? 'نیټه' : 'Date' }}:
                        {{ date('Y-m-d') }}
                    </div>

                </div>

                <table class="asset-table">

                    <thead>
                        <tr>
                            <th>
                                {{ $isPashto ? 'وضاحت' : 'Description' }}
                            </th>

                            <th class="text-right">
                                {{ $isPashto ? 'اندازه' : 'Amount' }}
                                ({{ $currencyName }})
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td>
                                <i class="fas fa-money-bill-wave text-success mr-2"></i>

                                {{ $isPashto ? 'نغدې' : 'Cash Amount' }}
                            </td>

                            <td class="amount text-success">
                                {{ number_format($cash, 2) }}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <i class="fas fa-boxes text-primary mr-2"></i>

                                {{ $isPashto ? 'سټاک' : 'Stock' }}
                            </td>

                            <td class="amount text-primary">
                                {{ number_format($stock, 2) }}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <i class="fas fa-users text-warning mr-2"></i>

                                {{ $isPashto ? 'په مشتریانو قرض' : 'Receivables' }}
                            </td>

                            <td class="amount text-warning">
                                {{ number_format($receivable, 2) }}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <i class="fas fa-file-invoice text-danger mr-2"></i>

                                {{ $isPashto ? 'د شرکتونو قرض' : 'Payables' }}
                            </td>

                            <td class="amount payable">
                                - {{ number_format($payable, 2) }}
                            </td>
                        </tr>

                    </tbody>

                    <tfoot>
                        <tr class="total-row">

                            <th>
                                {{ $isPashto ? 'مجموعي سرمایه' : 'Current Total Asset' }}
                            </th>

                            <th class="text-right">
                                {{ number_format($total, 2) }}
                                {{ $currencyName }}
                            </th>

                        </tr>
                    </tfoot>

                </table>

                <div class="text-center text-muted mt-3">
                    <small>
                        {{ $setting->title_en }} |
                        {{ date('Y-m-d') }}
                    </small>
                </div>

            </div>

            {{-- Buttons --}}
            <div class="card-footer text-right print-area">

                <button type="button"
                        class="btn btn-secondary"
                        onclick="window.history.back()">

                    <i class="fas fa-arrow-left"></i>
                    {{ $isPashto ? 'شاته' : 'Back' }}

                </button>

                <button type="button"
                        class="btn print-btn"
                        id="btn_print">

                    <i class="fas fa-print"></i>
                    {{ $isPashto ? 'چاپول' : 'Print Report' }}

                </button>

            </div>

        </div>

    </div>

</div>

@endsection


@section('pageJs')

<script>
    $(document).ready(function () {

        $(".nav-link").removeClass("active");
        $("#nav_report").addClass("active");

        $("#btn_print").click(function () {
            window.print();
        });

    });
</script>

@endsection
