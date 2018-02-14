<?php

namespace App\Service\Importer;

use App\Entity\User;
use App\Entity\UserInfo;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManager;

class UsersImporter extends JsonImporter
{
    /**
     * Define the folder where json are to be saved
     * @var string $jsonFolder
     */
    protected $jsonFolder = __DIR__ . '/../../../public/importer/users/';

    /**
     * Define the login code to access the API
     * @var string $exportCodeLogin
     */
    protected $exportCodeLogin = 'truffolone';

    /**
     * URL of the API endpoint
     * @var string $url
     */
    protected $endpointUrl = 'http://sutter.echocreative.it/ExportUserList.aspx';

    /**
     * Import File name
     * @var string $importFileName
     */
    protected $importFileName = 'import';

    /**
     * Defines if users need tyo be updated if already existent
     * @var bool $updateUsers
     */
    protected $updateUsers = false;

    /**
     * UserPasswordEncoderInterface
     * @var $encoder
     */
    protected $encoder;

    /**
     * Doctrine EntityManager
     * @var EntityManager $em
     */
    protected $em;

    /**
     * UsersImporter constructor.
     * @param EntityManager $em
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(EntityManager $em, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
    }

    /**
     * Create the Json file
     * @return array with response data
     */
    public function createJson() :array
    {
        /** checking the file existence and create it if necessary */
        if (!$this->setJsonFile($this->jsonFolder, $this->importFileName)) {
            return $this->getMessageData();
        }

        /** Creating the Request */
        $this->addParameter('codeLogin', $this->exportCodeLogin);
        $this->setUrl($this->endpointUrl);

        /** Making the call */
        if (!$this->sendRequest()) {
            return $this->getMessageData();
        }

        /** Working on the data */
        $bodyData = $this->getBody();
        $arrayParser = new ArrayImporterParser();

        /** setting the data into the parser */
        if (!$arrayParser->setRawData($bodyData)) {
            return $arrayParser->getMessageData();
        }

        /** Loading the fields from the response array */
        if (!$arrayParser->setFieldsFromDataIndex(0)) {
            return $arrayParser->getMessageData();
        }

        /** modifying start data content because of that */
        if (!$arrayParser->setStart(1)) {
            return $arrayParser->getMessageData();
        }

        /** binding data */
        if (!$arrayParser->parseData()) {
            return $arrayParser->getMessageData();
        }

        /** Saving data To File */
        if (!$this->saveDataToFile($arrayParser->getParsedData())) {
            return $this->getMessageData();
        }

        $this->composeMessage(1, 'Import file Created Successful');

        return $this->getMessageData();
    }

    /**
     * @param int $start
     * @param int $cycles
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @return array
     */
    public function importUsers(
        int $start,
        int $cycles
    ) :array {
        /** checking if the file to import exists */
        $filePath = $this->jsonFolder . $this->importFileName . '.json';
        if (!file_exists($filePath)) {
            $this->composeMessage(0, 'File to import ' . $filePath . ' not found');
            return $this->getMessageData();
        }

        /** Loading the file data */
        $jsonData = file_get_contents($filePath);
        $decodedData = json_decode($jsonData, true);
        if (!\is_array($decodedData) || \count($decodedData) === 0) {
            $this->composeMessage(0, 'File ' . $filePath . ' is corrupted');
            return $this->getMessageData();
        }

        $countDecodedData = \count($decodedData);
        if ($countDecodedData === 0) {
            $this->composeMessage(0, 'File ' . $filePath . ' is empty');
            return $this->getMessageData();
        }

        /** ending point */
        $end = (($start + $cycles) > $countDecodedData) ? $countDecodedData : ($start + $cycles);

        /** calling user repository */
        $repository = $this->em->getRepository(User::class);

        /** cycling through items */
        for ($i = $start; $i < $end; $i++) {
            /** avoiding indexing problems */
            if (!array_key_exists($i, $decodedData)) {
                continue;
            }

            /** does the user exists already? */
            $user = $repository->findByEmailOrUsername(
                $decodedData[$i]['email'],
                trim($decodedData[$i]['usr'])
            );

            if (!$user) {
                /** adding new user */
                $userToAdd = new User();
                $userInfoToAdd = new UserInfo();
            } else {
                /** if we don't need to overwrite existing users */
                if (!$this->updateUsers) {
                    continue;
                }

                /** editing the user */
                $userToAdd = $user;

                $userInfoToAdd = $user->getUserInfo();
                if (!$userInfoToAdd) {
                    $userInfoToAdd = new Userinfo();
                }
            }

            if (trim($decodedData[$i]['usr']) === '') {
                continue;
            }

            /** setting up the data */
            $userToAdd->setUsername(trim($decodedData[$i]['usr']));
            $userToAdd->setPassword($this->encoder->encodePassword($userToAdd, $decodedData[$i]['pwd']));
            if ($decodedData[$i]['enabled'] === 'True') {
                $userToAdd->setIsActive(1);
            } else {
                $userToAdd->setIsActive(0);
            }
            $userToAdd->setEmail($decodedData[$i]['email']);
            $userToAdd->setOldId($decodedData[$i]['md5User']);

            /** setting up userInfo data */
            $userInfoToAdd->setUser($userToAdd);
            $userInfoToAdd->setName($decodedData[$i]['name']);
            $userInfoToAdd->setSurname($decodedData[$i]['surname']);
            $userInfoToAdd->setCompanyName($decodedData[$i]['companyName']);
            $userInfoToAdd->setAddress($decodedData[$i]['address']);
            $userInfoToAdd->setMoreInfo($decodedData[$i]['moreInfo']);
            $userInfoToAdd->setTelephone($decodedData[$i]['tel']);
            $userInfoToAdd->setCellphone($decodedData[$i]['cel']);
            $userInfoToAdd->setFax($decodedData[$i]['fax']);

            /** persisting the data */
            $this->em->persist($userInfoToAdd);
            $this->em->persist($userToAdd);
            /** saving the data to the database */
            $this->em->flush();
        }

        /** redirecting to new set of data or sending success response */
        $this->composeMessage(1, 'success');
        return $this->getMessageData();
    }

    /**
     * Sets $updateUsers variable
     * @param bool $update
     */
    public function setUpdateUsers(bool $update) :void
    {
        $this->updateUsers = $update;
    }
}
