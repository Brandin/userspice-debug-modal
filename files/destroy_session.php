<?php

require_once '../../../../users/init.php';
if (session_destroy()) {
    echo json_encode('success');
} else {
    echo json_encode('error');
}
