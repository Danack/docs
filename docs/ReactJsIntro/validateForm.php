<?php



$email = null;
$question = null;

$email_error = '';
$question_error = '';

if (array_key_exists('email', $_REQUEST) === true) {
    $email = $_REQUEST['email'];
}


if (array_key_exists('question', $_REQUEST) === true) {
    $question = trim($_REQUEST['question']);
}

$emailParts = explode('@', $email);
if (count($emailParts) < 2) {
    $email_error = "Doesn't look like a valid email";
}

if (strlen($question) < 10) {
    $question_error = "Please enter at least ten characters for your question";
}

$data = [
    'email_error' => $email_error,
    'question_error' => $question_error
];

header("Content-Type: application/json");

echo json_encode($data);