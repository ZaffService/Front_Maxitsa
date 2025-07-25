<?php
namespace App\Controllers;
use App\Core\Abstract\AbstractController;
use App\Services\SecurityService;
use App\Entities\User;
use App\Repositories\UserRepository;
use App\Repositories\CompteRepository;
use App\Entities\Compte;
use App\Core\FileService;
use App\Core\Validator;
use App\Core\Session;
use App\Core\App;
use App\Services\SmsService;

class SecurityController extends AbstractController
{
    private SecurityService $securityService;
    private CompteRepository $compteRepository;
    private SmsService $smsService;

    public function __construct()
    {
        parent::__construct();
        $this->layout = 'security.layout.php';
        $this->compteRepository = App::getDependencie('CompteRepository');
        $this->securityService = App::getDependencie('SecurityService');
        $this->smsService = new SmsService();
    }

    public function login()
    {
        // Initialiser $validator à null
        $validator = null;
        $success = $this->session->unset('success') ?? '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rules = [
                'telephone' => ['required', 'length:9', 'phone'],
                'password' => ['required'],
            ];
          
            $validator = Validator::make($_POST, $rules);
            
            if ($validator->validate()) {
                $telephone = trim($_POST['telephone']);
                $password = trim($_POST['password']);
                
                error_log("Tentative de connexion - Téléphone: $telephone");
                error_log("Mot de passe fourni: $password"); // Ajout de log
                
                $userData = $this->securityService->login($telephone, $password);
                
                if ($userData) {
                    error_log("Connexion réussie pour: " . $userData['user']->getNom()); // Ajout de log
                    $this->session->set('user', $userData);
                    $this->redirect('/client/dashboard');
                    exit();
                } else {
                    error_log("Échec de la connexion"); // Ajout de log
                    $this->session->set('general_error', 'Identifiants incorrects');
                }
            }
        }

        $this->render("auth/login", [
            'success' => $success,
            'old' => $_POST ?? [],
            'fieldErrors' => $validator ? $validator->errors() : []
        ]);
    }
    public function logout()
    {
        $this->session->destroy();
        header('Location: /');
        exit();
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérifier d'abord si le numéro de téléphone existe déjà
            if ($this->compteRepository->isNumeroTelephoneUnique($_POST['numero_telephone']) === false) {
                $this->session->set('errors', [
                    'numero_telephone' => ['Ce numéro de téléphone est déjà utilisé']
                ]);
                $this->render('auth/register', [
                    'old' => $_POST,
                    'errors' => ['numero_telephone' => ['Ce numéro de téléphone est déjà utilisé']]
                ]);
                return;
            }

            // Vérifier si le numéro CNI existe déjà
            $userRepo = App::getDependencie('UserRepository');
            if ($userRepo->isUnique('numero_cni', $_POST['numero_cni']) === false) {
                $this->session->set('errors', [
                    'numero_cni' => ['Ce numéro CNI est déjà utilisé']
                ]);
                $this->render('auth/register', [
                    'old' => $_POST,
                    'errors' => ['numero_cni' => ['Ce numéro CNI est déjà utilisé']]
                ]);
                return;
            }

            $rules = [
                'nom' => ['required'],
                'prenom' => ['required'],
                'numero_cni' => ['required', 'length:13'],
                'numero_telephone' => ['required', 'phone'],
                'photorecto' => ['file', 'mimes:jpeg,png,jpg', 'max:2000000'],
                'photoverso' => ['file', 'mimes:jpeg,png,jpg', 'max:2000000'],
                'password' => ['required'],
            ];

            $data = array_merge($_POST, $_FILES);
            $validator = Validator::make($data, $rules);
            
            if ($validator->validate()) {
                try {
                    $userData = $_POST;
                    $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
                    
                    $user = User::toObject($userData);
                    $compte = new Compte(
                        0,
                        0.0,
                        'Principal',
                        $_POST['numero_telephone'],
                        0
                    );

                    $userId = $this->securityService->registerUserWithCompte($user, $compte);
                  
                    if ($userId !== false) {
                        $this->session->set('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
                        $this->redirect('/');
                        exit;
                    }
                } catch (\Exception $e) {
                    error_log("Erreur inscription: " . $e->getMessage());
                    $this->session->set('errors', ['Une erreur est survenue lors de l\'inscription']);
                }
            }
            
            $this->render('auth/register', [
                'old' => $_POST,
                'errors' => $validator->errors()
            ]);
            return;
        }

        $this->render('auth/register');
    }
}