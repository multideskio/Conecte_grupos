<?php

namespace App\Controllers\API;

use App\Libraries\S3;
use App\Models\CampaignModel;
use App\Models\FileModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\I18n\Time;
use Faker\Extension\Helper;

class Campaigns extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */

    protected $cache;
    public function __construct()
    {
        $this->cache = \Config\Services::cache();
        helper('response');
    }

    use ResponseTrait;
    public function index()
    {
        $company = session('user')['company'];
        //
        $campaignsModel = new CampaignModel();

        if ($this->cache->get("camapains_" . $company)) {
            return $this->response->setJSON($this->cache->get("camapains_" . $company));
        } else {
            $rows = $campaignsModel->where('id_company', $company)->findAll();
            
            $this->cache->save("camapains_" . $company, $rows, 600);
            
            return $this->respond($rows);
        }
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
        $input = $this->request->getVar();
        $file  = $uploadedFile  = $this->request->getFile('imageGroup');
        if (!$uploadedFile) {
            return $this->fail('A imagem não foi enviada!');
        }
        $newRandomName = $uploadedFile->getRandomName(); // . '.' . $uploadedFile->getClientExtension();
        $s3Path = 'g/' . session('user')['company'] . '/c/' . $newRandomName;
        $files = [
            'id_company' => session('user')['company'],
            'title'      => $newRandomName,
            'slug'       => $s3Path,
            'meta'       => json_encode(['title' => $file->getName(), 'size'  => $file->getSizeByUnit('mb'), 'type'  => $file->guessExtension(), 'mime'  => $file->getMimeType()])
        ];
        $s3 = new S3();
        $result = $s3->uploadFile($uploadedFile->getTempName(), $s3Path, $file->getMimeType());
        if ($result) {
            $filesModel = new FileModel();
            $idFile = $filesModel->insert($files);

            /**ORGANIZANDO DATAS */
            //separa data start e data end
            $dates = explode('até', $input['timeStart']);

            //datas em variaveis separadas
            $dateStartAr = trim($dates[0]);
            $dateEndAr   = trim($dates[1]);

            //prepara datas
            $dateTimeStart = Time::createFromFormat('d/m/Y', $dateStartAr);
            $dateTimeEnd   = Time::createFromFormat('d/m/Y', $dateEndAr);

            //datas formatadas
            $dateStart = $dateTimeStart->format('Y-m-d H:i:s');
            $dateEnd   = $dateTimeEnd->format('Y-m-d H:i:s');
            //$date = $dateTime;

            $data = [
                'id_company' => session('user')['company'],
                'name' => $input['tituloCampanha'],
                'time_start' => $dateStart,
                'time_end' => $dateEnd,
                'slug' => $input['slug'],
                'automate_creation' => $input['automatic'],
                //Mudar para relacionar com a tabela de arquivos
                'image' => $idFile
            ];

            $campaignModel = new CampaignModel();
            $campaignModel->insert($data);
            
            return $this->respondCreated(['ok']);
        } else {
            return $this->fail('Não foi possivel realizar o upload!');
        }
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }

    public function verifySlug($slug)
    {
        $campaignModel =  new CampaignModel();
        $search = $campaignModel->where('slug', $slug)->countAllResults();
        if ($search) {
            return $this->respond(['exists' => true]);
        } else {
            return $this->respond(['exists' => false]);
        }
    }
}
