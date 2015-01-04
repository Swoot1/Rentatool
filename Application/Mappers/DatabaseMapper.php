<?php
/**
 * User: Elin
 * Date: 2014-07-17
 * Time: 18:59
 */

namespace Application\Mappers;

use Application\PHPFramework\Database\Models\DatabaseConnection;

class DatabaseMapper{

   private $databaseConnection;

   private $createDatabaseSQL = "
      CREATE DATABASE IF NOT EXISTS rentatool
            DEFAULT CHARACTER SET utf8
            DEFAULT COLLATE utf8_general_ci;
   ";

   private $createTableSQL = "
      CREATE TABLE IF NOT EXISTS users(
         id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
         username VARCHAR(50) NOT NULL UNIQUE,
         email VARCHAR(128) NOT NULL UNIQUE,
         password VARCHAR(60) NOT NULL,
         administrative_access TINYINT(1) NOT NULL,
         has_confirmed_email TINYINT(1) DEFAULT 0 NOT NULL,
         organization_number VARCHAR(12) NOT NULL,
         address VARCHAR(100) DEFAULT NULL,
         additional_address_information VARCHAR(100) DEFAULT NULL,
         zip_code INTEGER DEFAULT NULL,
         city VARCHAR(50) DEFAULT NULL,
         phone_number VARCHAR(30) DEFAULT NULL,
         customer_records_id INTEGER DEFAULT NULL UNIQUE
      );

      CREATE TABLE IF NOT EXISTS reset_passwords(
        id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
        user_id INTEGER NOT NULL,
        expiration_timestamp TIMESTAMP NOT NULL,
        reset_code VARCHAR(13) NOT NULL
      );

      CREATE TABLE IF NOT EXISTS rental_objects(
         id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
         user_id INTEGER NOT NULL,
         name VARCHAR(30) NOT NULL,
         description VARCHAR(3000) NOT NULL,
         CONSTRAINT rental_object_owner_fk FOREIGN KEY (user_id) REFERENCES users(id),
         price_per_day FLOAT NOT NULL,
         active TINYINT(1) DEFAULT 1 NOT NULL
      );

      CREATE TABLE IF NOT EXISTS rent_periods(
         id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
         rental_object_id INTEGER NOT NULL,
         renter_id INTEGER NOT NULL,
         from_date DATETIME NOT NULL,
         to_date DATETIME NOT NULL,
         price_per_day FLOAT NOT NULL,
         total_price FLOAT NOT NULL,
         CONSTRAINT rent_period_has_a_rental_object_fk FOREIGN KEY (rental_object_id) REFERENCES rental_objects(id),
         CONSTRAINT renter_fk FOREIGN KEY (renter_id) REFERENCES users(id)
      );

      CREATE TABLE IF NOT EXISTS files(
       id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
       file_size INTEGER NOT NULL,
       file_type VARCHAR(30) NOT NULL
      );

      CREATE TABLE IF NOT EXISTS rental_object_file_dependencies(
        id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
        rental_object_id INTEGER NOT NULL,
        file_id INTEGER NOT NULL,
        CONSTRAINT connected_to_rental_object_fk FOREIGN KEY(rental_object_id) REFERENCES rental_objects(id) ON DELETE CASCADE,
        CONSTRAINT connected_to_file_fk FOREIGN KEY(file_id) REFERENCES files(id) ON DELETE CASCADE
      );
   ";

   public function __construct(DatabaseConnection $databaseConnection){
      $this->databaseConnection = $databaseConnection;
   }

   public function createDatabase(){
      $host     = 'localhost';
      $username = 'root';
      $password = '';

      $PDOOptions         = array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC, \PDO::MYSQL_ATTR_FOUND_ROWS => true);
      $databaseConnection = new \PDO(sprintf('mysql:host=%s;', $host), $username, $password, $PDOOptions);

