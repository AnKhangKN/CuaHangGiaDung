<?php

require_once __DIR__ . '/../../../vendor/tfpdf/tfpdf.php';
require_once __DIR__ . '/customerController.php';
require_once __DIR__ . '/../../../config/connectdb.php';

$pdf = new tFPDF();
$pdf->AddPage("P", "A4");

// Add a Unicode font (uses UTF-8)
$pdf->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);

// Logo và tiêu đề
$pdf->Image(__DIR__ . '/../../../public/assets/images/logo_trang.jpg', 10, 10, 30);
$pdf->SetFont('DejaVu', '', 16);
$pdf->Cell(0, 10, 'HÓA ĐƠN BÁN HÀNG', 0, 1, 'C');
$pdf->SetFont('DejaVu', '', 12);
$pdf->Cell(0, 10, 'Cửa hàng HKN - Uy tín và chất lượng', 0, 1, 'C');
$pdf->Ln(15);

// Thông tin khách hàng
$pdf->SetFont('DejaVu', '', 12);
$pdf->Cell(0, 8, 'Thông tin khách hàng:', 0, 1);
$pdf->SetFont('DejaVu', '', 11);

$customerInfo = getCustomerInfoByBillId($_GET['idBill']); 
$pdf->Cell(0, 8, 'Họ và tên: ' . $customerInfo['tenkhachhang'], 0, 1);
$pdf->Cell(0, 8, 'Số điện thoại: ' . $customerInfo['sdt'], 0, 1);
$pdf->Cell(0, 8, 'Địa chỉ: ' . $customerInfo['diachi'], 0, 1);

$pdf->Ln(10);

// Bảng chi tiết đơn hàng
$pdf->SetFillColor(193, 229, 252);
$pdf->SetFont('DejaVu', '', 12);

$width_cell = array(15, 55, 30, 40, 20, 30);
$pdf->Cell($width_cell[0], 10, 'Mã', 1, 0, 'C', true);
$pdf->Cell($width_cell[1], 10, 'Tên sản phẩm', 1, 0, 'C', true);
$pdf->Cell($width_cell[2], 10, 'Màu sắc', 1, 0, 'C', true);
$pdf->Cell($width_cell[3], 10, 'Kích thước', 1, 0, 'C', true);
$pdf->Cell($width_cell[4], 10, 'Số lượng', 1, 0, 'C', true);
$pdf->Cell($width_cell[5], 10, 'Đơn giá', 1, 1, 'C', true);

// Nội dung chi tiết
$pdf->SetFillColor(235, 236, 236);
$fill = false;
$pdf->SetFont('DejaVu', '', 11);

$idBill = $_GET['idBill'];
$detailsBill = getAllDetailBillByIdBillWithProductName($idBill);

if (empty($detailsBill)) {
    $pdf->Cell(0, 10, 'Không tìm thấy đơn hàng.', 0, 1);
    $pdf->Output();
    exit;
}

foreach ($detailsBill as $row) {
    $pdf->Cell($width_cell[0], 10, $row['idSanPham'], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[1], 10, $row['tensanpham'], 1, 0, 'L', $fill);
    $pdf->Cell($width_cell[2], 10, $row['mausac'], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[3], 10, $row['kichthuoc'], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[4], 10, $row['soluong'], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[5], 10, number_format($row['dongia'], 0, ',', '.') . ' VND', 1, 1, 'C', $fill);
    $fill = !$fill;
}

$pdf->Ln(10);
$pdf->SetFont('DejaVu', '', 11);
$pdf->Cell(0, 8, 'Tổng đơn hàng: ' . number_format($customerInfo['tongtien'], 0, ',', '.') . ' VND', 0, 1, 'R');

// Footer
$pdf->Ln(15);
$pdf->SetFont('DejaVu', '', 11);
$pdf->Cell(0, 10, 'Cảm ơn bạn đã mua hàng tại HKN!', 0, 1, 'C');
$pdf->Cell(0, 10, 'Hotline: 1900 123 456', 0, 1, 'C');

$pdf->Output('I', 'HoaDon_' . $_GET['idBill'] . '.pdf');
