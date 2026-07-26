<?php

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

//ثبت یک فایل در دیتابیس و دیسک
if (! function_exists('store_model_file')) {
    /**
     * ذخیره فایل و ثبت در جدول files به صورت polymorphic
     *
     * @param  Model  $model           مدلی که فایل بهش می‌چسبه (مثلا Ticket)
     * @param  UploadedFile  $uploaded فایل آپلود شده
     * @param  string  $dir            مسیر ذخیره (مثلا uploads/tickets)
     * @param  string|null  $collection دسته‌بندی فایل (مثلا attachment, avatar)
     * @param  string  $disk           دیسک ذخیره (پیشفرض public)
     * @param  Model|null  $uploadedBy آپلود کننده (اختیاری: admin/user)
     * @param  int  $sortOrder         ترتیب
     */
    function store_model_file(
        Model $model,
        UploadedFile $uploaded,
        string $dir = 'uploads',
        ?string $collection = null,
        string $disk = 'public',
        ?Model $uploadedBy = null,
        int $sortOrder = 0
    ): File {
        // 1) ذخیره فیزیکی فایل
        $path = $uploaded->store($dir, $disk);

        // 2) ساخت رکورد در جدول files
        return $model->files()->create([
            'disk'          => $disk,
            'path'          => $path,
            'original_name' => $uploaded->getClientOriginalName(),
            'mime_type'     => $uploaded->getMimeType(),
            'size'          => $uploaded->getSize(),
            'collection'    => $collection,
            'sort_order'    => $sortOrder,

            'uploaded_by_type' => $uploadedBy ? get_class($uploadedBy) : null,
            'uploaded_by_id'   => $uploadedBy?->getKey(),
        ]);
    }
}
//ثبت چند فایل در دیتابیس و دیسک
if (! function_exists('store_model_files')) {
    /**
     * ذخیره چند فایل
     *
     * @return array<File>
     */
    function store_model_files(
        Model $model,
        array $uploadedFiles,
        string $dir = 'uploads',
        ?string $collection = null,
        string $disk = 'public',
        ?Model $uploadedBy = null
    ): array {
        $result = [];

        foreach ($uploadedFiles as $i => $uploaded) {
            if (!($uploaded instanceof UploadedFile)) continue;

            $result[] = store_model_file(
                model: $model,
                uploaded: $uploaded,
                dir: $dir,
                collection: $collection,
                disk: $disk,
                uploadedBy: $uploadedBy,
                sortOrder: $i
            );
        }

        return $result;
    }
}
// حذف یک رکورد از دیسک
if (! function_exists('delete_file_record')) {
    /**
     * حذف یک فایل: هم از Storage هم از دیتابیس
     *
     * @param  File  $file
     * @param  bool  $deletePhysical  آیا فایل فیزیکی هم حذف شود؟
     */
    function delete_file_record(File $file, bool $deletePhysical = true): bool
    {
        return DB::transaction(function () use ($file, $deletePhysical) {

            // 1) حذف فایل از دیسک
            if ($deletePhysical && $file->disk && $file->path) {
                try {
                    Storage::disk($file->disk)->delete($file->path);
                } catch (\Throwable $e) {
                    // اگر خواستی اینجا log هم بزنیم
                    // logger()->error($e->getMessage());
                }
            }

            // 2) حذف رکورد از دیتابیس
            return (bool) $file->delete();
        });
    }
}
//جدف یک رکورد از دیتابیس
if (! function_exists('delete_model_file')) {
    /**
     * حذف یک فایل از یک مدل (با چک مالکیت)
     *
     * @param  Model  $model
     * @param  int  $fileId
     * @param  bool  $deletePhysical
     */
    function delete_model_file(Model $model, int $fileId, bool $deletePhysical = true): bool
    {
        $file = $model->files()->whereKey($fileId)->first();

        if (! $file) {
            return false;
        }

        return delete_file_record($file, $deletePhysical);
    }
}
//حذف چند فایل از دیتابیس
if (! function_exists('delete_model_files')) {
    /**
     * حذف همه فایل‌های یک مدل (اختیاری: فقط یک collection خاص)
     *
     * @param  Model  $model
     * @param  string|null  $collection
     * @param  bool  $deletePhysical
     * @return int تعداد حذف شده‌ها
     */
    function delete_model_files(Model $model, ?string $collection = null, bool $deletePhysical = true): int
    {
        $query = $model->files();

        if ($collection !== null) {
            $query->where('collection', $collection);
        }

        $files = $query->get();
        $count = 0;

        foreach ($files as $file) {
            if (delete_file_record($file, $deletePhysical)) {
                $count++;
            }
        }

        return $count;
    }
}
//جایگذاری فایل روی فایل های قبلی
if (! function_exists('replace_model_files')) {
    /**
     * جایگزینی فایل‌های یک مدل: اول فایل‌های قبلی (اختیاری collection) حذف، بعد فایل‌های جدید ذخیره
     *
     * @param  Model  $model
     * @param  array  $uploadedFiles
     * @param  string  $dir
     * @param  string|null  $collection
     * @param  string  $disk
     * @param  Model|null  $uploadedBy
     * @return array<File>
     */
    function replace_model_files(
        Model $model,
        array $uploadedFiles,
        string $dir = 'uploads',
        ?string $collection = null,
        string $disk = 'public',
        ?Model $uploadedBy = null
    ): array {
        delete_model_files($model, $collection, true);

        return store_model_files(
            model: $model,
            uploadedFiles: $uploadedFiles,
            dir: $dir,
            collection: $collection,
            disk: $disk,
            uploadedBy: $uploadedBy
        );
    }
}