      $databaseConnection->exec($this->createDatabaseSQL);
   }

   public function createTables(){
      $this->databaseConnection->runQuery($this->createTableSQL);
   }

   /**
    * Insert seed values so that you don't have to start with an empty db.
    * @param UserMapper $userMapper
    * @param RentalObjectMapper $rentalObjectMapper
    */
   public function insertSeeds(UserMapper $userMapper, RentalObjectMapper $rentalObjectMapper){
      $users = array(
         array(
            'username'                     => 'andy',
            'email'                        => 'andy@andy.se',
            'password'                     => '$2y$10$PwZXV0Rt0y013zL3oPxdUOComVYuspqPX/k2C6Da7dXFKdQc0qapS',
            'hasAdministrativeAccess'      => true,
            'hasConfirmedEmail'            => true,
            'organizationNumber'           => '199003070464',
            'address'                      => null,
            'additionalAddressInformation' => null,
            'zipCode'                      => null,
            'city'                         => null,
            'phoneNumber'                  => null,
            'customerRecordsId'            => null
         ),
         array(
            'username'                     => 'elin',
            'email'                        => 'elin@elin.se',
            'password'                     => '$2y$10$e5WdvQNzLGiR4AmU1qm/BupgIKxM1OQgfCS3nm7KVyIzaqq9P0lwK',
            'hasAdministrativeAccess'      => true,
            'hasConfirmedEmail'            => true,
            'organizationNumber'           => '5564696291',
            'address'                      => null,
            'additionalAddressInformation' => null,
            'zipCode'                      => null,
            'city'                         => null,
            'phoneNumber'                  => null,
            'customerRecordsId'            => null
         )
      );

      foreach ($users as $userData){
         $userMapper->create($userData);
      }

      $rentalObjects = array(
         array(
            'name'        => 'Knaus Sport 400 LB',
            'userId'      => 1,
            'pricePerDay' => 100,
            'description' => 'Den går bra och klipper gräset.',
            'active'      => 1
         ),
         array(
            'name'        => 'Kabe 510 Smaragd',
            'userId'      => 1,
            'pricePerDay' => 100,
            'description' => 'Hyr husvagn utanför Varberg (Åsa/Åskloster/Väröbacka).

Vagnen är välvårdad i ljus inredning med plats för 4-6 personer.

Bytesdag fred, lörd eller söndag.

Självklart är vagnen djur & rökfri.
Gasol ingår för normal matlagning.
Förtält finns mot ett tillägg på 300 kr.

UTRUSTNING:
Campingbord + stolar
Husgeråd, tallrikar, bestick, micro & dammsugare.

Deposition 2000 kr som återfås vid hel och ren vagn tillbaka.

Man kan även köpa till slutstädning av vagn för 200 kr.

Transport till närliggande camping går eventuellt att ordna mot tillägg.

Observera att helguthyrning ej är möjlig vecka 27-32 då endast hela veckor kan bokas.',
            'active'      => 1
         ),
         array(
            'name'        => 'Byster ITO 740',
            'userId'      => 1,
            'pricePerDay' => 100,
            'description' => 'Bäddar: 4 personer (1 Dubbelsäng och långbädd bak)

Utrustning: TV-antenn, LCD-TV med inbyggd digitalbox och DVD, Markis, Cykelställ (3), Säkerhetsskåp, Dragkrok, Backkamera, Elkabel, Nivåklossar, Bord och Stolar.

Bokningsavgift: 1/3 av hyran, som ska betalas inom 7 dagar efter bokningstillfälle.

Totalvikt: 4000 kg',
            'active'      => 1
         ),
         array(
            'name'        => 'Smålandia 460',
            'userId'      => 2,
            'pricePerDay' => 100,
            'description' => 'Välskött, lättdragen Smålandia 460. Det finns en matgrupp i främre delen som lätt bäddas ut till en dubbelsäng för 2-3 personer. Bak finns det en våningssäng avsedd för barn, samt en liten soffgrupp som bäddas ut till en stor enkelsäng.

Solmarkis
Förtält finns att hyra för 400 kr extra.
Platt-tv, boxer, radio
Gasolspis, elspis, kyl med frysfack (gasol/220/12v)
Elvärme, gosolvärme.
Porta porti
Brandvarnare, gasollarm.
Besiktigad och gasoltestad
Campingbord, stolar, Husgeråd, tallrikar, bestick.
Medtag egna sängkläder / sänglinne.

Kom till underbara Öland hyr din färdigpackade husvagn här, slipp onödigt dragande.

Ring gärna på 073 8157521',
            'active'      => 1
         ),
         array(
            'name'        => 'Fiat S 42 SL',
            'userId'      => 2,
            'pricePerDay' => 100,
            'description' => 'Bilen uthyres endast till personer över 30 år. Bilen drar ca: 0,9 l diesel/mil. Djur och rökning är inte tillåten. Priset för bilen kommer att faktureras inkl moms.

Fullt köksutrustad

Dusch

Toalett

Stort bagageutrumme

2 st gasoltuber

Bilen hämtas fulltankad, tvättad utvändigt, städad invändigt samt toeletten tömd och vattentankarna tömda. Samma regler gäller vid lämning.',
            'active'      => 1
         ),
         array(
            'name'        => 'Tec 664',
            'userId'      => 2,
            'pricePerDay' => 100,
            'description' => 'Tec 664 -10
Hyr vår stora och rymliga husbil, plats för 6 bältade vuxna, rök-/djurfri och får köras med B-körkort.

Husbilen hämtas/lämnas i Karlstad (bytesdag söndag).

Ta med familjen på en underbar resa genom Sverige, Norden eller Europa, och spara semesterslantar genom att hyra husbil!
Många upptäcker fördelarna med att semestra i husbil, upplevelsen är oförglömlig med skiftande miljöer under en och samma semester.
Barnen älskar det!

Tips! Att hyra husbil är även ett ekonomiskt alternativ för företaget för att minimera kostnader för resa och hotell.

Husbilen TEC är mycket komfortabel och välutrustad.

- Kyl/frys
- Dusch
- Kemtoalett
- Platt TV
- Bord och stolar
- Köksutrustning för 6 personer

Fria mil ingår, därefter tillkommer en kostnad på 20kr/mil.

Varmt välkomna!',
            'active'      => 1
         )
      );

      foreach ($rentalObjects as $rentalObjectData){
         $rentalObjectMapper->create($rentalObjectData);
      }
   }
} 