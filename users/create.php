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
                    'message' => 'Try again later 1'
                );
                echo json_encode($response_array);
                exit;
            }
            if (!($statement = $connection->prepare("INSERT INTO cs361_users(email, password) VALUES(?,?) "))) {
                http_response_code(500);
                header('Content-type: application/json');
                $response_array = array(
                    'status' => 'error',
                    'message' => 'Try again later 2'
                );
                echo json_encode($response_array);
                exit;
            }
            require '../../password_compat.php';
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            if (!$statement->bind_param('ss', $email, $password_hash)) {
                header('Content-type: application/json');
                $response_array = array(
                    'status' => 'error',
                    'message' => 'Try again later 3'
                );
                echo json_encode($response_array);
                exit;
            }
            
            if (!$statement->execute()) {
                if ($statement->errno == 1062) {
                    http_response_code(409);
                    header('Content-type: application/json');
                    $response_array = array(
                        'status' => 'error',
                        'message' => 'Email already registered'
                    );
                    echo json_encode($response_array);
                    exit;
                } else {
                    http_response_code(500);
                    header('Content-type: application/json');
                    $response_array = array(
                        'status' => 'error',
                        'message' => 'Try again later 4'
                    );
                    echo json_encode($response_array);
                    exit;
                }
            }
            $statement->close();
            header('Content-type: application/json');
            $response_array = array(
                'status' => 'success',
                'message' => 'user created'
            );
            echo json_encode($response_array);
            exit;
        }
        
        
    }
    
    
} else {
    http_response_code(405);
}
?>