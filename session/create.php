<?php 
    include('../configuration.php');
?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if ($email === null) {
        http_response_code(400);
        header('Content-type: application/json');
        $response_array = array(
            'status' => 'error',
            'message' => 'Email not given'
        );
        echo json_encode($response_array);
    } elseif ($email === false) {
        http_response_code(400);
        header('Content-type: application/json');
        $response_array = array(
            'status' => 'error',
            'message' => 'Invalid email'
        );
        echo json_encode($response_array);
    } else {
        $password = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);

        if($password === null){
            http_response_code(400);
            header('Content-type: application/json');
            $response_array = array(
                'status' => 'error',
                'message' => 'Password not given'
            );
            echo json_encode($response_array);
        }else{

            include '../configuration.php';
            // Create connection


            $connection = new mysqli(
                $database_configuration['servername'],
                $database_configuration['username'],
                $database_configuration['password'],
                $database_configuration['database']
            );

            if ($connection->connect_error) {
                http_response_code(500);
                header('Content-type: application/json');
                $response_array = array(
                    'status' => 'error',
                    'message' => 'Try again later'
                );
                echo json_encode($response_array);
                exit;
            }

            if (!($statement = $connection->prepare("SELECT id, password FROM users WHERE email = ? "))) {
                http_response_code(500);
                header('Content-type: application/json');
                $response_array = array(
                    'status' => 'error',
                    'message' => 'Try again later'
                );
                echo json_encode($response_array);
                exit;
            }

            require '../password_compat.php';

            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            if (!$statement->bind_param('s', $email)) {
                header('Content-type: application/json');
                $response_array = array(
                    'status' => 'error',
                    'message' => 'Try again later'
                );
                echo json_encode($response_array);
                exit;
            }

            if (!$statement->execute()) {

                    http_response_code(500);
                    header('Content-type: application/json');
                    $response_array = array(
                        'status' => 'error',
                        'message' => 'Try again later'
                    );
                    echo json_encode($response_array);
                    exit;

            }

            $out_password = null;
            $out_id = null;

            if (!$statement->bind_result($out_id, $out_password)) {
                http_response_code(500);
                header('Content-type: application/json');
                $response_array = array(
                    'status' => 'error',
                    'message' => 'Try again later'
                );
                echo json_encode($response_array);
                exit;
            }

            require '../password_compat.php';

            while($statement->fetch()){
                if(password_verify($password, $out_password)){
                    session_start();
                    $_SESSION['email'] = $email;
                    $_SESSION['id'] = $out_id;

                    header('Content-type: application/json');
                    $response_array = array(
                        'status' => 'success',
                        'message' => 'logged in'
                    );
                    echo json_encode($response_array);
                    $statement->close();
                    exit;
                }else{
                    http_response_code(401);
                    header('Content-type: application/json');
                    $response_array = array(
                        'status' => 'error',
                        'message' => 'Unauthorized'
                    );
                    echo json_encode($response_array);
                    $statement->close();
                    exit;
                }
            }

        }


    }



} else {
    http_response_code(405);
}

?>