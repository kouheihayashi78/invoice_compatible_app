<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>請求書</title>
    <style>
        @font-face {
            font-family: 'NotoSansJP';
            font-style: normal;
            font-weight: normal;
            src: url('{{ storage_path('fonts/NotoSansJP-Regular.ttf') }}')
        }
        html,
        body,
        textarea,
        table {
            font-family: 'NotoSansJP';
        }

        body {
            padding-top: 5mm;
            width: 190mm;
            height: 290mm;
            margin-left: auto;
            margin-right: auto;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table,
        th,
        td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 0 10px 5px;
            text-align: center;
        }

        .total {
            text-align: right;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <p style="font-size:24px; text-align:center; margin: 5px;">御請求書</p>
    <div>
        <div style="text-align: right">
            @php($printday = date("Y年m月d日"))
            @php($orderday = date("Y年m月d日",strtotime($order->order_day)))
            <p>請求日：{{ $printday }}<BR>
                注文日：{{ $orderday }}</p>
        </div>
        <div>
            <p style="font-size:22px;">
                <span style="margin-right: 5px;">{{ $order->customer->customer_name }}</span>御中
            </p>
        </div>
        <div style="text-align: right">
            <p style="line-height: 14px;">
                株式会社 HK<br>
                〒100-0000<br>
                東京都中央区＊＊＊＊＊＊＊＊＊<br>
                登録番号：T1234567<br>
            </p>
        </div>
    </div>

    <div style="border-top: 1px solid #000; border-bottom: 1px solid #000; text-align:center;">
        <div>
            <p style="font-size: 16px;">ご請求金額　￥{{$total}}</p>
        </div>
    </div>

    <div>
        <div>
            <p>上記金額をご請求させていただきます。</p>
        </div>
    </div>

    <div>
        <p style="margin: 0;">【税率区分】</p>
    </div>
    <table class="price" style="margin-top: 0;">
        <tr>
            <th style="font-weight:normal;"></th>
            <Th style="font-weight:normal;">お買い上げ額合計（円）</th>
            <th style="font-weight:normal;">消費税額合計（円）</th>
        </tr>
        <tr>
            <td>通常税率（10%）</td>
            <td>{{ $normal_tax_total }}</td>
            <td>{{ $normal_tax }}</td>
        </tr>
        <tr>
            <td>軽減税率（ 8%）</td>
            <td>{{ $reduced_tax_total }}</td>
            <td>{{ $reduced_tax }}</td>
        </tr>
    </table>
    <div>
        <p style="margin: 20px 0 0;">【明細】</p>
    </div>
    <table class="price" style="margin-top: 0;">
        <tr>
            <th style="font-weight:normal;">商品</th>
            <th style="font-weight:normal;">コード</th>
            <th style="font-weight:normal;">価格（円）</th>
            <th style="font-weight:normal;">税率（%）</th>
            <th style="font-weight:normal;">注文数（個）</th>
        </tr>
        <tr>
            <td>
                {{ $order->product1->product_name }}
                @if($order->product1->product_tax==8)
                <span>＊</span>
                @endif
            </td>
            <td>{{ $order->product1->product_code }}</td>
            <td>{{ $order->product1->product_price }}</td>
            <td>{{ $order->product1->product_tax }}</td>
            <td>{{ $order->order_num1 }}</td>
        </tr>
        @if($order->product2)
        <tr>
            <td>
                {{ $order->product2->product_name }}
                @if($order->product2->product_tax==8)
                <span>＊</span>
                @endif
            </td>
            <td>{{ $order->product2->product_code }}</td>
            <td>{{ $order->product2->product_price }}</td>
            <td>{{ $order->product2->product_tax }}</td>
            <td>{{ $order->order_num2 }}</td>
        </tr>
        @endif
        @if($order->product3)
        <tr>
            <td>
                {{ $order->product3->product_name }}
                @if($order->product3->product_tax==8)
                <span>＊</span>
                @endif
            </td>
            <td>{{ $order->product3->product_code }}</td>
            <td>{{ $order->product3->product_price }}</td>
            <td>{{ $order->product3->product_tax }}</td>
            <td>{{ $order->order_num3 }}</td>
        </tr>
        @endif
    </table>
    <div>
        <div>
            <p>＊軽減税率対象</p>
        </div>
    </div>

</body>

</html>
