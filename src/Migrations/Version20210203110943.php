<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210203110943 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE appreciations (id INT AUTO_INCREMENT NOT NULL, val INT NOT NULL, lib_app VARCHAR(255) NOT NULL, val_sup INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, cycles_id INT NOT NULL, libclasse VARCHAR(255) NOT NULL, INDEX IDX_8F87BF9644C85140 (cycles_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cycle (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eleve (id INT AUTO_INCREMENT NOT NULL, parents_id INT NOT NULL, myclasses_id INT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, residence VARCHAR(255) NOT NULL, lieuness VARCHAR(255) NOT NULL, matricule VARCHAR(255) NOT NULL, dateness DATE NOT NULL, INDEX IDX_ECA105F7B706B6D3 (parents_id), INDEX IDX_ECA105F735EFF4AD (myclasses_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, coef INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, eleves_id INT NOT NULL, sems_id INT NOT NULL, matieres_id INT NOT NULL, appreciation VARCHAR(255) DEFAULT NULL, valeur NUMERIC(20, 0) NOT NULL, INDEX IDX_CFBDFA14C2140342 (eleves_id), INDEX IDX_CFBDFA1499FD2B8D (sems_id), INDEX IDX_CFBDFA1482350831 (matieres_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parrent (id INT AUTO_INCREMENT NOT NULL, prenom_p VARCHAR(255) NOT NULL, nom_p VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeur (id INT AUTO_INCREMENT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, adresse_pr VARCHAR(255) NOT NULL, tel_pr VARCHAR(255) NOT NULL, matricule_p VARCHAR(255) NOT NULL, datenessaince DATE NOT NULL, lieunessaince VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeur_matiere (professeur_id INT NOT NULL, matiere_id INT NOT NULL, INDEX IDX_FBC82ABCBAB22EE9 (professeur_id), INDEX IDX_FBC82ABCF46CD258 (matiere_id), PRIMARY KEY(professeur_id, matiere_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE semestre (id INT AUTO_INCREMENT NOT NULL, numsemestre VARCHAR(255) NOT NULL, libellesemestre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, profil_id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, is_active TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), INDEX IDX_8D93D649275ED078 (profil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF9644C85140 FOREIGN KEY (cycles_id) REFERENCES cycle (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F7B706B6D3 FOREIGN KEY (parents_id) REFERENCES parrent (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F735EFF4AD FOREIGN KEY (myclasses_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14C2140342 FOREIGN KEY (eleves_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1499FD2B8D FOREIGN KEY (sems_id) REFERENCES semestre (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1482350831 FOREIGN KEY (matieres_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE professeur_matiere ADD CONSTRAINT FK_FBC82ABCBAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE professeur_matiere ADD CONSTRAINT FK_FBC82ABCF46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649275ED078 FOREIGN KEY (profil_id) REFERENCES role (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F735EFF4AD');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF9644C85140');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14C2140342');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1482350831');
        $this->addSql('ALTER TABLE professeur_matiere DROP FOREIGN KEY FK_FBC82ABCF46CD258');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F7B706B6D3');
        $this->addSql('ALTER TABLE professeur_matiere DROP FOREIGN KEY FK_FBC82ABCBAB22EE9');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649275ED078');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1499FD2B8D');
        $this->addSql('DROP TABLE appreciations');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE cycle');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE parrent');
        $this->addSql('DROP TABLE professeur');
        $this->addSql('DROP TABLE professeur_matiere');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE semestre');
        $this->addSql('DROP TABLE user');
    }
}
