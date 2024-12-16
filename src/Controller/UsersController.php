<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Users->find();
        $users = $this->paginate($query);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login', 'add', 'forgotPassword']);
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $redirect = $this->Authentication->getLoginRedirect() ?? ['action' => 'dashboard'];
            return $this->redirect($redirect);
        }
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Invalid email or password.');
        }
    }

    public function logout()
    {
        $result = $this->Authentication->getResult();
        if ($result && $result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    public function dashboard()
    {
        $identity = $this->Authentication->getIdentity();
        if (!$identity) {
            $this->Flash->error('Vous devez vous connecter pour accéder au tableau de bord.');
            return $this->redirect(['action' => 'login']);
        }
    
        $dailySleepTable = TableRegistry::getTableLocator()->get('DailySleep');
        $cycles = null;
        $indicator = null;
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $dailySleep = $dailySleepTable->newEmptyEntity();
            $data['user_id'] = $identity->id;
            $data['sleep_date'] = date('Y-m-d');
        
            $data['nap_afternoon'] = isset($data['sieste_apres_midi']) ? (bool)$data['sieste_apres_midi'] : false;
            $data['nap_evening'] = isset($data['sieste_soir']) ? (bool)$data['sieste_soir'] : false;
            $data['morning_score'] = isset($data['forme_reveil']) ? (int)$data['forme_reveil'] : null;
        
            if (!empty($data['sleep_start']) && !empty($data['sleep_end'])) {
                $sleepStart = strtotime($data['sleep_start']);
                $sleepEnd = strtotime($data['sleep_end']);
                if ($sleepEnd < $sleepStart) {
                    $sleepEnd += 24 * 3600;
                }
        
                $totalMinutes = ($sleepEnd - $sleepStart) / 60;
                $cycles = round($totalMinutes / 90, 1);
                $data['cycles'] = $cycles;
                $indicator = (abs($cycles - round($cycles)) <= 0.2) ? 'Cycles optimaux' : 'Cycles insuffisants';
            } else {
                $this->Flash->error('Veuillez saisir les heures de coucher et de lever.');
            }
        
            $dailySleep = $dailySleepTable->patchEntity($dailySleep, $data);
            if ($dailySleepTable->save($dailySleep)) {
                $this->Flash->success('Les informations de sommeil ont été enregistrées.');
            } else {
                $this->Flash->error('Une erreur est survenue lors de l\'enregistrement.');
            }
        }        
    
        $todaySleepData = $dailySleepTable->find('all', [
            'conditions' => [
                'user_id' => $identity->id,
                'sleep_date' => date('Y-m-d'),
            ]
        ])->first();
        $this->set(compact('todaySleepData', 'cycles', 'indicator'));
    }
    
    public function forgotPassword()
    {
        $password = null;
        if ($this->request->is('post')) {
            $email = $this->request->getData('email');
            $user = $this->Users->findByEmail($email)->first();
            if ($user) {
                $temporaryPassword = $this->generateTemporaryPassword();
                $user->password = $temporaryPassword;
                if ($this->Users->save($user)) {
                    $password = $temporaryPassword;
                } else {
                    $this->Flash->error('Une erreur est survenue lors de la mise à jour du mot de passe.');
                }
            } else {
                $this->Flash->error('Aucun utilisateur trouvé avec cet e-mail.');
            }
        }
        $this->set(compact('password'));
    }

    private function generateTemporaryPassword($length = 8)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        return substr(str_shuffle($chars), 0, $length);
    }

    public function editAccount()
    {
        $user = $this->Authentication->getIdentity();
        if (!$user) {
            $this->Flash->error('Vous devez être connecté pour accéder à cette page.');
            return $this->redirect(['action' => 'login']);
        }

        $user = $this->Users->get($user->getIdentifier());
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            if (!empty($data['password']) && $data['password'] === $data['password_confirm']) {
                $user = $this->Users->patchEntity($user, $data);
            } else {
                unset($data['password']);
                unset($data['password_confirm']);
                $user = $this->Users->patchEntity($user, $data, ['validate' => false]);
            }

            if ($this->Users->save($user)) {
                $this->Flash->success('Vos informations ont été mises à jour.');
                return $this->redirect(['action' => 'dashboard']);
            }

            $this->Flash->error('Impossible de mettre à jour vos informations. Veuillez réessayer.');
        }

        $this->set(compact('user'));
    }
}
