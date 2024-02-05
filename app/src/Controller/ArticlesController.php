<?php

namespace App\Controller;

use Cake\I18n\FrozenTime;
use Cake\ORM\TableRegistry;
use Cake\View\JsonView;

class ArticlesController extends AppController
{
    public function viewClasses(): array
    {
        return [JsonView::class];
    }
    protected $_articleTable;
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
        $this->_articleTable = TableRegistry::getTableLocator()->get('Articles');
    }

    public function index()
    {
        $articles = $this->Paginator->paginate($this->Articles->find());
        foreach ($articles as $article) {
            $article->created_at = $article->created_at->format('Y-m-d H:i:s');
        }
        $this->set(compact('articles'));
        $this->viewBuilder()->setOption('serialize', ['articles']);
    }

    public function view($articleId)
    {
        $article = $this->Articles->find()
            ->where(['id' => $articleId])
            ->contain('ArticleLikes')->firstOrFail();
        $article->created_at = $article->created_at->format('Y-m-d H:i:s');
        $article->like_status = $this->_articleTable->checkIfUserHasLikedArticle($this->Authentication->getIdentity()->id, $article->id);
        $currentUserInfo = $this->Authentication->getIdentity();

        $this->set(compact('article', 'currentUserInfo'));
        $this->viewBuilder()->setOption('serialize', ['article', 'currentUserInfo']);
    }

    public function add()
    {
        $article = $this->Articles->newEmptyEntity();
        if ($this->request->is('post')) {
            $params = $this->request->getData();
            $nowTime = FrozenTime::now()->format('Y-m-d H:i:s');
            $params['created_at'] = $nowTime;
            $params['updated_at'] = $nowTime;
            $params['user_id'] = $this->Authentication->getIdentity()->id;
            $article = $this->Articles->patchEntity($article, $params);

            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been saved.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Unable to add your article.'));
        }
        $this->set('article', $article);
        $this->viewBuilder()->setOption('serialize', ['article']);
    }

    public function edit($articleId)
    {
        $article = $this->Articles
            ->find()
            ->where(['id' => $articleId])
            ->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Your article has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your article.'));
        }

        $this->set('article', $article);
        $this->viewBuilder()->setOption('serialize', ['article']);
    }

    public function like()
    {
        $requestParams = $this->request->getData();
        $userInfo = $this->Authentication->getIdentity();
        $articleId = $requestParams['article_id'];
        $createdAt = FrozenTime::now()->format('Y-m-d H:i:s');

        if ($this->_articleTable->like($userInfo->id, $articleId, $createdAt)) {
            $this->Flash->success(__('The article has been liked.'));
        } else {
            $this->Flash->error(__('The article could not be liked. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }
}
