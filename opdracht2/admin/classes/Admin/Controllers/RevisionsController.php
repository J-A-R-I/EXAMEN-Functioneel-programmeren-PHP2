<?php
declare(strict_types=1);

namespace Admin\Controllers;

use Admin\Core\Flash;
use Admin\Core\View;
use Admin\Repositories\PostsRepository;
use Admin\Repositories\RevisionsRepository;

final class RevisionsController
{
    private RevisionsRepository $revisions;
    private PostsRepository $posts;

    public function __construct(RevisionsRepository $revisions, PostsRepository $posts)
    {
        $this->revisions = $revisions;
        $this->posts = $posts;
    }

    /**
     * Overzicht van alle revisies (admin-tab).
     */
    public function index(): void
    {
        $items = $this->revisions->getAllWithPost();

        View::render('revisions.php', [
            'title' => 'Revisies',
            'items' => $items,
        ]);
    }

    /**
     * Detail-overzicht per post (optioneel, voor link vanuit posts-index).
     */
    public function showByPost(string $slug): void
    {
        $slug = urldecode($slug);
        $post = $this->posts->findBySlug($slug);

        if (!$post) {
            Flash::set('error', 'Post niet gevonden.');
            header('Location: ' . ADMIN_BASE_PATH . '/revisions');
            exit;
        }

        $revisions = $this->revisions->getAllByPostId((int)$post['id']);

        View::render('post-revisions.php', [
            'title' => 'Revisies voor post',
            'post' => $post,
            'revisions' => $revisions,
        ]);
    }

    /**
     * Toon een specifieke revisie in vergelijking met de huidige post.
     */
    public function show(string $slug, int $id): void
    {
        $slug = urldecode($slug);
        $post = $this->posts->findBySlug($slug);

        if (!$post) {
            Flash::set('error', 'Post niet gevonden.');
            header('Location: ' . ADMIN_BASE_PATH . '/revisions');
            exit;
        }

        $revision = $this->revisions->findById($id);

        if (!$revision || (int)$revision['post_id'] !== (int)$post['id']) {
            Flash::set('error', 'Revisie niet gevonden of hoort niet bij deze post.');
            header('Location: ' . ADMIN_BASE_PATH . '/posts/' . urlencode($slug) . '/revisions');
            exit;
        }

        View::render('revision-show.php', [
            'title' => 'Revisie details',
            'post' => $post,
            'revision' => $revision,
        ]);
    }
}
