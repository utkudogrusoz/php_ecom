<?php
namespace App\Controllers;
use App\Models\FileModel;

class Download extends BaseController
{
    public function downloadFile($id)
    {
        $model = new FileModel();
        $fileData = $model->find($id);

        if ($fileData) {
            $uniqueIdentifier = uniqid('file_', true);
            $model->save([
                'id' => $id,
                'download_identifier' => $uniqueIdentifier
            ]);

            return $this->response->download(WRITEPATH . 'uploads/' . $fileData['file_name'], null);
        } else {
            return redirect()->to('/error');
        }
    }
}
