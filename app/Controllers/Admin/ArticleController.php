<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    public function index(): void
    {
        $this->requireAdmin();
        $articleModel = new Article();
        $page = (int)($_GET['page'] ?? 1);
        $status = $_GET['status'] ?? null;
        
        $result = $articleModel->getForAdmin($page, ADMIN_PER_PAGE, $status);
        
        $this->view('admin.articles.index', [
            'articles' => $result['items'] ?? [],
            'total' => $result['total'] ?? 0,
            'totalPages' => $result['totalPages'] ?? 1,
            'currentPage' => $result['page'] ?? 1,
            'statusFilter' => $status,
            'pageTitle' => 'Articles',
            'currentStatus' => $status
        ]);
    }

    public function create(): void
    {
        $this->requireAdmin();
        $categoryModel = new Category();
        $categories = $categoryModel->getActive();
        
        $this->view('admin.articles.form', [
            'article' => null,
            'categories' => $categories,
            'pageTitle' => 'New Article'
        ]);
    }

    public function store(): void
    {
        $this->requireAdmin();
        if (!$this->verifyCsrf()) {
            flash('error', 'Invalid token');
            $this->redirect(APP_URL . '/admin/articles/create');
        }

        $user = $this->getCurrentUser();
        $data = $this->getArticleData();
        $data['user_id'] = $user->id;
        
        // Handle image upload
        if (!empty($_FILES['featured_image']['tmp_name'])) {
            $data['featured_image'] = upload_image($_FILES['featured_image'], 'articles');
        }

        // Handle publish
        if ($data['status'] === 'published' && !$data['published_at']) {
            $data['published_at'] = date('Y-m-d H:i:s');
        }

        // Calculate reading time
        $content = $data['content_en'] ?: $data['content_ku'];
        $data['reading_time'] = max(1, ceil(str_word_count(strip_tags($content)) / 200));

        $articleModel = new Article();
        $articleModel->create($data);

        flash('success', 'Article created successfully');
        $this->redirect(APP_URL . '/admin/articles');
    }

    public function edit(string $id): void
    {
        $this->requireAdmin();
        $articleModel = new Article();
        $categoryModel = new Category();
        
        $article = $articleModel->find((int)$id);
        if (!$article) {
            $this->redirect(APP_URL . '/admin/articles');
        }

        $categories = $categoryModel->getActive();
        $tags = $this->db->fetchAll(
            "SELECT t.* FROM lvp_tags t JOIN lvp_article_tags at ON t.id = at.tag_id WHERE at.article_id = ?",
            [$article->id]
        );

        $this->view('admin.articles.form', [
            'article' => $article,
            'categories' => $categories,
            'tags' => $tags,
            'pageTitle' => 'Edit Article'
        ]);
    }

    public function update(string $id): void
    {
        $this->requireAdmin();
        if (!$this->verifyCsrf()) {
            flash('error', 'Invalid token');
            $this->redirect(APP_URL . '/admin/articles/edit/' . $id);
        }

        $data = $this->getArticleData();
        
        if (!empty($_FILES['featured_image']['tmp_name'])) {
            $data['featured_image'] = upload_image($_FILES['featured_image'], 'articles');
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = date('Y-m-d H:i:s');
        }

        $content = $data['content_en'] ?: $data['content_ku'];
        $data['reading_time'] = max(1, ceil(str_word_count(strip_tags($content)) / 200));

        $articleModel = new Article();
        $articleModel->update((int)$id, $data);

        flash('success', 'Article updated successfully');
        $this->redirect(APP_URL . '/admin/articles');
    }

    public function delete(string $id): void
    {
        $this->requireAdmin();
        $articleModel = new Article();
        $articleModel->delete((int)$id);
        
        flash('success', 'Article deleted');
        $this->redirect(APP_URL . '/admin/articles');
    }

    private function getArticleData(): array
    {
        return [
            'category_id' => (int)$this->input('category_id'),
            'title_ku' => $this->sanitize($this->input('title_ku', '')),
            'title_en' => $this->sanitize($this->input('title_en', '')),
            'title_ar' => $this->sanitize($this->input('title_ar', '')),
            'slug_ku' => slugify($this->input('slug_ku', '') ?: $this->input('title_ku', ''), 'ku'),
            'slug_en' => slugify($this->input('slug_en', '') ?: $this->input('title_en', '')),
            'slug_ar' => slugify($this->input('slug_ar', '') ?: $this->input('title_ar', ''), 'ar'),
            'excerpt_ku' => $this->input('excerpt_ku', ''),
            'excerpt_en' => $this->input('excerpt_en', ''),
            'excerpt_ar' => $this->input('excerpt_ar', ''),
            'content_ku' => $this->input('content_ku', ''),
            'content_en' => $this->input('content_en', ''),
            'content_ar' => $this->input('content_ar', ''),
            'video_url' => $this->sanitize($this->input('video_url', '')),
            'audio_url' => $this->sanitize($this->input('audio_url', '')),
            'type' => $this->input('type', 'standard'),
            'status' => $this->input('status', 'draft'),
            'is_featured' => (int)$this->input('is_featured', 0),
            'is_breaking' => (int)$this->input('is_breaking', 0),
            'is_editors_pick' => (int)$this->input('is_editors_pick', 0),
            'allow_comments' => (int)$this->input('allow_comments', 1),
            'meta_title_ku' => $this->sanitize($this->input('meta_title_ku', '')),
            'meta_title_en' => $this->sanitize($this->input('meta_title_en', '')),
            'meta_title_ar' => $this->sanitize($this->input('meta_title_ar', '')),
            'meta_desc_ku' => $this->sanitize($this->input('meta_desc_ku', '')),
            'meta_desc_en' => $this->sanitize($this->input('meta_desc_en', '')),
            'meta_desc_ar' => $this->sanitize($this->input('meta_desc_ar', '')),
            'meta_keywords' => $this->sanitize($this->input('meta_keywords', '')),
            'published_at' => $this->input('published_at', null),
        ];
    }
}
