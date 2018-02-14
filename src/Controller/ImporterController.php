<?php

namespace App\Controller;

use App\Service\Importer\UsersImporter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/importer", name="importer")
 */
class ImporterController extends Controller
{
    /**
     * Defines the filename for the json
     * @var string $fileDateFormat
     */
    private $fileDateFormat = 'Ymd';

    /**
     * Keeps the folders binded to the import section
     * @var array $folders
     */
    private $folders = [
        'lang' => __DIR__ . '/../../public/importer/lang/'
    ];

    /**
     * @Route("/usersControl", name="_users_control")
     */
    public function usersControl()
    {
        // replace this line with your own code!
        return $this->render(
            'importer/users.html.twig',
            [  ]
        );
    }

    /**
     * @Route("/langControl", name="_users_control")
     */
    public function langControl()
    {
        return $this->render(
            'importer/lang.html.twig',
            [
                'DE' => file_exists($this->folders['lang'] . 'DE.json'),
                'EN' => file_exists($this->folders['lang'] . 'EN.json'),
                'ES' => file_exists($this->folders['lang'] . 'ES.json'),
                'FR' => file_exists($this->folders['lang'] . 'FR.json'),
                'IT' => file_exists($this->folders['lang'] . 'IT.json'),
                'PT' => file_exists($this->folders['lang'] . 'PT.json')
            ]
        );
    }

    /**
     * @Route("/usersToImport", name="_users_count")
     */
    public function usersToImport()
    {
        /** checking if the file exists */
        $filePath = $this->folders['users'] . date($this->fileDateFormat) . '.json';
        if (!file_exists($filePath)) {
            $response = new JsonResponse(
                [
                    'result' => 'fail',
                    'message' => 'File to import ' . $filePath . ' not found'
                ]
            );
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }

        /** loads the file */
        $jsonData = file_get_contents($filePath);
        $decodedData = json_decode($jsonData, true);
        $countDecodedData = \count($decodedData);
        if (!\is_array($decodedData) || $countDecodedData === 0) {
            $response = new JsonResponse(
                [
                    'result' => 'fail',
                    'message' => 'File ' . $filePath . ' is corrupted'
                ]
            );
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }

        /** checking the file */

        if ($countDecodedData === 0) {
            $response = new JsonResponse(
                [
                    'result' => 'fail',
                    'message' => 'File ' . $filePath . ' is empty'
                ]
            );
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }

        /** sending data count */
        $response = new JsonResponse(
            [
                'result' => 'success',
                'conta' => $countDecodedData
            ]
        );
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * @Route("/users2", name="_users2")
     * @param EntityManager $em
     * @param UserPasswordEncoderInterface $encoder
     * @return JsonResponse
     */
    public function users(EntityManager $em, UserPasswordEncoderInterface $encoder) :JsonResponse
    {
        $usersImporter = new UsersImporter($em, $encoder);

        return new JsonResponse($usersImporter->createJson());
    }

    /**
     * @Route("/importUserData", name="_user_data")
     * @param Request $request
     * @param EntityManager $em
     * @param UserPasswordEncoderInterface $encoder
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @return JsonResponse
     */
    public function importUsersData(
        Request $request,
        EntityManager $em,
        UserPasswordEncoderInterface $encoder
    ) :JsonResponse {
        /** defining if we have to overwrite */
        $overwrite = (bool) $request->get('overwrite', 0);
        $start = (int) $request->get('start', 0);
        $cycles = (int) $request->get('cycles', 100);

        /** Calling the Service */
        $usersImporter = new UsersImporter($em, $encoder);
        $usersImporter->setUpdateUsers($overwrite);

        return new JsonResponse($usersImporter->importUsers($start, $cycles));
    }
}
