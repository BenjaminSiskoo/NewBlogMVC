<?php 

namespace App\Controller;

use \Core\Controller\Controller;

use \Core\Controller\Helpers\MailController;


class UsersController extends Controller
{
    public function __construct()
    {
        $this->loadModel('users');
    }

    public function signup()
    {
        //inscription
	if(	isset($_POST["lastname"]) && !empty($_POST["lastname"]) &&
    isset($_POST["firstname"]) && !empty($_POST["firstname"]) &&
    isset($_POST["address"]) && !empty($_POST["address"]) &&
    isset($_POST["zipCode"]) && !empty($_POST["zipCode"]) &&
    isset($_POST["city"]) && !empty($_POST["city"]) &&
    isset($_POST["country"]) && !empty($_POST["country"]) &&
    isset($_POST["phone"]) && !empty($_POST["phone"]) &&
    isset($_POST["mail"]) && !empty($_POST["mail"]) &&
    isset($_POST["mailVerify"]) && !empty($_POST["mailVerify"]) &&
    isset($_POST["password"]) && !empty($_POST["password"]) &&
    isset($_POST["passwordVerify"]) && !empty($_POST["passwordVerify"])//&&
    //isset($_POST["robot"]) && empty($_POST["robot"])//protection robot
){
    
    if(
        ( 	filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL) && 
            $_POST["mail"] == $_POST["mailVerify"]
        ) &&
        ( $_POST["password"] == $_POST["passwordVerify"])
    ){
        $mail = $_POST["mail"];
        $user=$this->users->verifMail($mail);
    
        if(!$user){
            $password = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_BCRYPT);
            
            $createdAt = time();
            $token = md5($createdAt);
            $arrayUser = [
                ":lastname"		=> htmlspecialchars($_POST["lastname"]),
                ":firstname"	=> htmlspecialchars($_POST["firstname"]),
                ":address"		=> htmlspecialchars($_POST["address"]),
                ":zipCode"		=> htmlspecialchars($_POST["zipCode"]),
                ":city"			=> htmlspecialchars($_POST["city"]),
                ":country"		=> htmlspecialchars($_POST["country"]),
                ":phone"		=> htmlspecialchars($_POST["phone"]),
                ":mail"			=> htmlspecialchars($_POST["mail"]),
                ":password"		=> $password,
                ":token"		=> $token
            ];

            $resultUser=$this->users->userCreate($arrayUser);

            if($resultUser){
                //userConnect($_POST["mail"], $_POST["password"]);
                $subject = "Activer votre compte";
                $sendmail = ["html" => '<h1>Bienvenue sur notre site</h1><p>Pour activer votre compte, veuillez cliquer sur le lien ci dessous ou copier/coller dans votre navigateur internet:</p><br /><a href="http://localhost/signin/'.urlencode($_POST["mail"]).'-'.urlencode($token).'">cliquez pour valider votre compte</a><hr><p>Ceci est un mail automatique, Merci de ne pas y répondre.</p>'];
                //dd($sendmail);
                $mailcontroller = new MailController();
                //dd($mailcontroller);
                $mailcontroller->sendMail($subject, $mail, $sendmail);
                header('location: /');
                exit();
            }else{
                die("pas ok");
                //TODO : signaler erreur
                }
            }
        }
    }//fin verification mail et password

    
        $title = 'My Bread Beer Inscription';
        return $this->render(
            'users/signup',
            [
                "title" => $title
            ]
        );
    }

    public function signin()
    {

        if (isset($_POST)){
            
        }
        $title = 'My Bread Beer Connexion';
        return $this->render(
            'users/signin',
            [
                "title" => $title
            ]
        );
    }
}