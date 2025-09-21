<?php
header('Content-Type: application/json');
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
    $service = $_POST['service'];
    $options = isset($_POST['options']) ? json_decode($_POST['options'], true) : [];
    $quantities = isset($_POST['quantities']) ? json_decode($_POST['quantities'], true) : [];

    $total = 0;

    // Define pricing based on service and options
    switch ($service) {
        case 'vacuum_cleaning':
            foreach ($options as $option) {
                if ($option == 'more_than_1_bedroom') {
                    $quantity = isset($quantities[$option]) ? (int)$quantities[$option] : 1;
                    $price = 500 * $quantity;
                } else {
                    switch ($option) {
                        case 'single_room':
                            $price = 200;
                            break;
                        case 'bedsitter':
                            $price = 300;
                            break;
                        case '1_bedroom':
                            $price = 500;
                            break;
                        default:
                            $price = 0;
                    }
                }
                $total += $price;
            }
            break;

        case 'ironing':
            foreach ($options as $option) {
                $quantity = isset($quantities[$option]) ? (int)$quantities[$option] : 1;
                $price = 10 * $quantity;
                $total += $price;
            }
            break;

        case 'washing_clothes':
            foreach ($options as $option) {
                if ($option == 'handwashing') {
                    $quantity = isset($quantities[$option]) ? (int)$quantities[$option] : 1;
                    $price = 500 * $quantity;
                } elseif ($option == 'laundry_machine') {
                    $quantity = isset($quantities[$option]) ? (int)$quantities[$option] : 1;
                    $price = 250 * $quantity;
                } else {
                    $price = 0;
                }
                $total += $price;
            }
            break;

        case 'washing_shoes':
            foreach ($options as $option) {
                $quantity = isset($quantities[$option]) ? (int)$quantities[$option] : 1;
                $price = 10 * $quantity;
                $total += $price;
            }
            break;

        case 'mopping':
            foreach ($options as $option) {
                switch ($option) {
                    case 'single_room':
                        $quantity = isset($quantities[$option]) ? (int)$quantities[$option] : 1;
                        $price = 70 * $quantity;
                        break;
                    case 'bedsitter':
                        $quantity = isset($quantities[$option]) ? (int)$quantities[$option] : 1;
                        $price = 150 * $quantity;
                        break;
                    case '1_bedroom':
                        $quantity = isset($quantities[$option]) ? (int)$quantities[$option] : 1;
                        $price = 200 * $quantity;
                        break;
                    default:
                        $price = 0;
                }
                $total += $price;
            }
            break;

        case 'cooking':
            foreach ($options as $option) {
                $quantity = isset($quantities[$option]) ? (int)$quantities[$option] : 1;
                $price = 350 * $quantity;
                $total += $price;
            }
            break;

        case 'washing_dishes':
            foreach ($options as $option) {
                $quantity = isset($quantities[$option]) ? (int)$quantities[$option] : 1;
                $price = 250 * $quantity;
                $total += $price;
            }
            break;

        default:
            $total = 0;
    }

    echo json_encode(['total' => $total]);
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>
