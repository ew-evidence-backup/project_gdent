<?php

require_once('../../../../wp-blog-header.php');
header('HTTP/1.1 200 OK');

$allowed = array('png', 'jpg', 'gif', 'zip', 'pdf');

if(isset($_FILES['files']) && $_FILES['files']['error'] == 0) {

    $extension = pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION);

    if(!in_array(strtolower($extension), $allowed)) {
        echo '{"status": "error"}';
        exit;
    }

    if(move_uploaded_file($_FILES['files']['tmp_name'], $_FILES['files']['name'])) {
    	$sub_folder_id = ShareFile::get_item_id($_POST['sfile_sub_folder']);

		$sfile_response = ShareFile::upload_file($sub_folder_id, '/var/www/guidant-financial-portal/wp-content/themes/gfportal/uploads/' . $_FILES['files']['name'], $_POST['sfile_file_name']);

        echo json_encode($sfile_response, true);
        exit;
    }
}

echo '{"status": "error"}';

exit;