<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181114153043 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE commande_article (commande_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_F4817CC682EA2E54 (commande_id), INDEX IDX_F4817CC67294869C (article_id), PRIMARY KEY(commande_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_article ADD CONSTRAINT FK_F4817CC682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_article ADD CONSTRAINT FK_F4817CC67294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande ADD adresse_facturation_id INT NOT NULL, ADD mode_livraison_id INT NOT NULL, ADD mode_paiement_id INT NOT NULL, ADD user_id INT NOT NULL, ADD reference VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D5BBD1224 FOREIGN KEY (adresse_facturation_id) REFERENCES info_user (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D458F1D6 FOREIGN KEY (mode_livraison_id) REFERENCES mode_livraison (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D438F5B63 FOREIGN KEY (mode_paiement_id) REFERENCES mode_paiement (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D5BBD1224 ON commande (adresse_facturation_id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D458F1D6 ON commande (mode_livraison_id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D438F5B63 ON commande (mode_paiement_id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DA76ED395 ON commande (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE commande_article');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D5BBD1224');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D458F1D6');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D438F5B63');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA76ED395');
        $this->addSql('DROP INDEX IDX_6EEAA67D5BBD1224 ON commande');
        $this->addSql('DROP INDEX IDX_6EEAA67D458F1D6 ON commande');
        $this->addSql('DROP INDEX IDX_6EEAA67D438F5B63 ON commande');
        $this->addSql('DROP INDEX IDX_6EEAA67DA76ED395 ON commande');
        $this->addSql('ALTER TABLE commande DROP adresse_facturation_id, DROP mode_livraison_id, DROP mode_paiement_id, DROP user_id, DROP reference, DROP created_at');
    }
}
