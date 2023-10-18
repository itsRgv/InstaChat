<?php
include_once "config.php";
while ($row = mysqli_fetch_assoc($sql)) {

    $query = "SELECT * FROM messages where (incoming_msg_id = {$row['unique_id']} OR outgoing_msg_id = {$row['unique_id']})
                AND (incoming_msg_id = '{$outgoing_id}' OR outgoing_msg_id = '{$outgoing_id}') ORDER BY msg_id DESC LIMIT 1";
    $sql1 = mysqli_query($conn, $query);
    $row1 = mysqli_fetch_assoc($sql1);
    if (mysqli_num_rows($sql1) > 0)
        $result = $row1['msg'];
    else
        $result = "No messages available";
    (strlen($result) > 28) ? $msg = substr($result, 0, 28) . '...' : $msg = $result;
    $you = "";
    $offline = "";
    if (mysqli_num_rows($sql1) > 0) {
        ($outgoing_id == $row1['outgoing_msg_id']) ? $you = "You: " : $you = "";
    }
    ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";
    $output .= '<a href="chat.php?user_id=' . $row['unique_id'] . '">
        <div class="content">
            <img src="php/images/' . $row['img'] . '"alt="">
            <div class="details">
                <span>' . $row['fname'] . " " . $row['lname'] . '</span>
                <p>' . $you . $msg . '</p>
            </div>
        </div>
        <div class="status-dot ' . $offline . '">
            <i class="fas fa-circle"></i>
        </div>
    </a>';
}
