<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ str_replace('.', '-', $data->MODEL ?? 'IFS') }}</title>
    <style>
        @page {
            size: 100mm 85mm;
            margin: 2mm;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 98mm;
        }

        .page-break {
            page-break-after: always;
        }

        .print-table {
            width: 98mm;
            border-collapse: collapse;
            border: 2px solid black;
            margin: 12px 0 0 0;
        }

        .print-table th,
        .print-table td {
            border: 1px solid black;
            padding: 2px 2px 2px;
            font-size: 10pt;
            font-weight: bold;
            vertical-align: middle;
            line-height: 1.2;
            height: 7mm;
        }

        .print-table .label-col {
            width: 30%;
            text-transform: uppercase;
        }
    </style>
</head>

<body>

    @foreach ($pages as $index => $page)
        <table class="print-table">
            <tr>
                <td class="label-col">COMMODITY</td>
                <td>{{ $data->COMMODITY ?? '' }}</td>
            </tr>
            <tr>
                <td class="label-col">PO NO.</td>
                <td>{{ $data->PoNo ?? '' }}</td>
            </tr>
            <tr>
                <td class="label-col">REF. NO.</td>
                <td>{{ $data->REFNO ?? '' }}</td>
            </tr>
            <tr>
                <td class="label-col">MODEL</td>
                <td>{{ $data->MODEL ?? '' }}</td>
            </tr>
            <tr>
                <td class="label-col">COLOR</td>
                <td>{{ $data->COLOR ?? '' }}</td>
            </tr>
            <tr>
                <td class="label-col">SIZE</td>
                <td>{{ $data->SIZE ?? '' }}</td>
            </tr>
            <tr>
                <td class="label-col">G. W.</td>
                <td>{{ $data->GW ?? '' }} KGS</td>
            </tr>
            <tr>
                <td class="label-col">{{ $data->TypeText ?? 'ROLL NO.' }}</td>
                <td>{{ $page['serial'] }} {{ $data->TypeSuffix }}</td>
            </tr>
            <tr>
                <td class="label-col">CUSTOMER</td>
                <td>{{ $data->Customer ?? '' }}</td>
            </tr>
        </table>

        @if ($index < count($pages) - 1)
            <div class="page-break"></div>
        @endif
    @endforeach

    @if (isset($autoPrint) && $autoPrint)
        <script>
            window.onload = function() {
                window.print();
            };
        </script>
    @endif
</body>

</html>
