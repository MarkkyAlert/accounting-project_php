<?php
include('config.php');

if (isset($_REQUEST['reference'])) {
    $reference = $_REQUEST['reference'];
    $select_stmt = $db->prepare("SELECT * FROM receipts INNER JOIN course ON receipts.course_id = course.course_id INNER JOIN users ON receipts.user_id = users.user_id  WHERE reference = :reference ");
    $select_stmt->bindParam(':reference', $reference);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
}
function Convert($amount_number)
{
    $amount_number = number_format($amount_number, 2, ".", "");
    $pt = strpos($amount_number, ".");
    $number = $fraction = "";
    if ($pt === false)
        $number = $amount_number;
    else {
        $number = substr($amount_number, 0, $pt);
        $fraction = substr($amount_number, $pt + 1);
    }

    $ret = "";
    $baht = ReadNumber($number);
    if ($baht != "")
        $ret .= $baht . "บาท";

    $satang = ReadNumber($fraction);
    if ($satang != "")
        $ret .=  $satang . "สตางค์";
    else
        $ret .= "ถ้วน";
    return $ret;
}

function ReadNumber($number)
{
    $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
    $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
    $number = $number + 0;
    $ret = "";
    if ($number == 0) return $ret;
    if ($number > 1000000) {
        $ret .= ReadNumber(intval($number / 1000000)) . "ล้าน";
        $number = intval(fmod($number, 1000000));
    }

    $divider = 100000;
    $pos = 0;
    while ($number > 0) {
        $d = intval($number / $divider);
        $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" : ((($divider == 10) && ($d == 1)) ? "" : ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
        $ret .= ($d ? $position_call[$pos] : "");
        $number = $number % $divider;
        $divider = $divider / 10;
        $pos++;
    }
    return $ret;
}
?>

<?php

require_once __DIR__ . '/vendor/autoload.php';



$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/tmp',
    ]),
    'fontdata' => $fontData + [
        'pra' => [
            'R' => 'CSPraKas.ttf',
            'B' => 'CSPraKasBold.ttf'

        ]
    ],
    'default_font' => 'pra'
]);
ob_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Font Awesome -->
    <style>
        table {
            width: 800px;
            border-right-color: #ffffff;
            margin-top: 30px;
            font-size: 14px;
            /* /* border: 1px solid #343a40; */
            border-collapse: collapse;

        }

        th,
        td {
            /* border: 1px solid #343a40; */
            padding: 15px 10px;
            text-align: left;
        }

        th {

            color: #757575;

        }

        tbody tr:nth-child(odd) {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body style="position:relative;">

    <h3 style="color:#616161;">ใบเสร็จรับเงิน</h3>

    <h4 style="color:#616161; position:absolute; top:50px; right:40px;">เลขที่ #<?php echo $row['reference']; ?></h4>
    <?php
    $date = date("d-m-Y", strtotime($row['date']));
    $day = substr($date, 0, 2);
    $year = substr($date, 6);
    $month = substr($date, 3, 2);
    ?>
    <p style="color:#616161; position:absolute; top:90px; right:40px; font-size:12px;">วันที่เอกสาร: <?php echo $day . "-" . $month . "-" . $year; ?></p>
    <p style="color:#616161; position:absolute; top:105px; right:40px;font-size:12px;">อ้างอิง: #<?php echo $row['reference']; ?></p>

    <img src="logo.png" style="width: 100px; margin-left: 5px;">
    <div style="font-size: 4px;color:#616161;">____________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________</div>
    <div style="line-height: 1.0; font-size: 12px;">
        <p style="color:#616161;"><?php echo $row['firstname'] . " " . $row['lastname']; ?></p>
        <p style="color:#616161;"><?php echo $row['address']; ?></p>
        <p style="color:#616161;">เบอร์โทร <?php echo $row['phone']; ?></p>
        <p style="color:#616161;">อีเมล์ <?php echo $row['email']; ?></p>
    </div>
    <?php if ($row['company'] != "") { ?>
        <div style="line-height: 2.0; font-size: 12px; position:absolute; top: 200px;right: 40px;">
            <p style="color:#616161;">ถึง, <?php echo $row['company']; ?></p>
            <p style="color:#616161;"><?php echo $row['company_address']; ?></p>
            <p style="color:#616161;">เบอร์โทร <?php echo $row['company_phone']; ?></p>
            <p style="color:#616161;">เลขประจำตัวผู้เสียภาษี <?php echo $row['company_tax']; ?></p>
        </div>
    <?php } ?>
    <table>
        <thead style="border-bottom: 3px solid #757575; ">
            <tr>
                <th style="width: 50px; font-size: 16px;">#</th>
                <th style="width: 30px; font-size: 16px;">สินค้า</th>
                <th style="width: 0px; font-size: 16px;">รายละเอียด</th>
                <th style="width: 0px; font-size: 16px;">ราคา</th>
                <th style="width: 0px; font-size: 16px;">จำนวน</th>
                <th style="width: 0px; font-size: 16px;">รวม</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td style="color:#757575;font-weight: bold;">1</td>
                <td style="color:#757575;font-weight: bold;"><?php echo $row['course_name']; ?></td>
                <td style="color:#757575;font-weight: bold;">-</td>
                <td style="color:#757575;font-weight: bold;"><?php echo number_format($row['price']); ?></td>

                <td style="color:#757575;font-weight: bold;"><?php echo number_format($row['amount']); ?></td>
                <td style="color:#757575; font-weight: bold;"><?php echo number_format($row['total_price']); ?></td>
            </tr>

        </tbody>
    </table>
    <div style="line-height: 0.5; font-size: 12px;color:#616161; margin-top:10px;">
        <p style="text-align: right;">รวมจำนวนเงิน : <?php echo number_format($row['total_price']); ?></p>
        <p style="text-align: right;">ส่วนลด : 0</p>
        <p style="text-align: right;">ยอดรวมหลังหักส่วนลด : <?php echo number_format($row['total_price']); ?></p>
        <p style="text-align: right;">ยอดเงินสุทธิ : <?php echo number_format($row['total_price']); ?></p>
        <p style="text-align: right;">จำนวนเงินเป็นตัวอักษร : <?php echo Convert($row['total_price']); ?></p>

    </div>
    <div style="line-height: 0.5;font-size: 12px;color:#616161;">
        <p style="text-align: right; margin-right: 100px; margin-top: 50px; font-size: 12px;color:#616161;">------------------</p>
        <p style="text-align: right; margin-right: 100px; font-size: 12px;color:#616161;">(<?php echo $row['firstname'] . " " . $row['lastname']; ?>)</p>
        <p style="text-align: right; margin-right: 125px; font-size: 12px;color:#616161;">ผู้รับเงิน</p>
        <p>ชำระเงินโดย</p>
        <p>------------------------------------</p>
        <p>เงินสด (โอนเข้าบัญชีธนาคาร)</p>
    </div>
    <?php
    $html = ob_get_contents();
    $mpdf->WriteHTML($html);
    $mpdf->Output("receipt.pdf");
    header('location: receipt.pdf');
    ob_end_flush();

    ?>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
</body>

</html>