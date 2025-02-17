<?php
require_once("../main_function.php");
require_once("pagination.php");

$obj = new operation;
include_once("header.php");
include_once("menu.php");

// Fetch necessary data
$users = $obj->get_all_users();
$all_status = $obj->get_all_status();
$campaignLists = $obj->get_all_campagin_type(2);
?>

<style type="text/css">
/* General Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
}

.container {
    width: 90%;
    height: 70vh;
    margin: 50px auto; /* Center the container horizontally and add margin from the top */
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
}
/* Styling for tables */

.table-container {
    width: 100%;
    text-align: center;
}
.table-container h2 {
    font-size: 20px;
    margin: 0;
    padding: 10px;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin: 0;
}

table th, table td {
    padding: 8px;
    font-size: 11px;
    text-align: left;
    border: 1px solid #ddd;
}
table th {
    background-color: #f2f2f2;
    text-align: center;
}
table tbody tr:hover {
    background-color: #f9f9f9;
}
.no-data {
    text-align: center;
    padding: 20px;
    font-size: 14px;
    color: #888;
}
</style>

<!DOCTYPE html>
<html lang="en">

<body>
<div class="container">
    <!-- Single Table for All Data -->
    <div class="table-container">
        <h2>Registered Membership Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Organization Name (In Bangla)</th>
                    <th>General Member No</th>
                    <th>TIN No</th>
                    <th>Registration No</th>
                    <th>TRADE LICENCE NO</th>
                    <th>Hospital Info</th>
                    <th>Diagnostic Center Info</th>
                    <th>PAY-ORDER No</th>
                    <th>Proposer Name</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($members)): ?>
                    <?php foreach ($members as $member): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($member->institute_bname); ?></td>
                        <td><?php echo htmlspecialchars($member->generalmember_no); ?></td>
                        <td><?php echo htmlspecialchars($member->tin_no); ?></td>
                        <td><?php echo htmlspecialchars($member->reg_no); ?></td>
                        <td><?php echo htmlspecialchars($member->trade_no); ?></td>
                        <td><?php echo htmlspecialchars($member->hospital_info); ?></td>
                        <td><?php echo htmlspecialchars($member->diagnostic_selected); ?></td>
                        <td><?php echo htmlspecialchars($member->payorder_no); ?></td>
                        <td><?php echo htmlspecialchars($member->proposer_name); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="no-data">No data available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>