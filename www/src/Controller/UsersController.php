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

    public function signin(string $mail = null, string $token = null, $verify = false)
    { 
        if(	isset($_POST["mail"]) && !empty($_POST["mail"]) &&
		isset($_POST["password"]) && !empty($_POST["password"])
        ){
            $mail = $_POST["mail"];
            $password = $_POST["password"];
            //dd($mail);
            $login = $this->users->userConnect($mail);
            //dd($login);
            if($login && password_verify(htmlspecialchars($password), $login->getPassword()) && $login->getVerify() == 1) {
                //dd($password);
                if($verify){
                    return true;
                    //exit();
                }
                
                $login->setPassword(""); //sécurisation en supprimant le mot de passe via la session
                //dd($login);
                $_SESSION['auth'] = $login;
                //connecté
                header('location: /');
                exit();
        
            }else{
    
                if($verify){
                    return false;
                    //exit();
                }
                if (session_status() != PHP_SESSION_ACTIVE){
                    session_start();
                }
                $_SESSION['auth'] = false;
                header('location: /signin');
                exit();
                //TODO : err pas connecté
            }
        }

        $message = false;

        if($token)
        {
            $token = urldecode($token);
            $mail = urldecode($mail);

            //récupération du token et le verify (actif) correspondant au mail dans la db
            $user = $this->users->confirmMail($mail);
            
            if ($user){
                $tokendb = $user->getToken();//recupération du token
                $verify = $user->getVerify();//verify est à 0 ou 1
            }
            // On teste la valeur de la variable $actif récupéré dans la BDD
            if($verify == '1') // Si le compte est déjà actif on prévient
                {
                $message = "Votre compte est déjà actif !";
                }
            else // Si ce n'est pas le cas on passe aux comparaisons
                {
             if($token == $tokendb) // On compare nos deux clés	
                {
              // Si elles correspondent on active le compte !	
                $message = "Votre compte a bien été activé !";
    
              // La requête qui va passer notre champ verify de 0 à 1
                $updateVerify = $this->users->updateVerifyMail($mail);
                }
            else // Si les deux clés sont différentes on provoque une erreur...
                {
                $message = "Erreur ! Votre compte ne peut être activé...";
                dd($token);
                }
            }
        }

        $title = 'My Bread Beer Connexion';
        return $this->render(
            'users/signin',
            [
                "title" => $title,
                "message" => $message
            ]
        );
    }

    public function disconnect()
    {
        unset($_SESSION['auth']);
        header('Location: /');
        exit();
    }

    public function contact()
    {
        $title = 'My Bread Beer Contact';
        return $this->render(
            'users/contact',
            [
                "title" => $title
            ]
        );

    }

    public function profil()
    {
        if ($_POST['user_button']=='user_button')
        {
            $id = $_SESSION['auth']->getId();
            $lastname = $_POST['lastname'];
            $firstname = $_POST['firstname'];
            $address = $_POST['address'];
            $zipCode = $_POST['zipCode'];
            $city = $_POST['city'];
            $country = $_POST['country'];
            $phone = $_POST['phone'];
            if (!empty($lastname && $firstname && $address && $zipCode && $city && $country && $phone))
            {
                $arrayUserInfo = [$lastname, $firstname, $address, $zipCode, $city, $country, $phone, $id];
                $results = $this->users->updateUserInfo($arrayUserInfo, $id);
                $_SESSION['auth']=$this->users->find($id);
                if($results){
                    header('Location: /profil');
                    exit();
                }
            }
        }



        $title = 'My Bread Beer Profil';
        return $this->render(
            'users/profil',
            [
                "title" => $title
            ]
        );
    }
}