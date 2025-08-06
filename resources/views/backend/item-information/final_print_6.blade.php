@php 
    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();

    $items = $data["_search_item_id"];
    $_qtys = $data["_qty"];
    $_barcodes = $data["_barcode"];
    $_sales_rates = $data["_sales_rate"];
    $_vats = $data["_vat"];
    $_discounts = $data["_discount"];
    $_product_name_check = $data["_product_name_check"] ?? '';
    $_product_price_check = $data["_product_price_check"] ?? '';
    $_bussiness_name = $data["_bussiness_name"] ?? '';
    $_vat_check = $data["_vat_check"] ?? '';
    $_discount_check = $data["_discount_check"] ?? '';
    $_product_name_size = $data["_product_name_size"] ?? 8;
    $_product_price_size = $data["_product_price_size"] ?? 8;
    $_bussiness_name_size = $data["_bussiness_name_size"] ?? 8;
    $_vat_size = $data["_vat_size"] ?? 8;
    $_discount_size = $data["_discount_size"] ?? 8;

    $_manufacture_date = $data["_manufacture_date"] ?? [];
    $_expire_date = $data["_expire_date"] ?? [];
    $_manufacture_date_check = $data["_manufacture_date_check"] ?? '';
    $_expire_date_check = $data["_expire_date_check"] ?? '';
@endphp

@forelse($items as $key=>$item)
@php
    $_qty = $_qtys[$key];
    $_loop_time = $_qty;
@endphp

@for($i=0; $i<$_loop_time; $i++)
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        html, body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            width: 100%;
            height: 100%;
        }

        table {
            width: 100%;
            height: 100%;
            border-collapse: collapse;
            page-break-before: always;
        }

        td {
            padding: 0;
            text-align: center;
            vertical-align: middle;
            border: 1px dotted lightgray;
        }

        .barcode-container {
            width: 31.75mm; /* Width of the label */
            height: 25.4mm; /* Height of the label */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2mm; /* Padding inside the container */
            box-sizing: border-box; /* Ensure padding does not affect the layout */
        }

        .barcode-img {
            width: 100%; /* Scale barcode to the full width of the container */
            height: auto; /* Maintain aspect ratio */
        }

        .barcode-text {
            font-size: 8px;
            word-wrap: break-word;
        }

        @media print {
            @page {
                size: 31.75mm 25.4mm; /* Setting page size to label size (31.75mm x 25.4mm) */
                margin: 0; /* Remove any margins */
                gap: 3.18mm; /* Set the gap between labels */
            }

            table {
                page-break-after: always; /* Force new page after each barcode */
            }

            .barcode-container {
                width: 100%;
                height: 100%;
                padding: 0; /* Remove extra padding */
            }

            .barcode-img {
                width: 100%;
                height: auto;
            }
        }
    </style>
</head>
<body>

<table align="center">
    <tr>
        <td>
            <div class="barcode-container">
                @if($_bussiness_name !='') 
                    <b style="font-size: {{$_bussiness_name_size}}px;color:#000;">{{$settings->name ?? '' }}</b> 
                @endif 

                @if($_product_name_check !='')
                    <span style="font-size: {{$_product_name_size}}px;color:#000;">{{$items[$key]}}</span>
                @endif

                @if($_product_price_check !='')
                    <span style="font-size: {{$_product_price_size}}px;color:#000;">Price:{{prefix_taka()}}.{{number_format($_sales_rates[$key] ?? 0, 2)}}</span>
                @endif

                @if($_vat_check !='')
                    <span style="font-size: {{$_vat_size}}px;color:#000;">VAT:{{number_format($_vats[$key] ?? 0, 2)}}</span>
                @endif

                @if($_discount_check !='')
                    <span style="font-size: {{$_discount_size}}px;color:#000;">Discount:{{number_format($_discounts[$key] ?? 0, 2)}}</span>
                @endif

                @if($_manufacture_date_check !='')
                    <span style="font-size: {{$_discount_size}}px;color:#000;">MFG:{{$_manufacture_date[$key] ?? ''}}</span>
                @endif

                @if($_expire_date_check !='')
                    <span style="font-size: {{$_discount_size}}px;color:#000;"><b>EXP:{{$_expire_date[$key] ?? ''}}</b></span>
                @endif

                <?php 
                    // Increase the barcode resolution and size for better scannability
                    $barcodeImage = $generator->getBarcode($_barcodes[$key], $generator::TYPE_CODE_128); 
                ?>

                <img class="barcode-img" src="data:image/png;base64,{{ base64_encode($barcodeImage) }}" alt="Barcode">
                <span class="barcode-text">{{$_barcodes[$key]}}</span>
            </div>
        </td>
    </tr>
</table>

<script>
    window.print();  // This triggers the print dialog
</script>

</body>
</html>
@endfor
@empty
@endforelse
