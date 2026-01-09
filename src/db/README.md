# Database Management

This directory contains all database-related files: migrations, seeds, backups, and legacy SQL scripts.

## Directory Structure

```
db/
├── migrations/          # Phinx migration files (schema changes)
├── seeds/              # Phinx seed files (initial/test data)
├── backups/            # Database backup scripts and backup files
└── legacy-sql/         # Old SQL migration files (for reference)
```

## Database Connection

The database connection file is located at `../db.php` (not in this folder) to maintain compatibility with existing code.

## Backups

### Creating a Full Backup

To create a complete backup of your database (structure + data):

```bash
docker exec -it php-app bash
cd /var/www/html/src/db
chmod +x backup-database.sh
./backup-database.sh [optional-backup-name]
```

Backups are saved to `db/backups/backup_YYYYMMDD_HHMMSS.sql`

### Restoring from Backup

```bash
docker exec -it php-app bash
cd /var/www/html/src/db
chmod +x restore-database.sh
./restore-database.sh backups/backup_YYYYMMDD_HHMMSS.sql
```

**Warning:** This will replace all data in the database!

### Exporting Data Only (for Seeds)

To export only data (no CREATE TABLE statements) for use as Phinx seeds:

```bash
docker exec -it php-app bash
cd /var/www/html/src/db
chmod +x export-data-only.sh
./export-data-only.sh
```

This creates a file in `db/seeds/data_export_YYYYMMDD_HHMMSS.sql` that can be used as a Phinx seed.

## Migrations

Database schema changes are managed using Phinx. See the main README in this directory for migration instructions.

### Check Migration Status

```bash
docker exec -it php-app vendor/bin/phinx status -c /var/www/html/src/phinx.yml
```

### Run Migrations

```bash
docker exec -it php-app vendor/bin/phinx migrate -c /var/www/html/src/phinx.yml
```

## Legacy SQL Files

Old SQL migration files are stored in `legacy-sql/` for reference:
- `create-library-tables.sql` - Initial library tables
- `add_library_column.sql` - Added is_library column
- `add_user_id_to_sets.sql` - Added user_id column
- `add_password_column.sql` - Added password column
- `add_set_id_column.sql` - Added set_id column

These are kept for historical reference. New schema changes should use Phinx migrations.

## Git Backup Strategy

To backup your actual database data to git:

### From Host Machine (Recommended)

1. **Create a backup:**
   ```bash
   cd docker/src
   ./db/backup-from-host.sh
   ```

2. **Commit the backup file:**
   ```bash
   git add db/backups/backup_*.sql
   git commit -m "Database backup"
   git push
   ```

3. **Restore from git:**
   ```bash
   git pull
   cd docker/src
   ./db/restore-from-host.sh db/backups/backup_YYYYMMDD_HHMMSS.sql
   ```

### From Inside Container

1. **Create a backup:**
   ```bash
   docker exec -it php-app bash
   cd /var/www/html/src/db
   ./backup-database.sh
   ```

2. **Commit the backup file:**
   ```bash
   git add db/backups/backup_*.sql
   git commit -m "Database backup"
   git push
   ```

3. **Restore from git:**
   ```bash
   git pull
   docker exec -it php-app bash
   cd /var/www/html/src/db
   ./restore-database.sh backups/backup_YYYYMMDD_HHMMSS.sql
   ```

**Note:** Only commit backup files that you want to preserve. Large databases may create large backup files.
