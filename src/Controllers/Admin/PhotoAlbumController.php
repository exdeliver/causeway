<?php

namespace Exdeliver\Causeway\Controllers\Admin;

use Exdeliver\Causeway\Controllers\Controller;
use Exdeliver\Causeway\Domain\Entities\PhotoAlbum\Photo;
use Exdeliver\Causeway\Domain\Entities\PhotoAlbum\PhotoAlbum;
use Exdeliver\Causeway\Domain\Services\PhotoAlbumService;
use Exdeliver\Causeway\Domain\Services\PhotoService;
use Exdeliver\Causeway\Domain\Services\UploadService;
use Exdeliver\Causeway\Requests\PostAdminPhotoAlbumRequest;
use Exdeliver\Causeway\Requests\PostAdminPhotoRequest;
use Exdeliver\Causeway\Requests\PostPhotoUploadRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class PhotoAlbumController.
 */
class PhotoAlbumController extends Controller
{
    /**
     * @var PhotoService
     */
    protected $photoService;

    /**
     * @var PhotoAlbumService
     */
    protected $albumService;

    /**
     * @var UploadService
     */
    protected $uploadService;

    /**
     * PhotoAlbumController constructor.
     *
     * @param UploadService     $uploadService
     * @param PhotoService      $photoService
     * @param PhotoAlbumService $albumService
     */
    public function __construct(UploadService $uploadService, PhotoService $photoService, PhotoAlbumService $albumService)
    {
        $this->photoService = $photoService;
        $this->albumService = $albumService;
        $this->uploadService = $uploadService;
    }

    /**
     * @param Request $request
     * @param $photoAlbum
     *
     * @return Factory|View
     */
    public function index(Request $request, PhotoAlbum $photoAlbum = null): View
    {
        if (isset($photoAlbum)) {
            $subAlbums = $photoAlbum->albums;
            $photos = $photoAlbum->photos;
        } else {
            // override albums if we have a album selected
            $subAlbums = $this->albumService->getAlbums();
        }

        return view('causeway::admin.photo.album.index', ['album' => $photoAlbum, 'subAlbums' => $subAlbums, 'photos' => $photos ?? null]);
    }

    /**
     * @param Request         $request
     * @param PhotoAlbum|null $album
     *
     * @return Factory|View
     */
    public function createAlbum(Request $request, PhotoAlbum $album = null)
    {
        return view('causeway::admin.photo.album.new', ['album' => $album ?? null, 'albumOptions' => $this->albumService->repository->get()]);
    }

    /**
     * @param Request    $request
     * @param PhotoAlbum $album
     *
     * @return Factory|View
     */
    public function editAlbum(Request $request, PhotoAlbum $album)
    {
        return view('causeway::admin.photo.album.new', [
            'album' => $album,
            'albumOptions' => $this->albumService->repository
                ->where('id', '!=', $album->id ?? null)
                ->get(),
        ]);
    }

    /**
     * @param Request    $request
     * @param PhotoAlbum $album
     *
     * @return Factory|View
     */
    public function createPhoto(Request $request, PhotoAlbum $album)
    {
        return view('causeway::admin.photo.photo.new', ['album' => $album]);
    }

    /**
     * @param Request $request
     * @param Photo   $photo
     *
     * @return Factory|View
     */
    public function editPhoto(Request $request, Photo $photo)
    {
        return view('causeway::admin.photo.photo.edit', ['photo' => $photo]);
    }

    /**
     * @param PostAdminPhotoAlbumRequest $request
     * @param PhotoAlbum|null            $album
     *
     * @return RedirectResponse
     */
    public function storeAlbum(PostAdminPhotoAlbumRequest $request, PhotoAlbum $album = null): RedirectResponse
    {
        $file = isset($request->file) ? $this->uploadService->upload($request->file, $this->uploadService->uploadPhotoPath) : null;

        isset($file) ? $this->uploadService->resizeImage($file->file_path, $file->filename) : null;

        $photoAlbum = $this->albumService->saveAlbum([
            'name' => $request->name,
            'label' => str_slug($request->name),
            'parent_id' => !empty($request->parent_id) ? $request->parent_id : null,
            'description' => $request->description,
            'file' => $file->filename ?? null,
        ], $photoAlbum->id ?? null);

        $this->statusMessage = isset($photoAlbum->id) && null !== $photoAlbum->id ? 'Album has successfully been updated!' : 'Album has successfully been created!';

        if (true === $request->wantsJson()) {
            return json_encode(['status' => 'success', 'message' => $this->statusMessage]);
        }

        $request->session()->flash('status', $this->statusMessage);

        return redirect()
            ->route('admin.photo.album.index');
    }

    /**
     * @param PostAdminPhotoRequest $request
     * @param Photo|null            $photo
     *
     * @return RedirectResponse
     */
    public function storePhoto(PostAdminPhotoRequest $request, Photo $photo = null): RedirectResponse
    {
        $this->statusMessage = isset($photo->id) && null !== $photo->id ? 'Photo has successfully been updated!' : 'Photo has successfully been created!';

        if (true === $request->wantsJson()) {
            return json_encode(['status' => 'success', 'message' => $this->statusMessage]);
        }

        $request->session()->flash('status', $this->statusMessage);

        return redirect()
            ->route('admin.photo.album.index');
    }

    /**
     * @param PostPhotoUploadRequest $request
     *
     * @return JsonResponse
     */
    public function upload(PostPhotoUploadRequest $request)
    {
        $photos = [];

        foreach ($request->file('files') as $file) {
            $file = $this->uploadService->upload($file, $this->uploadService->uploadPhotoPath);
            $photos[] = $file->filename;

            isset($file) ? $this->uploadService->resizeImage($file->file_path, $file->filename) : null;

            $photo = $this->photoService->savePhoto([
                'album_id' => $request->album_id,
                'file' => $file->filename ?? null,
            ], $photo->id ?? null);
        }

        return response()
            ->json(['status' => 'success', 'message' => 'Successfully uploaded file.', 'files' => $photos]);
    }

    /**
     * @param Request $request
     * @param Photo   $photo
     *
     * @return RedirectResponse
     */
    public function removePhoto(Request $request, Photo $photo)
    {
        $this->photoService->delete($photo->id);

        $this->statusMessage = 'Photo has successfully been removed!';

        $request->session()->flash('status', $this->statusMessage);

        return redirect()
            ->back();
    }

    public function removeAlbum(Request $request, PhotoAlbum $album)
    {
        foreach ($album->photos as $photo) {
            $this->photoService->delete($photo->id);
        }

        foreach ($album->albums as $subAlbum) {
            $this->albumService->delete($subAlbum->id);
        }

        $this->albumService->delete($album->id);

        $this->statusMessage = 'Photo has successfully been removed!';

        $request->session()->flash('status', $this->statusMessage);

        return redirect()
            ->back();
    }
}
