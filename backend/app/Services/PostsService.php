<?php
declare(strict_types=1);

namespace App\Services;

use App\Exceptions\FailedConvertImageFromBase64Exception;
use App\Models\Post;
use App\Models\User;
use App\Services\Storage\FileUploadService;
use App\Services\Storage\StorageService;
use ErrorException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class PostsService
{
    public function getAllPosts(): LengthAwarePaginator
    {
        $query = Post::query();

        $query = $query->whereHas('blog', function (Builder $query) {
            $query
                ->where('is_public', true)
                ->orWhere(function (Builder $query) {
                    $query->where('is_public', false)
                        ->whereHas('subscribers', function (Builder $query) {
                            $query->where('user_id', auth()->user());
                        });
                })
            ;
        });

        return $query->paginate(12);
    }

    /**
     * @throws FailedConvertImageFromBase64Exception|ErrorException
     */
    public function create(array $requestData): Post
    {
        /** @var Post $post */
        $post = Post::query()->create(array_merge(
            $requestData,
            [
                'user_id' => auth()->id(),
                'blog_id' => auth()->user()->blog->id
            ]
        ));

        if (isset($requestData['images'])) {
            $fileUploadService = new FileUploadService();
            foreach ($requestData['images'] as $image) {
                $imagePath = $fileUploadService->uploadBase64Image($image, StorageService::POSTS_FOLDER);
                //todo: attach to the attachments table with post id
            }
        }

        return $post;
    }

    public function update(array $requestData)
    {

    }
}
