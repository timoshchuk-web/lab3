<?php

function clear_data($val){
    $val = trim($val);
    $val = stripcslashes($val);
    $val = strip_tags($val);
    $val = htmlspecialchars($val);

    return $val;
}

$address = clear_data($_POST['Address']);
$email = clear_data($_POST['Email']);
$skype = clear_data($_POST['Skype']);
$phone = clear_data($_POST['phone']);
$Hobby = $_POST['hobby'];
$Contact = $_POST['contact'];

$pattern_phone = "/^\+380\d{3}\d{2}\d{2}\d{2}$/";
$pattern_text = "[A-Za-zА-Яа-яЁё]";
$err  = [];
$flag = 0;

if ($_SERVER['REQUEST_METHOD']== 'POST'){
    if (empty($address)){
        $err['Address'] = '<small class="text-danger">Поле не может быть пустым</small>';
        $flag = 1;
    }elseif (is_numeric($address)){
        $err['Address'] = '<small class="text-danger">Неверно указан формат адреса</small>';
        $flag = 1;
    }
    if (empty($Hobby)){
        $err['hobby'] = '<small class="text-danger">Выберите хотя бы одно увлечение</small>';
        $flag = 1;
    }
    if (empty($skype)){
        $err['Skype'] = '<small class="text-danger">Поле не может быть пустым</small>';
        $flag = 1;
    }elseif (is_numeric($skype)){
        $err['Skype'] = '<small class="text-danger">Неверно указан формат</small>';
        $flag = 1;
    }
    if (empty($email)){
        $err['Email'] = '<small class="text-danger">Поле не может быть пустым</small>';
        $flag = 1;
    }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $err['Email'] = '<small class="text-danger">Неверно указан Email</small>';
        $flag = 1;
    }
    if (empty($phone)){
        $err['phone'] = '<small class="text-danger">Поле не может быть пустым</small>';
        $flag = 1;
    } elseif (!preg_match($pattern_phone, $phone)){
        $err['phone'] = '<small class="text-danger">Неверно указан формат телефона</small>';
        $flag = 1;
    }
    if (empty($Contact)){
        $err['contact'] = '<small class="text-danger">Выберите вид связи</small>';
        $flag = 1;
    }
    if ($flag == 0){
        $fp  = fopen('form-data.json', 'w');
        fwrite($fp, json_encode($_POST));
        fclose($fp);
        Header("Location:". $_SERVER['HTTP_REFERER']."?mes=success");
    }
}

if ($_GET['mes'] == 'success'){
    $err['success'] = '<div class="alert alert-success">Форма успешно отправлена!</div>';
}
