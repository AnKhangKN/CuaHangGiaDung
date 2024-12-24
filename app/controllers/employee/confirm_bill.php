<?php

require_once "../../../config/connectdb.php";

$conn = connectBD();

if (isset($_POST['action'])) {
    $idHoaDon = isset($_POST['idHoaDon']) ? intval($_POST['idHoaDon']) : null;

    if (!$idHoaDon) {
        echo json_encode(['status' => 'error', 'message' => 'Missing or invalid Bill ID']);
        exit;
    }

    if ($_POST['action'] === 'confirm') {
        $sql = "UPDATE hoadon SET trangthai = 2 WHERE idHoaDon = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('i', $idHoaDon);
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Bill confirmed successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to confirm the bill']);
            }
            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to prepare SQL statement']);
        }
    } else if ($_POST['action'] === 'cancel') {
        $sql = "UPDATE hoadon SET trangthai = 1 WHERE idHoaDon = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('i', $idHoaDon);
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Bill cancelled successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to cancel the bill']);
            }
            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to prepare SQL statement']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No action provided']);
}

$conn->close();

?>
