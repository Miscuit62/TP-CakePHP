<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\BadRequestException;

/**
 * @property \App\Model\Table\DailySleepTable $DailySleep
 */
class SleepController extends AppController
{
    /**
     * @var \App\Model\Table\DailySleepTable
     */
    private $DailySleep;

    public function initialize(): void
    {
        parent::initialize();
        $this->DailySleep = $this->fetchTable('DailySleep');
    }

    public function index()
    {
        $dailySleepRecords = $this->paginate($this->DailySleep);
        $this->set(compact('dailySleepRecords'));
    }

    public function view($id = null)
    {
        $dailySleep = $this->DailySleep->get($id);
        $this->set(compact('dailySleep'));
    }

    public function add()
    {
        $identity = $this->Authentication->getIdentity();
        if (!$identity) {
            $this->Flash->error('Vous devez être connecté pour ajouter un enregistrement de sommeil.');
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
        $dailySleep = $this->DailySleep->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['user_id'] = $identity->get('id'); 
            $data['sleep_date'] = date('Y-m-d');

            if (!empty($data['sleep_start']) && !empty($data['sleep_end'])) {
                $sleepStart = strtotime($data['sleep_start']);
                $sleepEnd = strtotime($data['sleep_end']);
                if ($sleepEnd < $sleepStart) {
                    $sleepEnd += 24 * 3600;
                }
                $totalMinutes = ($sleepEnd - $sleepStart) / 60;
                $data['cycles'] = round($totalMinutes / 90, 1);
            } else {
                $data['cycles'] = 0;
            }
            $data['morning_score'] = isset($data['morning_score']) ? (int)$data['morning_score'] : null;
            $dailySleep = $this->DailySleep->patchEntity($dailySleep, $data);

            if ($this->DailySleep->save($dailySleep)) {
                $this->Flash->success(__('Les informations de sommeil ont été ajoutées.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Impossible d\'ajouter l\'enregistrement de sommeil. Veuillez réessayer.'));
        }
        $this->set(compact('dailySleep'));
    }

    public function edit($id = null)
    {
        $dailySleep = $this->DailySleep->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dailySleep = $this->DailySleep->patchEntity($dailySleep, $this->request->getData());
            if ($this->DailySleep->save($dailySleep)) {
                $this->Flash->success(__('L\'enregistrement de sommeil a été modifié.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Impossible de modifier l\'enregistrement de sommeil. Veuillez réessayer.'));
        }
        $this->set(compact('dailySleep'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $dailySleep = $this->DailySleep->get($id);
        if ($this->DailySleep->delete($dailySleep)) {
            $this->Flash->success(__('L\'enregistrement de sommeil a été supprimé.'));
        } else {
            $this->Flash->error(__('Impossible de supprimer l\'enregistrement de sommeil. Veuillez réessayer.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function weeklySummary()
    {
        $startOfWeek = date('Y-m-d', strtotime('monday this week'));
        $endOfWeek = date('Y-m-d', strtotime('sunday this week'));
        $identity = $this->Authentication->getIdentity();
        if (!$identity) {
            $this->Flash->error('Vous devez vous connecter pour accéder au résumé hebdomadaire.');
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $userId = $identity->get('id');
        $dailySleepTable = $this->fetchTable('DailySleep');
        $weeklyData = $dailySleepTable->find('all', [
            'conditions' => [
                'user_id' => $userId,
                'sleep_date >=' => $startOfWeek,
                'sleep_date <=' => $endOfWeek,
            ],
            'order' => ['sleep_date' => 'ASC']
        ])->toArray();

        $totalCycles = array_reduce($weeklyData, function ($sum, $day) {
            return $sum + $day->cycles;
        }, 0);
        
        $consecutiveDaysWith5Cycles = 0;
        $maxConsecutiveDays = 0;
        foreach ($weeklyData as $day) {
            if ($day->cycles >= 5) {
                $consecutiveDaysWith5Cycles++;
                $maxConsecutiveDays = max($maxConsecutiveDays, $consecutiveDaysWith5Cycles);
            } else {
                $consecutiveDaysWith5Cycles = 0;
            }
        }

        $indicators = [
            'totalCyclesGreen' => $totalCycles >= 42,
            'consecutiveDaysGreen' => $maxConsecutiveDays >= 4,
        ];

        $labels = array_map(fn($day) => $day->sleep_date, $weeklyData);
        $cyclesData = array_map(fn($day) => $day->cycles ?? 0, $weeklyData);
        $labels = array_map(fn($day) => $day->sleep_date, $weeklyData);
        $this->set(compact('weeklyData', 'totalCycles', 'indicators', 'startOfWeek', 'endOfWeek', 'labels', 'cyclesData'));
    }
}
