<?php

namespace App\DataFixtures;

use App\Entity\DataType;
use App\Entity\Device;
use App\Entity\Event;
use App\Entity\Image;
use App\Entity\Profile;
use App\Entity\Room;
use App\Entity\SettingData;
use App\Entity\SettingType;
use App\Entity\Standard;
use App\Entity\User;
use App\Entity\Vibe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $encoder;
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->loadImages($manager);
        $this->loadUsers($manager);
        $this->loadProfiles($manager);
        $this->loadDevices($manager);
        $this->loadStandard($manager);
        $this->loadVibes($manager);
        $this->loadDataTypes($manager);
        $this->loadSettingTypes($manager);
        $this->loadSettingData($manager);
        $this->loadRooms($manager);
        $this->loadEvents($manager);


        $manager->flush();
    }

    public function loadUsers(ObjectManager $manager): void
    {
        $array_users = [
            [
                'name' => 'admin',
                'password' => 'admin1',
                'roles' => ["ROLE_ADMIN"]
            ],
        ];

        foreach ($array_users as $key => $value) {
            $user = new User();
            $user->setName($value['name']);
            $user->setPassword($this->encoder->hashPassword($user, $value['password']));
            // $user->setFirstname($value['firstname']);
            // $user->setLastname($value['lastname']);
            $user->setRoles($value['roles']);
            $manager->persist($user);
            // Définir une référence pour chaque utilisateur
            $this->addReference('user_' . ($key + 1), $user);
        }
    }

    /**
     * méthode pour charger les devices
     * @param ObjectManager $manager
     * @return void
     */
    public function loadDevices(ObjectManager $manager): void
    {
        $array_devices = [
            [
                'label' => 'Lampe de salon',
                'type' => 'Lampe',
                'is_active' => true,
                'reference' => 'lamp00123',
                'brand' => 'Philips',
            ],
            [
                'label' => 'Haut-parleur Bluetooth',
                'type' => 'Haut-parleur',
                'is_active' => false,
                'reference' => 'spk98765',
                'brand' => 'JBL',
            ],
            [
                'label' => 'Lampe de chevet',
                'type' => 'Lampe',
                'is_active' => true,
                'reference' => 'lamp00456',
                'brand' => 'IKEA',
            ],
            [
                'label' => 'Prise connectée cuisine',
                'type' => 'Prise connectée',
                'is_active' => false,
                'reference' => 'plug11223',
                'brand' => 'TP-Link',
            ],
            [
                'label' => 'Haut-parleur salon',
                'type' => 'Haut-parleur',
                'is_active' => true,
                'reference' => 'spk22334',
                'brand' => 'Sony',
            ],
            [
                'label' => 'Prise connectée chambre',
                'type' => 'Prise connectée',
                'is_active' => true,
                'reference' => 'plug33445',
                'brand' => 'Meross',
            ],
        ];

        foreach ($array_devices as $key => $value) {
            $device = new Device();
            $device->setLabel($value['label']);
            $device->setType($value['type']);
            $device->setIsActive($value['is_active']);
            $device->setReference($value['reference']);
            $device->setBrand($value['brand']);
            // on persiste les données
            $manager->persist($device);
            // on définit une référence pour chaque équipement
            $this->addReference('device_' . $key + 1, $device);
        }
    }

    /**
     * méthode pour charger les dataTypes
     * @param ObjectManager $manager
     * @return void
     */
    public function loadDataTypes(ObjectManager $manager): void
    {
        $array_dataTypes = [
            [
                'type' => '°C',
            ],
            [
                'type' => 'W',
            ],
            [
                'type' => 'RGB', 
            ],
            [
                'type' => '%', 
            ],
            [
                'type' => 'dB',
            ],
        ];

        foreach ($array_dataTypes as $key => $value) {
            $dataType = new DataType();
            $dataType->setDataType($value['type']);
            // on persiste les données
            $manager->persist($dataType);
            // oin définit une référence pour chaque type de données
            $this->addReference('dataType_' . $key + 1, $dataType);
        }
    }

    /**
     * méthofde pour charger les SettingTypes
     * @param ObjectManager $manager
     * @return void
     */
    public function loadSettingTypes(ObjectManager $manager): void
    {
        $array_settingTypes = [
            [
               'dataType' => 1,
               'label' => 'température',
                'devices' => [1, 4]
            ],
            [
                'dataType' => 2,
                'label' => 'puissance',
                'devices' => [2, 4]
            ],
            [
                'dataType' => 3,
                'label' => 'couleur',
                'devices' => [1, 3]
            ],
            [
                'dataType' => 4,
                'label' => 'luminosité',
                'devices' => [1, 3]
            ],
            [
                'dataType' => 5,
                'label' => 'volume',
                'devices' => [2, 5]

            ],
           
        ];

        foreach ($array_settingTypes as $key => $value) {
            $settingType = new SettingType();
            $settingType->setDataType($this->getReference('dataType_' . $value['dataType'], DataType::class));
            $settingType->setLabelKey($value['label']);
            // on va boucler sur $value['devices']pour la relation ManyToMany avec Device
            foreach ($value['devices'] as $device) {
                $settingType->addDevice($this->getReference('device_' . $device, Device::class));
            }
            // on persiste les données
            $manager->persist($settingType);
            // oin définit une référence pour chaque type de données
            $this->addReference('settingType_' . $key + 1, $settingType);
        }
    }

    /**
     * méthode pour charger les SettingData
     * @param ObjectManager $manager
     * @return void
     */
    public function loadSettingData(ObjectManager $manager): void
    {
        $array_settingData = [
            [
                'vibe' => 1,
                'settingType' => 1,
                'data' => 25,
            ],
            [
                'vibe' => 2,
                'settingType' => 2,
                'data' => 50,
            ],
            [
                'vibe' => 3,
                'settingType' => 3,
                'data' => '#FF0000',
            ],
            [
                'vibe' => 1,
                'settingType' => 4,
                'data' => 75,
            ],
            [
                'vibe' => 2,
                'settingType' => 5,
                'data' => 80,
            ],
        ];

        foreach ($array_settingData as $key => $value) {
            $settingData = new SettingData();
            $settingData->setVibe($this->getReference('vibe_' . $value['vibe'], Vibe::class));
            $settingData->setSettingType($this->getReference('settingType_' . $value['settingType'], SettingType::class));
            $settingData->setData($value['data']);
            // on persiste les données
            $manager->persist($settingData);
            // on définit une référence pour chaque type de données
            $this->addReference('settingData_' . $key + 1, $settingData);
        }
    }

    /**
     * méthode pour charger les Standard
     * @param ObjectManager $manager
     * @return void
     */
    public function loadStandard(ObjectManager $manager): void
    {
        $array_standards = [
            [
                'security' => 50,
                'energy' => 75,
                'emotion' => 100,
                'consciousness' => 100,
            ],
            [
                'security' => 25,
                'energy' => 50,
                'emotion' => 75,
                'consciousness' => 75,
            ],
            [
                'security' => 0,
                'energy' => 25,
                'emotion' => 50,
                'consciousness' => 50,
            ],
            [
                'security' => 100,
                'energy' => 0,
                'emotion' => 100,
                'consciousness' => 25,
            ],
        ];

        foreach ($array_standards as $key => $value) {
            $standard = new Standard();
            $standard->setSecurity($value['security']);
            $standard->setEnergy($value['energy']);
            $standard->setEmotion($value['emotion']);
            $standard->setConsciousness($value['consciousness']);
            // on persiste les données
            $manager->persist($standard);
            // on définit une référence pour chaque type de données
            $this->addReference('standard_' . $key + 1, $standard);
        }
    }

    /**
     * méthode pour charger les Images
     * @param ObjectManager $manager
     * @return void 
     */
    public function loadImages(ObjectManager $manager): void
    {
        $array_images = [
            [
                'image_path' => 'avatar1.jpg',
                'category' => 1,
            ],
            [
                'image_path' => 'avatar2.jpg',
                'category' => 1,
            ],
            [
                'image_path' => 'avatar3.jpg',
                'category' => 1,
            ],
        ];

        foreach ($array_images as $key => $value) {
            $image = new Image();
            $image->setImagePath($value['image_path']);
            $image->setCategory($value['category']);
            // on persiste les données
            $manager->persist($image);
            // on définit une référence pour chaque type de données
            $this->addReference('image_' . $key + 1, $image);
        }
    }

    /**
     * méthode pour charger les Rooms
     * @param ObjectManager $manager
     * @return void
     */
    public function loadRooms(ObjectManager $manager): void
    {
        $array_rooms = [
            [
                'label' => 'Salon',
                'image' => 1,
            ],
            [
                'label' => 'Chambre',
                'image' => 2,
            ],
            [
                'label' => 'Cuisine',
                'image' => 3,
            ]
            ];

        foreach ($array_rooms as $key => $value) {
            $room = new Room();
            $room->setLabel($value['label']);
            $room->setImage($this->getReference('image_' . $value['image'], Image::class));
            // on persiste les données
            $manager->persist($room);
            // on définit une référence pour chaque type de données
            $this->addReference('room_' . $key + 1, $room);
        }
    }

    /**
     * méthode pour charger les profiles
     * @param ObjectManager $manager
     * @return void
     */
    public function loadProfiles(ObjectManager $manager): void
    {
        $array_profiles = [
            [
                'image' => 1,
                'name' => 'Tom',
                'pin' => 1234,
            ],
            [
                'image' => 2,
                'name' => 'Mayer',
                'pin' => 1234,
            ],
            [
                'image' => 2,
                'name' => 'user3',
                'pin' => 1234,
            ],
            [
                'image' => 3,
                'name' => 'user4',
                'pin' => 1234,
            ]
        ];
        foreach ($array_profiles as $key => $value) {
            $profile = new Profile();
            $profile->setImage($this->getReference('image_' . $value['image'], Image::class));
            $profile->setName($value['name']);
            $profile->setPinCode($value['pin']);
            // on persiste les données
            $manager->persist($profile);
            // on définit une référence pour chaque type de données
            $this->addReference('profile_' . $key + 1, $profile);
        }
    }

    /**
     * méthode pour charger les Vibes
     * @param ObjectManager $manager
     * @return void
     */
    public function loadVibes(ObjectManager $manager): void
    {
        //TODO: do the fixture for vibe and change the place where we call it 
        $array_vibes = [
            [
                'profile' => 1,
                'image' => 1,
                'standard' => 1,
                'label' => 'Chill',
            ],
            [
                'profile' => 1,
                'image' => 2,
                'standard' => 2,
                'label' => 'Cozy',
            ],
            [
                'profile' => 1,
                'image' => 3,
                'standard' => 3,
                'label' => 'Sad',
            ],
        ];
        foreach ($array_vibes as $key => $value) {
            $vibe = new Vibe();
            $vibe->setLabel($value['label']);
            $vibe->setStandard($this->getReference('standard_' . $value['standard'], Standard::class));
            $vibe->setImage($this->getReference('image_' . $value['image'], Image::class));
            $vibe->setProfile($this->getReference('profile_' . $value['profile'], Profile::class));
            // on persiste les données
            $manager->persist($vibe);
            // on définit une référence pour chaque type de données
            $this->addReference('vibe_' . $key + 1, $vibe);
        }
    }

    /**
     * méthode pour charger les events
     * @param ObjectManager $manager
     * @return void
     */
    public function loadEvents(ObjectManager $manager): void
    {
        $array_events = [
            [
                'rooms' => [1, 3],
                'vibe' => 1,
                'label' => 'repas',
                'start_time' => new \DateTime('2025-10-01 10:00:00'),
                'end_time' => new \DateTime('2025-10-01 12:00:00'),
            ],
            [
                'rooms' => [1, 2],
                'vibe' => 2,
                'label' => 'anniversaire',
                'start_time' => new \DateTime('2025-10-02 14:00:00'),
                'end_time' => new \DateTime('2025-10-02 16:00:00'),
            ],
        ];
        foreach ($array_events as $key => $value) {
            $event = new Event();
            $event->setVibe($this->getReference('vibe_' . $value['vibe'], Vibe::class));
            $event->setLabel($value['label']);
            $event->setDateStart($value['start_time']);
            $event->setDateEnd($value['end_time']);
            // on va boucler sur $value['room'] pour la relation MANY_TO_MANY avec Room
            foreach ($value['rooms'] as $room) {
                $event->addRoom($this->getReference('room_' . $room, Room::class));
            }
            // on persiste les données
            $manager->persist($event);
            // on définit une référence pour chaque type de données
            $this->addReference('event_' . $key + 1, $event);
        }
    }
}
