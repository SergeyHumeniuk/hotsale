<?php
$Users = [
    ['id' => 1, 'email' => 'ser@ukr.com', 'name' => 'sergey', 'surname'=>'humeniuk', 'password' => '1111'],
    ['id' => 2, 'email' => 'seh@ukr.com', 'name' => 'serhii', 'surname'=>'humeniuk', 'password' => '2222'],
    ['id' => 3, 'email' => 'sergeygumeniuk84@gmail.com', 'name' => 'serhii', 'surname'=>'humeniuk', 'password' => '1111']
];
$logFile = '../logs/logs.txt';
if (isset($_POST['name'])){
    $name = validatePost($_POST['name']);
}else{
    echo 'error';
    exit;
}
if (isset($_POST['surname'])){
    $surname = validatePost($_POST['surname']);
}else{
    echo 'error';
    exit;
}
if (isset($_POST['email'])){
    $email = validatePost($_POST['email']);
}else{
    echo 'error';
    exit;
}
if (isset($_POST['password'])){
    $password = validatePost($_POST['password']);
}else{
    echo 'error';
    exit;
}
if (isset($_POST['confirmPassword'])){
    $confirmPassword = validatePost($_POST['confirmPassword']);
}else{
    echo 'error';
    exit;
}
// Обробка помилки, якщо символ "@" відсутній у рядку
if (strpos($email, '@') === false) {
    echo 'error';
    exit;
}
//виконуємо перевірку чи паролі співпадають і хешуємо пароль
if($password==$confirmPassword){
    $password_enter =  password_hash( $password, PASSWORD_DEFAULT);
}else{
    echo 'error';
}
//перевіряєм чи існує користувач в масиві
$userExists = false;
foreach ($Users as $user) {
    if ($user['email'] === $email) {
        $userExists = true;
        break;
    }
}

// Логуємо результат перевірки в файл
if($userExists){
    $logMessage = 'Email: ' . $email . ' - ' . 'Користувач вже існує';
}else{
    $logMessage = 'Email: ' . $email . ' - ' .  'Новий користувач';
}
$dir = dirname($logFile);
if (!file_exists($dir)) {
    mkdir($dir, 0755, true);
}

$file = fopen($logFile, 'a+'); // Відкриття файлу у режимі запису ('a+')

if ($file) {
    fwrite($file, $logMessage.PHP_EOL); // Запис змісту у файл
    fclose($file); // Закриття файлу
}


// Перевірка успішності реєстрації та відповідь на клієнт
if (!$userExists) {
    // Додавання нового користувача до масиву
    $newUser = array(
        'id' => count($Users) + 1,
        'email' => $email,
        'name' => $name,
        'surname' => $surname,
        'password' => $password_enter
    );
    $Users[] = $newUser;
    echo 'success';
} else {
    echo 'error';
}
//функція валідації пост запросів
function validatePost($data){
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>