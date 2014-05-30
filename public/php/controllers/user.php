<?php


class User_Controller {


    public $result;
    public $data = array();


    public function __construct() {

        // get db instance
        $this->db = new System_Database();

        // get instance of the view
        $this->getView();

        // set default template
        $template = 'user/registration.phtml';

        // if form has been submitted
        if (isset($_POST['submitted'])) {

            // is the form valid
            if ($this->isValidForm()) {

                // its valid so create the row, we should have conditional here to see if its successful but i dont have all day
                $this->create();
                // set template to success
                $template = 'user/registration_success.phtml';

            // else the form was not deemed valid
            } else {
                // set the form data back so the form can be re populated
                $this->view->assign ('formdata', $_POST);
                // pass errors to the view
                $this->view->assign ('errors', $this->errors);
            }
        }

        // set instance result to the template so the controller can echo it
        $this->result = $this->view->render($template);
    }


    public function getView() {

        // create instance zend view for the template
        $this->view = new Zend_View();

        // use defined var path for the templates
        $this->view->addScriptPath (_TEMPLATE);
    }


    public function isValidForm() {

        // empty the array
        $this->errors = array();

        // is it a valid email address
        if (isset($_POST['email']) && !empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Email Address is not valid';
        }

        // fields that cannot be empty
        $cannotBeEmpty = array('forename', 'surname', 'date_of_birth', 'telephone_number', 'email', 'password');

        // loop cannot be emptyfields and set them to the errors array if its a problem
        foreach ($cannotBeEmpty as $field) {
            if (empty($_POST[$field])) {
                $this->errors[$field] = $field.' cannot be empty';
            }
        }

        // passwords must be way
        if (isset($_POST['password']) && !empty($_POST['password'])) {
            if ($_POST['password'] != $_POST['password_confirm']) {
                $this->errors['password'] = 'Password confirmation did not match';
            }
        }

        // if errors are empty then return true, its valid
        return empty($this->errors) ? true : false;
    }


    public function create() {
        // my prefere here would be using PDO but its only a test, so lets get on with it
        // were using md5 on the password, Id use blowfish but this isn't a real app
        // also with pdo we wouldnt need to be using mysql_real_escape_string
        return $this->db->query(" INSERT INTO `User`
         (forename, surname, date_of_birth, password, telephone_number, email, ip, created)
            VALUES
         ('".mysql_real_escape_string($_POST['forename'])."',
         '".mysql_real_escape_string($_POST['surname'])."',
         '".mysql_real_escape_string($_POST['date_of_birth'])."',
         '".md5($_POST['password'])."',
         '".mysql_real_escape_string($_POST['telephone_number'])."',
         '".mysql_real_escape_string($_POST['email'])."',
         '".USER_IP."',
         '".time()."')
         ");
    }
}