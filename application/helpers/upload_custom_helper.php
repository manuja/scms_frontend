<?php
/**
 * Created by PhpStorm.
 * User: test
 * Date: 4/23/2018
 * Time: 12:37 PM
 */
$CI->CI =& get_instance();
$CI->CI->load->helper('misc');
$CI->CI->load->library(array('upload'));

function upload_file($uploadPath = 'uploads', $fileName = '', $fieldName = '', $maxSize = 0){

    if(empty($fieldName) || $fieldName == ''){
        $error = array(
            'message' => 'No field name provided',
            'status' => 0
        );
        return $error;
    }
    
    if(empty($fileName) || $fileName == ''){
        $fileName = 'temp-file-'.getDateTimeOneString().'-'.rand(10000000, 99999999);
    }else{
        // getting rid of spaces in file names
        $fileName = preg_replace('/\s+/', '_', $fileName);
    }
    // $extensionStart = strrpos($fileName, '.');
    // $fileNameStart = substr($fileName, 0, $extensionStart);
    // $fileNameStart = preg_replace('/\./', '_', $fileNameStart);
    // $fileNameEnd = substr($fileName, $extensionStart);
   // $fileName = $fileNameStart.time().$fileNameEnd;
   $fileName = $fileName;
    
    $config['upload_path']          = $uploadPath;
    $config['allowed_types']        = 'gif|jpg|png|pdf|jpeg|zip|rar|doc|docx|rar';
    $config['max_size']             = $maxSize;
    $config['file_name']             = $fileName;

    $CI =& get_instance();
    $CI->upload->initialize($config);

    if ( ! $CI->upload->do_upload($fieldName))
    {
//        echo $CI->upload->display_errors('<p>', '</p>');
        $error = array
        (
            'message' => $CI->upload->display_errors(),
            'status' => 0,
            'fileName' => $fileName
        );
        return $error;
    }
    else
    {
//        echo $CI->upload->display_errors('<p>', '</p>');
        $error = array
        (
            'message' => 'Successfully updated',
            'status' => 1,
            'fileName' => $fileName
        );
        return $error;
    }
}

function upload_files($path, $title, $files, $max_size)
{
    $config = array(
        'upload_path'   => $path,
        'allowed_types' => 'jpg|gif|png|pdf|jpeg|doc|xlsx|ods|odt|zip|rar',
        'overwrite'     => 1,
        'max_size' => $max_size? $max_size: 5120
    );

    $fileNames = array();

    $CI =& get_instance();
    $CI->upload->initialize($config);

    $images = array();

    $itr = 1;
    foreach ($files['name'] as $key => $image) {
        $_FILES['images[]']['name']= $files['name'][$key];
        $_FILES['images[]']['type']= $files['type'][$key];
        $_FILES['images[]']['tmp_name']= $files['tmp_name'][$key];
        $_FILES['images[]']['error']= $files['error'][$key];
        $_FILES['images[]']['size']= $files['size'][$key];

        // getting rid of spaces in file names
        $image = preg_replace('/\s+/', '_', $image);
        $fileName = $title .'_'. $itr .'_'. $image; $itr++;

        $extensionStart = strrpos($fileName, '.');
        $fileNameStart = substr($fileName, 0, $extensionStart);
        $fileNameStart = str_replace('.', '_', $fileNameStart);
      
        $fileNameEnd = substr($fileName, $extensionStart);
        $fileName = $fileNameStart.time().$fileNameEnd;
     
        array_push($fileNames, $fileName);
        $images[] = $fileName;
        
        $config['file_name'] = $fileName;

        $CI->upload->initialize($config);

        if ($CI->upload->do_upload('images[]')) {
            $CI->upload->data();
        } else {
            return false;
        }
    }

    return $fileNames;
}

function upload_profile_image($uploadPath = 'uploads', $fileName = '', $fieldName = '', $maxSize = 0){
    if(empty($fieldName) || $fieldName == ''){
        $error = array(
            'message' => 'No field name provided',
            'status' => 0
        );
        return $error;
    }
    
    if(empty($fileName) || $fileName == ''){
        $fileName = 'temp-file-'.getDateTimeOneString().'-'.rand(10000000, 99999999);
    }else{
        // getting rid of spaces in file names
        $fileName = preg_replace('/\s+/', '_', $fileName);
    }   
    $extensionStart = strrpos($fileName, '.');
    $fileNameStart = substr($fileName, 0, $extensionStart);
    $fileNameStart = preg_replace('/\./', '_', $fileNameStart);
    $fileNameEnd = substr($fileName, $extensionStart);
    $fileName = $fileNameStart.time().$fileNameEnd;
    
    $config['upload_path']          = $uploadPath;
    $config['allowed_types']        = 'gif|jpg|png|pdf|jpeg|zip|rar';
    $config['max_size']             = $maxSize;
    $config['file_name']             = $fileName;

    $CI =& get_instance();
    $CI->upload->initialize($config);

    if ( ! $CI->upload->do_upload($fieldName))
    {
        $error = array
        (
            'message' => $CI->upload->display_errors(),
            'status' => 0,
            'fileName' => $fileName
        );
        return $error;
    }
    else
    {
        // create thumbnail for the uploaded image
        $configAfterProcess['image_library'] = 'gd2';
        $configAfterProcess['source_image'] = realpath(__DIR__ . '/../..').'/'.$uploadPath.'/'.$fileName;
        $configAfterProcess['create_thumb'] = TRUE;
        $configAfterProcess['maintain_ratio'] = TRUE;
        $configAfterProcess['width']         = 50;
        $configAfterProcess['height']       = 50;
        
//        echo $configAfterProcess['source_image'];
//        var_dump(file_exists($configAfterProcess['source_image']));

        $CI->load->library('image_lib', $configAfterProcess);

        if ( !$CI->image_lib->resize())
        {
           // echo $CI->image_lib->display_errors();
        }
        
        $error = array
        (
            'message' => 'Successfully updated',
            'status' => 1,
            'fileName' => $fileName
        );
        return $error;
    }
}

function upload_content_image($upload_path, $file_name, $field_name)
{
    $current_dir = getcwd();
    $full_upload_path = $current_dir.'/'.$upload_path;
    $new_file_name = time().str_replace(' ', '', $file_name);

    $config = array(
        'allowed_types' => 'jpg|png|gif',
        'upload_path' => $full_upload_path,
        'file_name' => $new_file_name,
        'max_size' => '10000',
        'overwrite' => true
    );

    $CI =& get_instance();

    $CI->upload->initialize($config);

    if(!$CI->upload->do_upload($field_name)) {
        echo $CI->upload->display_errors();
        die;
    } else {
        $image = $CI->upload->data();
    }

    $location = base_url().$upload_path.$new_file_name;

    echo json_encode(array('location' => $location));
}