<?php 
    class Users extends Controller {

        public function __construct() {
            $this->userModel = $this->model('User');
        }

        public function register() {

            $data = [
                'username' => '',
                'email' => '',
                'password' => '',
                'confirmPassword' => '',
                'usernameError' => '',
                'emailError' => '',
                'passwordError' => '',
                'confirmPasswordError' => ''
            ];

            //Processing the forms
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                //Sanitize the POST DATA
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'username' => trim($_POST['username']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirmPassword' => trim($_POST['confirmPassword']),
                    'usernameError' => '',
                    'emailError' => '',
                    'passwordError' => '',
                    'confirmPasswordError' => ''
                ];

                $nameValidation = "/^[a-zA-Z0-9]*$/";
                $passwordValidation = "/^(.{0,7}|[^a-z]*|[^\d]*)$/i";

                //Validate Username on letters and numbers
                if (empty($data['username'])) {
                    $data['usernameError'] = 'Please enter a username';
                }elseif (!preg_match($nameValidation, $data['username'])) {
                    $data['usernameError'] = 'Name can contain only letters and numbers';
                }

                //Validate email
                if (empty($data['email'])) {
                    $data['emailError'] = 'Please enter an email';

                }elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    $data['emailError'] = 'Please enter the correct email format';
                } else {
                    if ($this->userModel->findUserByEmail($data['email'])) {
                        $data['emailError'] = 'Email is already taken';
                    }
                }

                //Validate password on lenght and numeric values
                if (empty($data['password'])) {
                    $data['passwordError'] = 'Please enter a password';

                }elseif (strlen($data['password']) < 6) {
                    $data['passwordError'] = 'Password must be at least 8 characters';
                }elseif (preg_match($passwordValidation, $data['password'])) {
                    $data['passwordError'] = 'password do not match, please try again';
                }

                //Validate user confirm password
                if (empty($data['confirmPassword'])) {
                    $data['confirmPasswordError'] = 'Please enter a password';
                } else {
                    if ($data['password'] != $data['confirmPassword']) {
                        $data['confirmPasswordError'] = 'Passwords do not match, please try again.';
                    }
                }

                //Make sure the errors are empty
                if (empty($data['usernameError']) && empty($data['emailError']) && empty($data['passwordError']) && empty($data['confirmPasswordError'])) {
                   
                    // Hash password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    if ($this->userModel->register($data)) {
                        
                        //Redirect user to login
                        header('location: ' . URLROOT . '/users/login');
                    } else {
                        die('Something went wrong');
                    }
                }
                
            }
            
            $this->view('users/register', $data);
        }

        public function login () {

            $data =[
                'username' =>'',
                'password' => '',
                'usernameError' => '',
                'passwordError' => ''
            ];

            //Processing the forms
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                //SANITIZE THE POST DATA
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                $data =[
                    'username' => trim($_POST['username']),
                    'password' => trim($_POST['password']),
                    'usernameError' => '',
                    'passwordError' => ''
                ];
                
                //VALIDATE USERNAME
                if (empty($data['username'])) {
                    $data['usernameError'] = 'Please enter a username';
                }
               
                //VALIDATE USERNAME
                if (empty($data['password'])) {
                    $data['passwordError'] = 'Please enter a password';
                }

                if (empty($data['usernameError']) && empty($data['passwordError'])) {

                    //loggedInUser is a success function to start once user login 
                    $loggedInUser = $this->userModel->login($data['username'], $data['password']);

                    if($loggedInUser) {
                        $this->createUserSession($loggedInUser);
                    } else {

                        $data['passwordError'] = 'Password or username is incorrect. Please try again.';

                        $this->view('users/login', $data);

                    }
                }
            } else {
                $data =[
                    'username' =>'',
                    'password' => '',
                    'usernameError' => '',
                    'passwordError' => ''
                ];
            }


            $this->view('users/login', $data);

        }
        

        public function resetPassword() {
            $data = [
                'email' => '',
                'emailError' => '',
                'emailSuccess' => ''   
            ];

            //Processing the forms
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                //SANITIZE THE POST DATA
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                
                $data =[ 
                    'email' => trim($_POST['email']),
                    'emailError' => '',
                    'emailSuccess' => ''
                ];

                 //Validate email
                 if (empty($data['email'])) {
                    $data['emailError'] = 'Please enter an email';

                }elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    $data['emailError'] = 'Please enter the correct email format';

                } 

                if (empty($data['emailError'])) {

                    if($this->userModel->recoverPassword($data)) {
                        $code = rand(999999, 111111);

                        if ($this->userModel->sendToken($data, $code)) {
                            $subject = "Password Reset Code";
                            $message = "Your password reset code is $code";
                            $sender = "From: banksdizzy888@gmail.com";
                            $coderequest = mail($data['email'], $subject, $message, $sender);

                            if ($coderequest) {
                                $this->createUserSession($coderequest);
                                $data['emailSuccess'] = 'We have sent a password reset OTP to your email';
                                // $_SESSION['info'] = $info;
                                // $_SESSION['email'] = $email;
                                header('Location: ' . URLROOT . '/users/resetcode');
                                exit();
                            } else {
                                $data['emailError'] = "Failed while sending code!";
            
                                $this->view('users/resetpassword', $data);
                            }
                        } 

                    } else {
                        $data['emailError'] = "This email address does not exist!";
                    }
            }  
            
        } 
            $this->view('users/resetpassword', $data);
        }

        
        public function resetCode() {

            $data = [

                'code' => '',
                'codeError' => '',
                'codeSuccess' => ''
            ];

            //Processing the forms
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                //SANITIZE THE POST DATA
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data =[ 
                    'code' => trim($_POST['code']),
                    'codeError' => '',
                    'codeSuccess' => ''
                ];

                 //Validate code
                 if (empty($data['code'])) {
                    $data['codeError'] = 'Please enter the code sent to your mail';
                }

                if (empty($data['codeError'])) {
                    $codeReset = $this->userModel->codeReset($data);

                    if ($codeReset) {
                        $this->createUserSession($codeReset);
                        header('Location: ' . URLROOT . '/users/createpassword');
                    } else {
                       $data['codeError'] = 'You have entered incorrect code!';
                    }

                }
        
            }
            $this->view('users/resetcode');
        }
        
        
        public function createpassword() {

            $data = [

                'password' => '',
                'repeatpassword' => '',
                'passwordError' => '',
                'repeatPasswordError' => '',
                'passwordSuccess' => ''
            ];

            //Processing the forms
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                //SANITIZE THE POST DATA
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data =[ 
                    
                    'password' => trim($data['password']),
                    'repeatpassword' => trim($data['repeatpassword']),
                    'passwordError' => '',
                    'repeatPasswordError' => '',
                    'passwordSuccess' => ''
                ];

                    $passwordValidation = "/^(.{0,7}|[^a-z]*|[^\d]*)$/i";
                 
                        // Validate password on length, numeric values,
                    if(empty($data['password'])){
                        $data['passwordError'] = 'Please enter password.';
                    } elseif(strlen($data['password']) < 6){
                        $data['passwordError'] = 'Password must be at least 8 characters';
                    } elseif (preg_match($passwordValidation, $data['password'])) {
                        $data['passwordError'] = 'Password must be have at least one numeric value.';
                    }


                    //Validate confirm password
                    if (empty($data['repeatPassword'])) {
                        $data['repeatPasswordError'] = 'Please enter password.';
                    } else {
                        if ($data['password'] != $data['repeatPassword']) {
                        $data['repeatPasswordError'] = 'Passwords do not match, please try again.';
                        }
                    }


                        // Make sure that errors are empty
                    if (empty($data['passwordError']) && empty($data['repeatPasswordError'])) {

                        
                        $code = 0;
                        $userSession = $_SESSION['email'];
                        // Hash password
                        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
                        
                        if ($this->userModel->updatePassword($code, $userSession, $hashedPassword)) {
                            $data['passwordSuccess'] = "Your password changed. Now you can login with your new password.";
                            header('Location: ' . URLROOT . '/users/login');
                        } else {
                            $data['passwordError'] = "Failed to change your password!";
                        }
                }
        
            }
            $this->view('users/resetcode');
        }



        
        //create session for the user
        public function createUserSession($user) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['email'] = $user->email;
            header('location:' . URLROOT . '/pages/index');
        }

        public function logout() {
            session_start();
            session_unset();
            session_destroy();
            header('location:' . URLROOT . '/users/login');
        }
    }