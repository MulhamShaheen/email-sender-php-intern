<?php
require_once __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/classes/QueueManager.php';

use Carbon\Carbon;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');


$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];
$database = $_ENV['DB_NAME'];

$conn = new mysqli($servername, $username, $password,$database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

include_once './mail queue/config.php';
$queueManager = new QueueManager($db_options, $mail_options);
print_r($queueManager);

$queueQuery = file_get_contents(__DIR__."/mail queue/create_table_mail_queue.sql");
$conn->multi_query($queueQuery);


$sql = "SELECT * FROM users WHERE confirmed=1 ORDER BY `validts` ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $count = 0;
    while ($row = $result->fetch_assoc()) {

        if (!$row['confirmed'])
            break;

        $today = Carbon::now();
        $expirationDate = Carbon::createFromTimestamp($row['validts']);
        $remainHours = $expirationDate->diffInHours($today) ;


        if ($remainHours < 24 + 24 + 24 + 12){
            print_r($row);
            $msg = $row['username'].", your subscription is expiring soon";
            $subject = "Subscription is expiring";
            $queueManager->addMessages($row['email'],$msg,$subject);
        }
        else{
            break;
        }
    }
    while($queueManager->getQueued()){
        $queueManager->sendMessages(50);
    }

} else {
    echo "0 results";
}
$conn->close();

?>
