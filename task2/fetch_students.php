<?php
$conn = new mysqli("localhost", "root", "", "college");

$sort = $_GET['sort'] ?? 'name';
$order = ($sort == 'dob') ? 'dob' : 'name';

$dept = $_GET['department'] ?? '';

$where = "";
if ($dept != "") {
    $where = "WHERE department='$dept'";
}

$sql = "SELECT * FROM students $where ORDER BY $order";
$result = $conn->query($sql);

$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}

/* Count per department */
$countResult = $conn->query(
    "SELECT department, COUNT(*) as total FROM students GROUP BY department"
);
$counts = [];
while ($row = $countResult->fetch_assoc()) {
    $counts[] = $row;
}

echo json_encode([
    "students" => $students,
    "counts" => $counts
]);
?>
