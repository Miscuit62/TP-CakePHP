<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\BadRequestException;

class MenusController extends AppController
{
    public function index()
    {
        $menus = $this->paginate($this->Menus);
        $this->set(compact('menus'));
    }

    public function view($id = null)
    {
        $menu = $this->Menus->get($id);
        $this->set(compact('menu'));
    }

    public function add()
    {
        $menu = $this->Menus->newEmptyEntity();
        if ($this->request->is('post')) {
            $menu = $this->Menus->patchEntity($menu, $this->request->getData());
            if ($this->Menus->save($menu)) {
                $this->Flash->success(__('Le menu a été ajouté.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Impossible d\'ajouter le menu. Veuillez réessayer.'));
        }
        $this->set(compact('menu'));
    }

    public function edit($id = null)
    {
        $menu = $this->Menus->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $menu = $this->Menus->patchEntity($menu, $this->request->getData());
            if ($this->Menus->save($menu)) {
                $this->Flash->success(__('Le menu a été modifié.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Impossible de modifier le menu. Veuillez réessayer.'));
        }
        $this->set(compact('menu'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $menu = $this->Menus->get($id);
        if ($this->Menus->delete($menu)) {
            $this->Flash->success(__('Le menu a été supprimé.'));
        } else {
            $this->Flash->error(__('Impossible de supprimer le menu. Veuillez réessayer.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function updateOrder()
    {
        $this->request->allowMethod(['post']);

        $orderData = $this->request->getData('order');

        if (!empty($orderData)) {
            foreach ($orderData as $item) {
                if (!isset($item['id'], $item['ordre'])) {
                    throw new \Cake\Http\Exception\BadRequestException('Données manquantes.');
                }
                $menu = $this->Menus->get($item['id']);
                $menu->ordre = $item['ordre'];
                if (!$this->Menus->save($menu)) {
                    throw new \Cake\Http\Exception\InternalErrorException('Erreur lors de la sauvegarde.');
                }
            }
            return $this->response->withType('application/json')
                ->withStringBody(json_encode(['message' => 'L\'ordre a été mis à jour.']));
        } else {
            throw new \Cake\Http\Exception\BadRequestException('Aucune donnée reçue.');
        }
    }
}
