<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="value"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registation User</title>
    <style type="text/css">
        .nhapvao {
            width: 230px;
            margin: 0;
            padding: 10px;
            border: 1px #CCC solid;
        }

        h2 {
            text-align: center;
        }

        .nhapvao input {
            padding: 5px;
            margin: 5px
        }
    </style>

</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST["user"];
    $email = $_POST["email"];
    $phone = $_POST["tel"];
    $isError = false;
    if (empty($name)) {
        $errName = "Khong duoc de trong ten!";
        $isError = true;
    }
//    var_dump($email);
    if (empty($email)) {
        $errEmail = "Khong duoc de trong email!";
        $isError = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errEmail = "Sai dinh dang email";
        $isError = true;
    }
    if (empty($phone)) {
        $errPhone = "Khong duoc de trong so dien thoai!";
        $isError = true;
    }
    if ($isError === false) {
        saveDataJSON("users.json", $name, $email, $phone);
        $name = null;
        $email = null;
        $phone = null;
    }
}

function loadRegistrations($filename)
{
    $jsondata = file_get_contents($filename);
    $arrData = json_decode($jsondata, true);
    return $arrData;
}
//print_r(loadRegistrations("users.json"));
function saveDataJSON($filename, $name, $email, $phone)
{
    try {
        $info = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ];
        //convert data to array
        $arrData = loadRegistrations($filename);
        //push data to array
        array_push($arrData, $info);

        //convert update arr to json
        $jsondata = json_encode($arrData, JSON_PRETTY_PRINT);
        //print json data to data.json
        file_put_contents($filename, $jsondata);

        echo "Luu du lieu thanh cong";
    } catch (Exception $e) {
        echo "Message: " . $e->getMessage() . "\n";
    }
}

echo loadRegistrations("users.json");
?>
<form method="post">
    <div class="nhapvao">
        <h2>Registation user </h2>
        <label>
            User name:<span><?= $errName; ?></span>
            <input type="text" name="user" size="20"/>
        </label>
        <label>
            Email:<span><?= $errEmail; ?></span>
            <input type="text" name="email" size="20"/>
        </label>
        <label>
            Phone:<span><?= $errPhone; ?></span>
            <input type="text" name="tel" size="20"/>
        </label>
        <input type="submit" value="send"/>
    </div>
</form>

</body>
</html>